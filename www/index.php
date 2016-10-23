<?php

require_once '../classes/word_processor.php';
require_once 'autoload.php';

class wordProcessorV2 extends wordProcessor {
  
  function parseToLogicalChars($word, $language) {
    $this->word = $word;
    preg_match_all("/\p{{$language}}/u",$word,$matches);
    $this->logical_chars = str_split(implode(array_map( function( $m ) {
      return str_replace('"',"",json_encode($m));
    }, $matches[0])));
    $this->code_points = array_map(function($m) {
      return array(ord($m));
    },$this->logical_chars);    
  }

  public static function compare( $o1, $o2) {
    if( $o1->word != $o2->word ) return false;
    if( $o1->logical_chars != $o2->logical_chars ) return false;
    if( $o1->code_points != $o2->code_points ) return false;
    return true;
  }
  
}



$wp1 = new wordProcessor('పరీక్ష','Telugu');
$wp2 = new wordProcessorV2('పరీక్ష','Telugu');


var_dump($wp1);
var_dump($wp2);
var_dump(wordProcessorV2::compare($wp1,$wp2));

?>