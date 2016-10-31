<?php

class word implements i_word {

  function __construct() {
  
  }
  
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public static function to_html( array $print_array ) {
    shuffle($print_array);
    $out = "<select class='browser-default'>";
    foreach( $print_array as $row ) {
      $out .= sprintf("<option value='%s'>%s</option>",$row['word_id'],$row['word']);
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
    shuffle($print_array);
    return json_encode($print_array,JSON_PRETTY_PRINT);
  }
  
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public static function create( i_table $instance, string $language ) {
    $query = database::get_instance()->prepare("INSERT INTO words (word,language_id) VALUES (:word,(SELECT language_id FROM languages WHERE language_name=:language))");
    $query->bindValue(':word',$word);
    $query->bindValue(':language',$language);
    $query->execute();
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
  public static function read_find( int $position = null, $match, $language ) {
    if( is_null($position) ) {
      $query = database::get_instance()->prepare("SELECT *
          FROM words w
          INNER JOIN languages l ON w.language_id = l.language_id AND l.language_name = :language
          WHERE word LIKE CONCAT( '%', :match, '%' )
          ");
    } else {
      $query = database::get_instance()->prepare("SELECT * 
          FROM words w
          INNER JOIN languages l ON w.language_id = l.language_id AND l.language_name = :language
          WHERE word LIKE CONCAT( REPEAT( '_', :position ), :match, '%' )");
      $query->bindValue(':position',$position,PDO::PARAM_INT);    
    }
    $query->bindValue(':match',$match);
    $query->bindValue(':language',$language);
    
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);      
  }
  
}

?>