<?php

interface i_pair extends i_print, i_table {
  /**
   * Show Pair with a $match at $position
   *
   * @param int $position 0 indexed position to search at
   * @param string $match search string
   * 
   * @return Pair[] array containing matched Pairs
   */
  public static function read_find( $id );
}

?>