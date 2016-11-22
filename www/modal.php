<?php
$query = database::get_instance()->prepare("SELECT * FROM puzzle ORDER BY puzzle_id DESC LIMIT 5");
$query->execute();
$lines = $query->fetchAll(PDO::FETCH_ASSOC); 
?>
<div id="lookup" class="modal bottom-sheet">
  <div class="modal-content container">
    <h5>Recent Puzzles</h5>
    <ul>
    <?php ?>
    <li class='row'>
      <h5 class='col s3 grey-text'>puzzle title</h5>
      <h5 class='col s3 grey-text'>puzzle solution</h5>
      <h5 class='col s6 grey-text'>puzzle link</h5>
    </li>
    <?php foreach( $lines as $line ) : ?>
    <li class='row'>
      <h6 class='col s3'><?php echo $line['puzzle_title'] ?></h6>
      <h6 class='col s3'><?php echo $line['puzzle_solution'] ?></h6>
      <h6 class='col s6'><a href='view.php?id=<?php echo $line['puzzle_id'] ?>'><?php echo $line['puzzle_id'] ?></a></h6>
    </li>
    <?php endforeach ?>
    </ul>
  </div>
</div>

<div id="help" class="modal">
  <div class="modal-content container">
    <h5>Name in Synonym Help</h5>
    <p>Choose a puzzle solution and title. Fill in clues and choose a synonym. You can change more settings on the left hand side. </p>
  </div>
  <div class="modal-footer"></div>
</div>

<div id="info" class="modal">
  <div class="modal-content container">
    <h5>About</h5>
    <p>This puzzle was created by team falcons for ICS499 spring 2016.</p>
  </div>
  <div class="modal-footer"></div>
</div>

<div id="pair" class="modal">
  <div class="modal-content container" style="padding-top:64px">
    
    <form method='post' action='api.php?type=pair'>
      <div class="row">
        <select class="col s4" name='language'>
          <option value='english'>English</option>
          <option value='telugu'>Telugu</option>
        </select>
      </div>
      <div class="row">
        <input class="col s5 validate" name='word_1' type='text' placeholder='word' pattern="^[\S]+$">
        <input class="col s5 offset-s2 validate" name='word_2' type='text' placeholder='synonym' pattern="^[\S]+$">
      </div>
      <input name='type' value='pair' type='hidden'>
      <a href="#!" class="btn-flat right modal-action modal-close">Cancel</a>
      <input class='btn right' type='submit'>      
    </form>
  </div>
  <div class="modal-footer"></div>
</div>