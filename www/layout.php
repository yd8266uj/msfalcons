  <?php $row_count = 20; ?>
  <main>
  
  <ul class='container flow-text show-on-print section'>
    <li>    
      <div class='row'>
        <h5 class='col s4 grey-text'>puzzle title</h5>
        <input type='text' class='puzzle__title col s8' name='title' value='Name in Synonym' maxlength="20">
      </div>
    </li>
    <li>
      <div class='row'>
        <h5 class='col s4 grey-text'>puzzle solution <i class="material-icons hide red-text text-lighten-2 " data-position="top" data-delay="50" data-tooltip="Editing these values will clear chosen solutions">report_problem</i></h5>
        <input type='text' name='solution' class='solution col s8  puzzle__solution' maxlength="20">
        <input type='text' class='col hide s8 puzzle__solution--print'>
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
        <h5 class='col s5 grey-text'>synonyms</h5>
        <h5 class='col s7 grey-text'>clues</h5>
      </div>
    </li>
    <?php for($i=1;$i<=$row_count;$i++): ?>
    <li>
      <div class='row line hide' id='row-<?php echo $i ?>'>
        <input type='hidden' name='pair[]' class='pair_id'>
        <input type='hidden' name='flip[]' class='pair_flip'>
        <input type='hidden' name='column[]' class='pair_column'>
        <div class='col s5 side--left' style='position:relative;display:flex'>
          <input class='side__word' list='l<?php echo $i ?>' autocomplete="off" value=''>
          <div class="progress side__progress hide">
            <div class="indeterminate"></div>
          </div>
          <a class='side__clear btn-flat' onclick="clear_row_left(<?php echo $i ?>)"><i class="material-icons">clear</i></a>
          <datalist id='l<?php echo $i ?>'>
          </datalist>
        </div>
        <div class='col s5 side--right' style='position:relative;display:flex'>
          <div class="progress side__progress hide">
            <div class="indeterminate"></div>
          </div>
          <input class='side__word' list='r<?php echo $i ?>' autocomplete="off" value=''>
          <input class='side__word--print hide'>
          <a class='side__clear btn-flat' onclick="clear_row_right(<?php echo $i ?>)"><i class="material-icons">clear</i></a>
          <datalist id='r<?php echo $i ?>'>
          </datalist>
        </div>
        <div class='col s2'><a class='line__add btn-flat' onclick="post_row(<?php echo $i ?>)"><i class="material-icons medium">add</i></a></div>
      </div>
    </li>
    <?php endfor ?>
    <li>    
      <div class='row'>
        <div class='col s12'>
        <label class='btn'>
          Show Puzzle
          <input class='hide' type="submit" value='submit'>
        </label>
        </div>
      </div>
    </li>
  </ul>

  
  </form>
</main>