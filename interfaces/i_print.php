<?php

interface i_print {
  /**
   * Returns object as an html formatted string
   * 
   * @return string html formatted string
   */
  public function to_html() : string;

  /**
   * Returns object as json formatted string
   * 
   * @return string json formatted string
   */
  public function to_json() : string;
}

?>