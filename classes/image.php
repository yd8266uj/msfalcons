<?php

interface image extends i_print {

  function __construct() {
  
  }
  
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public function to_html() /*: string*/ {}

  /**
   * Returns object as json formatted string
   * 
   * @return string json formatted string
   */
  public function to_json() /*: string*/ {}
  
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public static function save( self $instance ) /*: void*/ {}

  /**
   * Show instance of self from disk specified by $image_name
   *
   * @param valid_string $image_name image name for lookup purposes
   *
   * @return i_image the specified image file
   */
  public static function load( valid_srting $image_name ) /*: i_image*/ {}
}

?>