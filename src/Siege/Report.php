<?php
namespace Siege;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Siege
 * @name        Report
 * @version     0.1
 * @created     2015/11/10 14:34
 */
class Report
{
    const PADDING = 24;

    /**
     * @var string
     */
    protected $log_path;

    /**
     * @var array
     */
    protected $report = array();

    /**
     * @var array
     */
    protected $files;

    /**
     * @description keep track of the comparison bench average
     * @var int
     */
    protected $comparison = 99999999;

    /**
     * SiegeReport constructor.
     *
     * @param string $log_path
     */
    public function __construct($log_path)
    {
        $this->log_path = $log_path;
        $this->files = glob($this->log_path . "/*.log");
    }

    public function display()
    {
        /**
         * number format
         */
        $format = '%8.2f';

        foreach ($this->files as $file) {
            $name = substr(basename($file), 0, -4);

            $this->report[$name] = array(
                'rel' => null,
                'avg' => null
            );

            $data = $this->readFile($file);
            array_shift($data);

            foreach ($data as $key => $val) {
                // save the req/sec
                $i = $key + 1;
                $this->report[$name][(string)$i] = sprintf($format, $val[5]);
            }

            $avg = array_sum($this->report[$name]) / (count($this->report[$name]) - 2); // -2 for rel, avg
            $this->report[$name]['avg'] = sprintf($format, $avg);

            // if this is the symfony1 report, save the comparison value
            if ($name == 'dev') {
                $this->comparison = $avg;
            }
        }

        $this->header();
        $this->output();
    }

    protected function output()
    {
        foreach ($this->report as $key => $val) {
            $val['rel'] = sprintf("%8.4f", $val['avg'] / $this->comparison);
            echo str_pad($key, self::PADDING) . " | " . implode(" | ", $val) . "\n";
        }
    }

    public function readFile($file)
    {
        $list = array();
        $line = 0;
        $handle = fopen($file, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $k = count($data);
            if (!$k) {
                continue;
            }
            for ($i = 0; $i < $k; $i++) {
                $list[$line][$i] = $data[$i];
            }
            $line++;
        }
        fclose($handle);
        return $list;
    }

    protected function header()
    {
        $header = array(
            '     rel',
            '     avg',
            '       1',
            '       2',
            '       3',
            '       4',
            '       5'
        );
        echo str_pad('framework', self::PADDING) . " | " . implode(" | ", $header) . "\n";

        $line = array(
            '--------',
            '--------',
            '--------',
            '--------',
            '--------',
            '--------',
            '--------'
        );
        echo str_pad('', self::PADDING, '-') . " | " . implode(" | ", $line) . "\n";
    }
}
