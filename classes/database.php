<?php

class database implements i_database {

  private static $instance;
  
  /**
   * Restrict access to __construct() to prevent creating new objects
   */
	private function __construct() {
		self::$instance = new PDO( strings::DATABASE_CLASS__DATABASE_INFO, strings::DATABASE_CLASS__DATABASE_USER, strings::DATABASE_CLASS__DATABASE_PASSWORD );
		self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    self::$instance->exec("set names utf8");
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
   * Singleton access to object.
   * 
   * @return self initialized instance of self
   */
  public static function get_instance() {
    if( is_null( self::$instance ) ) {
      new self();
    }
    return self::$instance;
  }
  
}

?>