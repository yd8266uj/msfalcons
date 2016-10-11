<?php

class valid_int implements i_valid {
  
  private $data;
  
  function __construct( int $data ) {
    $this->data = $data; //trivial for ints in later verions of php but we need to check harder in earlier versions. server has 5.5
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

?>