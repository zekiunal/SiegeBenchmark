<?php
namespace Siege;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Siege
 * @name        BenchmarkTest
 * @version     0.1
 * @created     2015/11/10 14:41
 */
class BenchmarkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Benchmark
     */
    protected $benchmark;

    public function setUp()
    {
        $targets = $targets = array(
            'test1'  => 'http://www.google.com',
            'test2' => 'http://www.google.com',
            'test3' => 'http://www.google.com',
        );

        $this->benchmark = new Benchmark($targets);
    }

    public function testFist()
    {
        $this->benchmark->run();
        $this->benchmark->report();
    }
}
