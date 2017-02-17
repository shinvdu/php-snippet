<?php
// http://coffeerings.posterous.com/php-simplexml-and-cdata
class SimpleXMLExtended extends SimpleXMLElement {
  public function addCData($cdata_text) {
    $node = dom_import_simplexml($this); 
    $no   = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
  } 
  public function replaceCData($cdata_text) {
    $node = dom_import_simplexml($this); 
    $no   = $node->ownerDocument; 
    $node->replaceChild($no->createCDATASection($cdata_text), $node->firstChild); 
  } 
}

echo 'Input File: ' . $argv[1];
if (!$argv[1]) {
  exit;
}

$array = convert($argv[1], $argv[2]);
print_r($array);

function orginal_parse($file){
  $xmlstring = file_get_contents($file);
  $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);
  $translations = $array['Items']['Translation'];
  $return = [];
  foreach ($translations as $translation) {
    $return[$translation['Key']] = !is_array($translation['Target']) ? (string)$translation['Target'] : '';
  }
  $freturn = array_filter($return, function($item){
    return trim($item) ? true : false;
  });
  return $freturn; 

}

function output_untranslate($file){
  $xmlstring = file_get_contents($file);
  $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);
  $translations = $array['Items']['Translation'];
  $return = [];
  foreach ($translations as $translation) {
    $return[$translation['Key']] = !is_array($translation['Target']) ? (string)$translation['Target'] : '';
  }
  $freturn = array_filter($return, function($item){
    return trim($item) ? false : true;
  });
  return $freturn; 

}

function convert($file_from, $file_to){
$basename = basename($file_to);
$dirname = dirname($file_to);
$targetFile = $dirname . '/Target_' . $basename;
$content =file_get_contents($file_to);
// $xml = simplexml_load_string($content, "SimpleXMLElement");
$xml = new SimpleXMLExtended($content);

$dom = dom_import_simplexml($xml);
// $xml = dom_import_simplexml($content);
// $xml->item[0]->title = "new value";
// $translations = $xml->Items->Translation;
$m = orginal_parse($file_from);
foreach ($xml->Items->Translation as $tt) {
  // $cdata=$xml->createCDATASection('中文 Target_' . $tt->Target);
  // $tt->Target->replaceChild();
  $key = (string)$tt->Key;
  if (isset($m[$key])) {
    // $tt->Target->replaceCData('中文 Target_' . $tt->Target );
    $tt->Target->replaceCData($m[$key]);
  }

  // $tt->Target->addCData( '中文 Target_' . $tt->Target ) ;
}
file_put_contents($targetFile, $xml->asXML());  
// file_put_contents($targetFile, $dom->saveXML());  
}