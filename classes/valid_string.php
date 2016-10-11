<?php

class valid_string implements i_valid {
  
  private $data;
  
  function __construct( string $data ) {
    
  }
  
  /**
   * Retrieve an already validated piece of data
   *
   * @return 	validated data
   */
  public function get() {
    return $data;
  }
  
}