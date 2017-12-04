<?php
require 'vendor/autoload.php';

use Bhaktaraz\Ghantaghar\Ghantaghar;

printf("अहिले को समय :: %s", Ghantaghar::now());

echo '<br>';

printf("आज को मिति :: %s", Ghantaghar::today());

echo '<br>';

if(Ghantaghar::isWeekend()){
   echo "आज सप्ताहान्त हो। पार्टी!";
}

