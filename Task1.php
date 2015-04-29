<?php

$_GET = [
    'list' => '           12 june 2014


date



         dec 25 2080
',
    'currDate' => '12-01-2015'
];

date_default_timezone_set('Europe/Sofia');
$datesInput = explode("\n", $_GET['list']);

$currDate = date_create($_GET{'currDate'});


/**
 * @var DateTime[] $dates
 */
$dates = [];

foreach ($datesInput as $date) {
    if (date_create($date) !== false
        && date_create($date) != date_create()
    ) {
       $dates[] = date_create($date);
    }
}

sort($dates);
//var_dump($dates);
echo "<ul>";
foreach ($dates as $date) {
    echo "<li>";
    if ($date < $currDate) {
        echo "<em>" . $date->format('d/m/Y') . "</em>";
    } else {
        echo $date->format('d/m/Y');
    }
    echo "</li>";
}
echo "</ul>";
