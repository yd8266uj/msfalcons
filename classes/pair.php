<?php

class pair implements i_pair {

  private $word_1;
  private $word_2;  

  function __construct( $word_1, $word_2 ) {
    $this->word_1 = $word_1;
    $this->word_2 = $word_2;
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
      $out .= sprintf("<option value='%s'>%s</option>",$row['pair_id'],$row['value_name']);
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
   *
   * @throws invalidTypeException on invalid parameter type, ie. not type pair
   * @throws PDOException something bad happened with insertion
   */
  public function create() {
    $query = database::get_instance()->prepare("CALL add_pair(:word_1,:word_2,:language)");
    echo $this->word_1->get_chars();
    $query->bindValue(':word_1',$this->word_1->get_chars());
    $query->bindValue(':word_2',$this->word_2->get_chars());
    $query->bindValue(':language',$this->word_1->get_language());
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
   * Show Pair with a $match at $position
   *
   * @param int $position 0 indexed position to search at
   * @param string $match search string
   * 
   * @return Pair[] array containing matched Pairs
   */
  public static function read_find( $id ) {
    $query = database::get_instance()->prepare("SELECT *
      FROM pairs AS p
      WHERE key_id = :id");
    $query->bindValue(':id',$id,PDO::PARAM_INT);  
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);      
  }
  
}


?>