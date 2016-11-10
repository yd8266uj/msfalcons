<div id="lookup" class="modal bottom-sheet">
  <div class="modal-content container">
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