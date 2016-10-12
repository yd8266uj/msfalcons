<?php

interface i_singleton {
  /**
   * Singleton access to object.
   * 
   * @return self initialized instance of self
   */
  public static function get_instance();
}

?>