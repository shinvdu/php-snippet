<?php
$max = 231;
$rURL = 'https://en.greatfire.org/search/keywords?page=';

function fetchDownload($url){
  $save_file = '/mnt/app/aden/aa.txt';
  $content   = file_get_contents($url);
  $pattern = '#<a href.*?>keyword:(.*?)</a>#';
  preg_match_all($pattern, $content, $match);
// print_r($match);
  foreach ($match[1] as $value) {
    file_put_contents($save_file, trim($value) . "\n", FILE_APPEND);
  }  
}

for ($i=1; $i <= $max; $i++) { 
  $tURL = $rURL . $i;
  echo $tURL . "\n";
  fetchDownload($tURL);
}