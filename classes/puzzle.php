<?php

class puzzle implements i_puzzle {

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
  public static function create( i_table $instance, valid_language $language ) : void {
  
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
  public static function read_show( valid_int $id ) : i_table {
  
  }
  
}

?>