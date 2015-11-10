# SiegeBenchmark
to run siege benchmark easily.

## Introduction
This test suite is based on [a work by Fabien Potencier](https://github.com/fabpot/framework-benchs).

## Run

```php
<?php
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', true);
date_default_timezone_set('Europe/Istanbul');

$targets = array(
    'Worldwide'       => 'http://www.google.com.tr',
    'AscensionIsland' => 'http://www.google.ac',
    'Canada'          => 'http://www.google.ca',
    'China'           => 'http://ww.g.cn',
    'Turkey'          => 'http://www.google.com.tr',
);

$options = array(
    'concurrent' => '10',
    'time'       => '10s',
);

$bench = new \Siege\Benchmark($targets, $options);
$bench->run();
$bench->report();

```

## Raw results

    platform                 |      rel |      avg |        1 |        2 |        3
    ------------------------ | -------- | -------- | -------- | -------- | --------
    Worldwide                |   9.6251 |   373.87 |   369.49 |   373.75 |   378.36
    AscensionIsland          |   2.2480 |    87.32 |    86.25 |    87.78 |    87.94
    Canada                   |   1.7970 |    69.80 |    69.64 |    70.71 |    69.04
    China                    |   1.6106 |    62.56 |    60.92 |    62.73 |    64.03
    Turkey                   |   1.2769 |    49.60 |    48.41 |    50.60 |    49.80