<?php

$str = @$_POST['q'];
$next = 0;
echo grapheme_strlen($str);
do {
$out = grapheme_extract($str, 4, GRAPHEME_EXTR_MAXCHARS , $next, $next);
$next2 = 0;
  do {
    $out2 = grapheme_extract($out, 2, GRAPHEME_EXTR_MAXCHARS , $next2, $next2);
    echo 'grapheme: '.$out2.' encoded:'.json_encode($out2).' length: '.grapheme_strlen($out2).'<br>';
    
  } while($out2);
echo 'grapheme: '.$out.' encoded:'.json_encode($out).' length: '.grapheme_strlen($out).'<br>';
} while($out);

?>

<form method="post">
  <input type="text" name="q">
  <input type="submit">
</form>