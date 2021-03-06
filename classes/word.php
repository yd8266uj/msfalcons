<?php

class word implements i_word {
  private $word;
  private $language;

  function __construct( $word, $language ) {
    if(empty($word)) throw new Exception();
    $word = iconv(mb_detect_encoding($word),'UTF-8',$word);
    $this->word = $word;
    $this->language = $language;
  }
  
  function get_language() {
    return $this->language;
  }
  
  function get_word() {
    return $this->word;
  }
  
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public static function to_html( array $print_array ) {
    /*
    array_map($print_array, function($o) {
      if(!($o instanceof word)) throw new Exception();
    });
    */
    shuffle($print_array);
    $out = "<select class='browser-default'>";
    foreach( $print_array as $row ) {
      $out .= sprintf("<option value='%s'>%s</option>",$row['word_id'],$row['word_name']);
    }
    $out .= "</select>";
    return $out;
  }

  /**
   * Returns object as json formatted string
   * 
   * @return string json formatted string
   */
  public static function to_json( array $print_array ) {
    /*
    array_map($print_array, function($o) {
      if(!($o instanceof word)) throw new Exception();
    });
    */
    shuffle($print_array);
    return json_encode(array_slice($print_array,0,10),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
  }
  
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public function create() {
    $chars = $this->get_chars();
    $query = database::get_instance()->prepare("CALL add_word(:word,:language,@void)");
    $query->bindValue(':word',$chars);
    $query->bindValue(':language',$this->language);
    $query->execute();
  }
  
  public function get_chars() {
    /*
    switch($this->language) {
      case 'telugu':
        $pattern = "/(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}](?!\pL))|(?:[\x{0c05}-\x{0c14}][\x{0c01}-\x{0c03}]?)|(?:(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}])*[\x{0c15}-\x{0c39}\x{200c}][\x{0c3e}-\x{0c4c}]?[\x{0c01}-\x{0c03}]?[\x{200c}]?)/u";
        break;
      case 'english':
      default:
        $pattern = "/\p{Latin}/u";
    }
    preg_match_all($pattern,$this->word,$matches);
    */
    $chars = (new wordProcessor($this->word,$this->language))->getLogicalChars();
    return str_replace('["','',str_replace('"]','',str_replace('","',';',json_encode($chars,JSON_UNESCAPED_UNICODE))));
  }

  /**
   * List all available self in database
   *
   * @return self[] array of instantiated self objects
   */
  public static function read_list( string $language ) {
  }

  /**
   * Show instance of self in database specified by $puzzle_id
   *
   * @param int $puzzle_id Puzzle identifier for lookup purposes
   *
   * @return Puzzle the specified Puzzle object
   */
  public static function read_show( int $id ) {
  }
  
  /**
   * Show Word with a $match at $position
   *
   * @param int $position 0 indexed position to search at
   * @param string $match search string
   * 
   * @return word[] array containing matched Pairs
   */
   
   /*
SELECT w.word_id,GROUP_CONCAT(wc.char_name ORDER BY wc.char_index ASC SEPARATOR '') AS word_language,w.word_language 
FROM (
  SELECT wc.word_id
  FROM word_char wc
  WHERE wc.char_name = :match AND wc.char_index = :position
  ) AS wid
JOIN word_char wc on wc.word_id = wid.word_id
JOIN word w on w.word_id = wid.word_id
GROUP BY w.word_id,w.word_language
HAVING count(*)>:min AND count(*)<:max
   */
  public static function read_find(  $char_index = 0, $char_name, $language = 'english', $min = 1, $max = 20 ) {
    $query = database::get_instance()->prepare("CALL find_word(:char_name,:char_index,:language,:min,:max)");
    $query->bindValue(':char_name',$char_name);
    $query->bindValue(':char_index',$char_index,PDO::PARAM_INT);  
    $query->bindValue(':language',$language);    
    $query->bindValue(':min',$min);    
    $query->bindValue(':max',$max);    
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);      
  }
  
}

?>