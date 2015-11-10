<?php
namespace Siege;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Siege
 * @name        Benchmark
 * @version     0.1
 * @created     2015/11/10 14:34
 */
class Benchmark
{
    /**
     * @var array
     */
    protected $targets;

    /**
     * @var string
     */
    protected $log_path;

    /**
     * @description test repeat count.
     *
     * @var int
     */
    protected $repeat;

    /**
     * @var string
     */
    protected $config_file = "/tmp/.siege-config";

    protected $options = array(
        'verbose'      => 'false',
        'show-logfile' => 'false',
        'logging'      => 'true',
        'protocol'     => 'HTTP/1.0',
        'chunked'      => 'true',
        'connection'   => 'close',
        'concurrent'   => '10',
        'time'         => '2s',
        'benchmark'    => 'true',
        'spinner'      => 'false',
    );

    /**
     * SiegeBench constructor.
     *
     * @param array $targets
     * @param array $options
     * @param int   $repeat
     */
    public function __construct($targets, $options = array(), $repeat = 3)
    {
        $this->targets = $targets;
        $this->options = array_merge($this->options, $options);
        $this->repeat = $repeat;
        $time = date("Y-m-d-H:i:s");
        $this->log_path = "./log/" . $time;
        passthru("mkdir -p " . $this->log_path);
    }

    /**
     * run already defined tests.
     */
    public function run()
    {
        foreach ($this->targets as $name => $url) {
            $options['logfile'] = $this->log_path . '/' . $name . '.log';

            $this->config($options);

            passthru("curl " . $url);

            for ($i = 1; $i <= $this->repeat; $i++) {
                echo $name . ": pass " . $i . "\n";
                passthru("siege --rc=" . $this->configFile() . ' ' . $url);
                echo "\n";
            }
        }
    }

    /**
     * @description update configuration
     *
     * @param array $options
     */
    protected function config(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @description create configuration file from defined configuration options
     *
     * @return string
     */
    protected function configFile()
    {
        $text = '';
        foreach ($this->options as $key => $val) {
            $text .= $key . " =  " . $val . "\n";
        }

        file_put_contents($this->config_file, $text);
        return $this->config_file;
    }

    /**
     * export report
     */
    public function report()
    {
        $reporter = new Report($this->log_path, $this->repeat);
        $reporter->display();
    }
}
