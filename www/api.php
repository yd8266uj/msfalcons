<?php  
  include 'autoload.php';  
  
  mb_internal_encoding("UTF-8");
  
  switch(@$_POST['type']) {
    case 'word':  
      $word = @html_entity_decode($_POST['word']);
      $language = @$_POST['language'];
      try {
        (new word($word,$language))->create();
      } catch (Exception $e) {
      
      } finally {
        echo json_encode($out);
        die();
      }
      break;
    case 'pair':
      $word_1 = new word(html_entity_decode($_POST['word_1']),$_POST['language']);
      $word_2 = new word(html_entity_decode($_POST['word_2']),$_POST['language']);      
      try {
        (new pair($word_1,$word_2))->create();
        $out = array("message"=>"pair added");
      } catch (Exception $e) {
        $out = array("error"=> $e->getMessage());
      } finally {   
        echo json_encode($out);      
        die();
      }
      break;
  }
  
  header('Content-Type:application/json;charset=utf-8');

  switch(@$_GET['type']) {
    case 'word':
      $position = @$_GET['pos'];
      $character = @html_entity_decode($_GET['char']);
      $min = @$_GET['min'];
      $max = @$_GET['max'];
      $language = @$_GET['lang']?$_GET['lang']:'english';
      echo word::to_json(word::read_find($position,$character,$language,$min,$max));      
      break;
    case 'pair':
      $word = @html_entity_decode($_GET['word']);
      echo pair::to_json(pair::read_find($word));
      break;
    case 'split':
      $word = @html_entity_decode($_GET['word']);
      $language = @$_GET['lang'];
      $chars = (new wordProcessor($word,$language))->getLogicalChars();
      echo json_encode($chars,JSON_UNESCAPED_UNICODE);
      /*
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
      }*/
      //preg_match_all($pattern,$word,$matches);
      //echo json_encode($matches[0],JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
      break;      
  }
  die();
?>