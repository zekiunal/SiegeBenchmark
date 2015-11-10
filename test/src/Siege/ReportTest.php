<?php
namespace Siege;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Siege
 * @name        ReportTest
 * @version     0.1
 * @created     2015/11/10 14:40
 */
class ReportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Report
     */
    protected $report;

    public function setUp()
    {
        $path = '';
        $this->report = new Report($path);
    }

    public function testFist()
    {
        $this->assertTrue(true);
    }
}
