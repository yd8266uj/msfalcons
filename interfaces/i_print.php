<?php

interface i_print {
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public static function to_html( array $print_array ) : string;

  /**
   * Returns object as json formatted string
   * 
   * @return string json formatted string
   */
  public static function to_json( array $print_array ) : string;
}

?>