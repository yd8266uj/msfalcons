<?php

class pair implements i_pair {

  function __construct() {
  
  }
  
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public static function to_html( array $print_array ) : string {
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
  public static function to_json( array $print_array ) : string {
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
  public static function create( i_table $instance, string $language ) : void {
  
  }
  
  /**
   * List all available self in database
   *
   * @return self[] array of instantiated self objects
   */
  public static function read_list( string $language ) : array {
  
  }

  /**
   * Show instance of self in database specified by $puzzle_id
   *
   * @param int $puzzle_id Puzzle identifier for lookup purposes
   *
   * @return Puzzle the specified Puzzle object
   */
  public static function read_show( int $id ) : i_table {
  
  }
  
  /**
   * Show Pair with a $match at $position
   *
   * @param int $position 0 indexed position to search at
   * @param string $match search string
   * 
   * @return Pair[] array containing matched Pairs
   */
  public static function read_find( int $id ) : array {
    $query = database::get_instance()->prepare("SELECT value_name,pair_id,flip
      FROM pairs AS p
      WHERE key_id = :id");
    $query->bindValue(':id',$id,PDO::PARAM_INT);  
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);      
  }
  
}


?>