<?php

class language {

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
   * Singleton access to object.
   * 
   * @return self initialized instance of self
   */
  public static function getInstance() : self {
    if( is_null( self::$instance ) ) {
      new self();
    }
    return self::$instance;
  }
  
  /**
   * Returns a validated language string
   *
   * @return string validated language
   */
  public function validate( valid_string $localize ) : valid_laguage {
  
  }
}

?>