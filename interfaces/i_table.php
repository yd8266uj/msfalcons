<?php

interface i_table {
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public function create();

  /**
   * List all available self in database
   *
   * @return self[] array of instantiated self objects
   */
  public static function read_list( string $language );

  /**
   * Show instance of self in database specified by $puzzle_id
   *
   * @param int $puzzle_id Puzzle identifier for lookup purposes
   *
   * @return Puzzle the specified Puzzle object
   */
  public static function read_show( int $id );
}

?>