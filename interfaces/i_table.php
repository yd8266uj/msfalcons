<?php

interface i_table {
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public static function create( self $instance, valid_language $language ) : void;

  /**
   * List all available self in database
   *
   * @return self[] array of instantiated self objects
   */
  public static function read_list( valid_language $language ) : array;

  /**
   * Show instance of self in database specified by $puzzle_id
   *
   * @param int $puzzle_id Puzzle identifier for lookup purposes
   *
   * @return Puzzle the specified Puzzle object
   */
  public static function read_show( valid_int $id ) : i_table;
}

?>