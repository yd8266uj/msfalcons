<?php

class pair implements i_pair {

  function __construct() {
  
  }
  
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public function to_html() : string {
  
  }

  /**
   * Returns object as json formatted string
   * 
   * @return string json formatted string
   */
  public function to_json() : string {
  
  }
  
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public static function create( self $instance, valid_language $language ) : void {
  
  }

  /**
   * List all available self in database
   *
   * @return self[] array of instantiated self objects
   */
  public static function read_list( valid_language $language ) : array {
  
  }

  /**
   * Show instance of self in database specified by $puzzle_id
   *
   * @param int $puzzle_id Puzzle identifier for lookup purposes
   *
   * @return Puzzle the specified Puzzle object
   */
  public static function read_show( valid_int $id ) : self {
  
  }
  
  /**
   * Show Pair with a $match at $position
   *
   * @param int $position 0 indexed position to search at
   * @param string $match search string
   * 
   * @return Pair[] array containing matched Pairs
   */
  public static function read_find( valid_int $position, valid_string $match, valid_language $language ) : array {
    
  }
  
}

?>