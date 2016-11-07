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
<!--
https://www.w3.org/International/docs/indic-layout/

https://regex101.com/r/Tmt85l/1
https://regex101.com/delete/XVhMEqFEbGdF5fGfYa2TaINa

V[m]|{CH}C[v][m]|CH

V(upper case) is independent vowel

m is modifier(Anusvara/Visarga/Chandrabindu)

C is a consonant as per Unicode's definition which may or may not include a single nukta	

v (lower case) is any dependent vowel or vowel sign (mātrā)

H is halant / virama

| is a rule separator

[ ] - The enclosed items is optional under this bracket

{} - The enclosed item/items occurs zero or repeated multiple times

(?:[\x{0c05}-\x{0c14}][\x{0c01}-\x{0c03}]?)|
(?:(?:[\x{0c15}-\x{0c39}][\x{0c4d}])*[\x{0c15}-\x{0c39}][\x{0c3e}-\x{0c4c}]?[\x{0c01}-\x{0c03}]?)|
(?:[\x{0c15}-\x{0c39}][\x{0c4d}]$)

-->