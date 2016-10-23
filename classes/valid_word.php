<?php

class valid_word implements i_valid {
  
  private $data;
  
  function __construct( string $data ) {
    if (!preg_match('/^(\p{Telugu}+|\p{Latin}+)$/u',$data)) throw new invalidArgumentException();
    $this->data = $data;
  }
  
  /**
   * Retrieve an already validated piece of data
   *
   * @return 	validated data
   */
  public function get() {
    return $this->data;
  }
}

?>