<?php

class database {

  private static $instance;
  
	function __construct() {
		parent::__construct( Strings::DATABASE_CLASS__DATABASE_INFO, Strings::DATABASE_CLASS__DATABASE_USER, Strings::DATABASE_CLASS__DATABASE_PASSWORD );
		$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		self::$instance = $this;
	}
  
  /**
   * Restrict access to clone()
   */
	private function __clone() {}
  
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
  
}

?>