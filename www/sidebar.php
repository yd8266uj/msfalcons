 <!-- config -->
    <ul id="slide-out" class="side-nav fixed">
      <li class='logo'>
        <a id="logo-container" href="#!" class="brand-logo" style='height:64px'>
          <img class="responsive-img" src="img/silcHeader.png" style="max-height:100%">
        </a>
      </li>
      <li>
        <ul class="collapsible">
          <li>
            <div class="collapsible-header active">
              <a href="#!">Basic Options</a>
            </div>
            <!-- __solution -->	
            <div class="collapsible-body">			
              <div class="input-field">
                <input placeholder="Chrysanthimum" id="" type="text" class="validate config__solution">
                <label for="first_name">Puzzle Solution</label>
              </div>
              <!-- __language -->
              <select name="language" class="config__language browser-default">
                <option value="" disabled selected>Choose your option</option>
                <option value="english">English</option>
                <option value="telugu">Telugu</option>
                <option value="spanish">Spanish</option>
              </select>									
        
            </div>	
          </li>
          <!-- __image -->
          <li>
            <div class="collapsible-header">
              <a href="#!">Image Options</a>
            </div>						
            <div class="collapsible-body">
              <input name="config__image" type="radio" id="config__image_radio--none" checked value="0"/>
              <label for="config__image_radio--none">None</label>						
              <br>

              <input name="config__image" type="radio" id="config__image_radio--url" value="1"/>
              <label for="config__image_radio--url">Url</label>

              <div class="input-field">
                <input placeholder="" type="url" class="validate" disabled>
              </div>
              <input name="config__image" type="radio" id="config__image_radio--upload" value="2"/>
              <label for="config__image_radio--upload">Upload</label>

              <div class="file-field input-field">
                <div class="btn" style="float:none" disabled>
                  <span>File</span>
                  <input type="file">
                </div>
                <div class="file-path-wrapper hide">
                  <input class="file-path validate" type="text" >
                </div>
              </div>
              <div class="config__image_img hide">
                <img class="responsive-img" src="cool_pic.jpg">			
              </div>
            </div>
          </li>
          <!-- __format -->
          <li>
            <div class="collapsible-header">
              <a href="#!">Format Options</a>
            </div>						
            <div class="collapsible-body">		
              
              <div>
                <h6 class="grey-text">Align Characters</h6>
              </div>
              <div>
                <input name="puzzle-format" type="radio" id="config__format_radio--align" />
                <label for="config__format_radio--align">Align</label>
                <br>
                <input name="puzzle-format" type="radio" id="config__format_radio--justify" checked />
                <label for="config__format_radio--justify">Justify</label>
              </div>
              <!-- __difficulty -->

              <div>
                <h6 class="grey-text">Number of characters</h6>
              </div>
              <div class="input-field ">
                <p class="range-field">
                  <div id="config__number_of_characters"></div>
                </p>
              </div>
              
              <div>
                <h6 class="grey-text">Column preference</h6>
              </div>
 
              <div class="switch config__toggle_column">
                <label>
                  random
                  <input type="checkbox">
                  <span class="lever"></span>
                  choose
                </label>
              </div>
              <div class="input-field ">
                <p class="range-field">
                  <div id="config__column_preference"></div>
                </p>
              </div>

                  
            </div>
          </li>
          <li>
            <div class="collapsible-header">
              <a href="#!">Choose Solutions</a>
            </div>						
            <div class="collapsible-body config__tabs">
              <ul class="tabs">
              </ul>
            </div>
          </li>
          <li>
            <a href="#!" class="btn white-text" style="">Update</a>
          </li>
        </ul>
      </li>
    </ul>