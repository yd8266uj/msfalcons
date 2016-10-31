<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  include 'autoload.php';
  
  if (@$_GET['format']=='html') {
  } else {
    header('Content-Type:application/json;charset=utf-8');
  }
  
  switch($_GET['type']) {
    case 'word':
      $position = @$_GET['pos'];
      $character = @$_GET['char'];
      $language = @$_GET['lang']?$_GET['lang']:'english';
      echo @$_GET['format']=='html'?word::to_html(word::read_find($position,$character,$language)):word::to_json(word::read_find($position,$character,$language));      
      break;
    case 'pair':
      $id = @$_GET['id'];
      echo @$_GET['format']=='html'?pair::to_html(pair::read_find($id)):pair::to_json(pair::read_find($id));
      break;
  }
?>