<?php

interface i_image extends i_print {
  /**
   * Insert a new entry into database from and instance of self
   *
   * @param self $instance
   */
  public static function create( self $instance ) : void;

  /**
   * Show instance of self from disk specified by $image_name
   *
   * @param valid_string $image_name image name for lookup purposes
   *
   * @return i_image the specified image file
   */
  public static function read_show( valid_srting $image_name ) : i_image;
}

?>