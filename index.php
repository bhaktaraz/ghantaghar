<?php
require 'vendor/autoload.php';

use Bhaktaraz\Ghantaghar\Ghantaghar;

printf("अहिले को समय :: %s", Ghantaghar::now());

echo '<br><br>';

printf("अहिले को समय (w D, m Y h:i:s) :: %s", Ghantaghar::now('w D, m Y h:i:s'));

echo '<br><br>';

printf("अहिले को समय (w D, m Y) :: %s", Ghantaghar::now('w D, m Y'));

echo '<br><br>';

printf("अहिले को समय (h:i:s) :: %s", Ghantaghar::now('h:i:s'));

echo '<br><br><hr><br>';

printf("आज को मिति :: %s", Ghantaghar::today());

echo '<br><br>';

printf("आज को मिति (w D, m Y h:i:s) :: %s", Ghantaghar::today('w D, m Y h:i:s'));

echo '<br><br><hr><br>';

echo "इस्बि सम्बत 2019-11-27 बाट बिक्रम सम्बत मा परिवर्तन गर्दा :: ";
print_r(Ghantaghar::convertDateToBs("2019-11-27"));

echo '<br><br>';

echo "इस्बि सम्बत 2019-11-27 01:15:00 बाट बिक्रम सम्बत (w D, m Y h:i:s) मा परिवर्तन गर्दा :: ";
print_r(Ghantaghar::convertDateToBs("2019-11-27 01:15:00", 'w D, m Y h:i:s'));

echo '<br><br>';

echo "इस्बि सम्बत 2019-11-27 बाट बिक्रम सम्बत (Y m d w) मा परिवर्तन गर्दा :: ";
print_r(Ghantaghar::convertDateToBs("2019-11-27", 'Y m d w'));

echo '<br><br>';

if(Ghantaghar::isWeekend()){
   echo "आज सप्ताहान्त हो। पार्टी!";
}

