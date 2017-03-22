<?php

$file = '/mnt/app/altimav/themes/ementy/templates/bb.txt';

$content = file_get_contents($file);

$rows = explode("\n", $content);
$vrows = array_reverse($rows);

// print_r($vrows);
foreach ($vrows as $row) {
	echo $row . "\n";
}