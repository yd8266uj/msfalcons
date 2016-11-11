<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
((?:\s)|(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}](?!\pL))|(?:[\x{0c05}-\x{0c14}][\x{0c01}-\x{0c03}]?)|(?:(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}])*[\x{0c15}-\x{0c39}\x{200c}][\x{0c3e}-\x{0c4c}]?[\x{0c01}-\x{0c03}]?[\x{200c}]?))(?=(?:\s)|(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}](?!\pL))|(?:[\x{0c05}-\x{0c14}][\x{0c01}-\x{0c03}]?)|(?:(?:[\x{0c15}-\x{0c39}\x{200c}][\x{0c4d}])*[\x{0c15}-\x{0c39}\x{200c}][\x{0c3e}-\x{0c4c}]?[\x{0c01}-\x{0c03}]?[\x{200c}]?))
([a-z])(?=[a-z]+\")
  
  include 'autoload.php';
  include 'header.php';
  include 'sidebar.php';
  include 'display.php';
  include 'modal.php';
  include 'footer.php';

?>