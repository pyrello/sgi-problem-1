<?php

require_once('PeopleManager.php');

$path_to_file = './data/people.csv';

$manager = new PeopleManager($path_to_file);

$counts = $manager->getPeopleAliveYearsByCount();

$highest = max(array_keys($counts));

if ($highest === 0)
{
    print "Check your data, there appears to be an error :|";
}
else
{
    $years = $counts[$highest];
    if (count($years) > 1)
    {
        print "Years with the most people alive: " . implode(', ', $years);
    }
    elseif (count($years) === 1)
    {
        print "Year with the most people alive: " . $years[0];
    }
}
