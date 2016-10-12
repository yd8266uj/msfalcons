<?php

class language implements i_language {

  private static $instance;

  /**
   * Restrict access to __construct() to prevent creating new objects
   */
  private function __construct() {
  
  }
  
  /**
   * Restrict access to clone() to prevent copying of object
   */
	private function __clone() {}
  
  /**
   * Restrict access to wakeup() to prevent deserializing object
   */
	private function __wakeup() {}
  
  
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
  public static function get_instance() : i_singleton {
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