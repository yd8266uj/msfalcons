<?php
include 'autoload.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $puzzle_title = $_POST['title'];
  $puzzle_solution = $_POST['solution'];

  $puzzle_id = uniqid();
  $pair_id = $_POST['pair'];
  $pair_flip = $_POST['flip'];
  $pair_column = $_POST['column'];
  $pairs = array();
  for($i=0;$i<20;$i++) {
    $pairs[$i] = array(
      "pair_id" => $pair_id[$i],
      "pair_flip" => $pair_flip[$i],
      "pair_column" => $pair_column[$i],
    );   
  }  
  $query = database::get_instance()->prepare("INSERT INTO puzzle VALUES(:puzzle_id,:puzzle_solution,:puzzle_title)");
  $query->bindValue(':puzzle_id',$puzzle_id);  
  $query->bindValue(':puzzle_solution',$puzzle_solution);  
  $query->bindValue(':puzzle_title',$puzzle_title);  
  $query->execute();
  foreach($pairs as $i => $line) {
    $query = database::get_instance()->prepare("INSERT INTO puzzle_line
      VALUES(:puzzle_id,:puzzle_line_order,:pair_id,:puzzle_line_column,:puzzle_line_flip)");
    $query->bindValue(':puzzle_id',$puzzle_id);    
    $query->bindValue(':puzzle_line_order',$i,PDO::PARAM_INT); 
    $query->bindValue(':pair_id',$line['pair_id'],PDO::PARAM_INT);  
    $query->bindValue(':puzzle_line_column',$line['pair_column'],PDO::PARAM_INT);  
    $query->bindValue(':puzzle_line_flip',$line['pair_flip'],PDO::PARAM_INT);  
    try {
      $query->execute();
    } catch ( Exception $e ){
      continue;
    }
  }
  header("Location: view.php?id=$puzzle_id",301);
  die();
}
?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'GET') :?>
<?php 
  $query = database::get_instance()->prepare("SELECT * FROM puzzles where puzzle_id=:puzzle_id");
  $query->bindValue(':puzzle_id',$_GET['id']);    
  $query->execute();
  $lines = $query->fetchAll(PDO::FETCH_ASSOC);   
?>
<!DOCTYPE html>
<html>
	<head>
    <title>SILC - Name in Synonym</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/silc.ico" />
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="css/nouislider.min.css">
		<link rel="stylesheet" href="css/materialize.css">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
      .letter-box {
        font-family: monospace;
        width: 36px;
        display: inline-block;
        padding-left: 4px;
        padding-right: 4px;
        border: solid gray 1px;
      }
      .letter-box--highlight {
        border: solid black 2px;
      }
      #show-solution:not(:checked) ~ ul .show-solution {
        color: rgba(0,0,0,0);
      }
      
      @media print {
        #show-solution + label {
          display:none;
        }
      }
    </style>
  </head>
	<body class="">
  <main class='container'>
  <input type="checkbox" id="show-solution" checked="checked" />
  <label for="show-solution">Show solutions</label>
  <ul class='flow-text show-on-print section'>
    <li>
      <div class='row'>
        <h5 class='col s4 grey-text'>puzzle title</h5>
        <h5 class='col s8'><?php echo @$lines[0]['puzzle_title'] ?></h5>
      </div>
    </li>
    <li>
      <div class='row'>
        <h5 class='col s4 grey-text'>puzzle solution</h5>
        <h5 class='col s8 show-solution'><?php echo @$lines[0]['puzzle_solution'] ?></h5>      
      </div>
    </li>
    <li>
     <div class='row image__wrapper'>
      <div class='col s12'>
        <img class='center image responsive-img' style='max-height:200px;'>
      </div>
     </div>
    </li>
    <li>
      <div class='row'>
        <h5 class='col s4 grey-text'>synonyms</h5>
        <h5 class='col s8 grey-text'>clues</h5>
      </div>
    </li>
    <?php foreach($lines as $line): ?>
    <li>
      <div class='row line'>
        <div class='col s4 side--left' style='position:relative;display:flex'>
          <h5><?php echo $line['value_name'] ?></h5>
        </div>
        <div class='col s8 side--right' style='position:relative;display:flex'>
          <h5>
          <?php foreach( (new wordProcessor($line['key_name'],$line['language_name']))->getLogicalChars() as $i => $char ) : ?>
            <span class='show-solution letter-box<?php echo $line['puzzle_line_column']==$i?' letter-box--highlight':'' ?>'><?php echo $char ?></span>
          <?php endforeach ?>
          </h5>
        </div>
      </div>
    </li>
    <?php endforeach ?>
  </ul>
  </main>
<?php endif ?>
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script src="js/materialize.min.js"></script>
  </body>
</html>