<?php  
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include 'autoload.php';
  
  
  switch(@$_POST['type']) {
    case 'word':  
      $word = @$_POST['word'];
      $language = @$_POST['language'];
      try {
        (new word($word,$language))->create();
      } catch (Exception $e) {
      
      } finally {
        die();
      }
      break;
    case 'pair':
      $word_1 = @$_POST['word_1'];
      $word_2 = @$_POST['word_2'];
      $language = @$_POST['language'];
      try {
        (new pair(new word($word_1,$language),new word($word_2,$language)))->create();
      } catch (Exception $e) {
        echo $e->getMessage();
      } finally {
        header('Location: index.php',301);
        die();
      }
      break;
  }
  
  if (@$_GET['format']=='html') {
  } else {
    header('Content-Type:application/json;charset=utf-8');
  }
  
  switch(@$_GET['type']) {
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
    case 'split':
      $word = @$_GET['word'];
      $language = @$_GET['lang'];
      $chars = (new wordProcessor($word,$language))->getLogicalChars();
      echo json_encode($chars,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
      switch(@$_GET['lang']) {
        case 'telugu':
          $pattern = "/(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}](?!\pL))|(?:[\x{0c05}-\x{0c14}][\x{0c01}-\x{0c03}]?)|(?:(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}])*[\x{0c15}-\x{0c39}\x{200c}][\x{0c3e}-\x{0c4c}]?[\x{0c01}-\x{0c03}]?[\x{200c}]?)/u";
          break;
        case 'korean':
          $pattern = "/\p{Hangul}/u";
          break;
        case 'english':
        default:
          $pattern = "/\p{Latin}/u";
      }
      preg_match_all($pattern,$word,$matches);
      //echo json_encode($matches[0],JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
      break;      
  }
?>