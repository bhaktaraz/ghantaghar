<?php
require 'vendor/autoload.php';

use Bhaktaraz\Ghantaghar\Ghantaghar;

$ghantaghar = new Ghantaghar();

printf("Right now is %s", $ghantaghar->now());

printf('<br/>');

printf("Right now in text format is %s", $ghantaghar->now('text'));