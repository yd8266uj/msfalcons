<?php

interface i_language extends i_print, i_singleton {
  /**
   * Returns a validated language string
   *
   * @return string validated language
   */
  public function validate( valid_string $localize ) : valid_laguage;
}

?>