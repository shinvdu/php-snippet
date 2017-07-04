<?php


// $reg = '#\\<VirtualHost \\*:8080\\>(.+?)\\</VirtualHost\\>#';
// $reg = '#\\<VirtualHost \\*:8080\\>#';
// $reg = '#\\</VirtualHost\\>#';
// $reg = '#\\<VirtualHost \\*:8080\\>.*?ServerName (.*?)$.*?\\</VirtualHost\\>#is';
$reg = '#\\#(.+?)\\<VirtualHost \\*:8080\\>.+?</VirtualHost\\>#is';
// $reg = '#\\<VirtualHost \\*:8080\\>.+?</VirtualHost\\>#is';
// $reg = '#\\#(.+?)\\#\\<VirtualHost \\*:8080\\>.+?\\#</VirtualHost\\>#is';

$file = file_get_contents('vhosts');
// echo $file;

$match = [];
// preg_match_all($reg, $file, $match);
preg_match_all($reg, $file, $matchs);
// print_r($matchs);
// exit(0);

$pms = $matchs[0];

// print_r($pms);
$name_reg = '#ServerName (.+)?#i';
foreach ($pms as $pm) {
	preg_match_all($name_reg, $pm, $xie);
	$domain  = $xie[1][0];
	// print_r($domain);
	file_put_contents('sites/' . $domain, $pm);
}


