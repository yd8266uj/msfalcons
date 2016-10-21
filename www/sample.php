<?php
$puzzle_solution = "apple";
$puzzle_language = "english";
$puzzle_image = "https://upload.wikimedia.org/wikipedia/commons/1/15/Red_Apple.jpg";
$puzzle_lines = array();
//these should actually be pair objects
array_push($puzzle_lines,array("flip" => 0,"offset" => 1,"word_1" => "sum","word_2" => "add"));
array_push($puzzle_lines,array("flip" => 1,"offset" => 6,"word_1" => "multiple","word_2" => "many"));
array_push($puzzle_lines,array("flip" => 0,"offset" => 1,"word_1" => "throw","word_2" => "pass"));
array_push($puzzle_lines,array("flip" => 0,"offset" => 3,"word_1" => "store","word_2" => "file"));
array_push($puzzle_lines,array("flip" => 0,"offset" => 2,"word_1" => "choose","word_2" => "select"));
?>

<!-- puzzle->to_html(), an included file probably -->
<div class="display">
  <div class="display__puzzle-solution">
  <?php echo $puzzle_solution ?>
  </div>
  <div class="display__puzzle-language">
  <?php echo $puzzle_language ?>
  </div>
  <img class="display__puzzle-image" src="<?php echo $puzzle_image ?>">
  <ul class="display__puzzle-lines">
  <!-- li for each $puzzle_lines -->
  <?php foreach( $puzzle_lines as $pair ) : ?>
    <li class="display__puzzle-line puzzle-line">
      <!-- should be replaced by $pair->to_html() -->
      <div class="puzzle-line__clue">
      <?php echo $pair["flip"] ? $pair["word_2"] : $pair["word_1"] ?>
      </div>
      <div class="puzzle-line__synonym puzzle-line__synonym--offset-<?php echo $pair["offset"]?>">
      <!-- 
      -- if this was the word "multple" from above. I would want this to output:
      -- multi<span class="red">p</span>le
      -- instead of:
      -- multiple
      -->
      
      <?php echo $pair["flip"] ? $pair["word_1"] : $pair["word_2"] ?>
      </div>
    </li>
  <?php endforeach ?>
  </ul>
</div>