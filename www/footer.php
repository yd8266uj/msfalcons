<footer></footer>
    <script type="text/javascript" src="js/d3.v4.min.js"></script>
    <script type="text/javascript" src="js/nouislider.min.js"></script>
    <script type="text/javascript" src="js/wNumb.js"></script>
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script src="js/materialize.min.js"></script>
    <script>
      //var path = 'http://localhost/msfalcons/';    
        var count = 0;
      var path = 'http://sp-cfsics.metrostate.edu/~ics499fa160124/msfalcons/www/';
      d3.selectAll('input.side__word,input.puzzle__solution').property('value','');
      // This function is called when the plus sign next to a row is clicked. Adds a pair to the database.
      function post_row(row) {
        url = path+'api.php';
        data = {
          type: "pair",
          word_1: d3.select("#row-"+row+" .side--left .side__word").property('value'),
          word_2: d3.select("#row-"+row+" .side--right .side__word").property('value'),
          language: d3.select(".config__language").property("value")
        };    
        $.post(url,data)
          .done(function( data ) {
            Materialize.toast($.parseJSON(data).message, 4000);
          });
      }
      
      d3.select(".config__language")
        .on("change", function(data) {
          clear_row_left(null);
          clear_row_right(null);
          init_rows(d3.select(".solution").property("value"));
        });
        
      d3.select(".solution")
        .on("input", debounce( function(data) {
          clear_row_left(null);
          clear_row_right(null);
          init_rows(this.value);
        },1000));
        
      function load_left(row,val) {
        update_row_left(row,[],"");
        d3.select('#row-'+row+' .side--left .side__progress').classed("hide",false);
        let url = path+'api.php?type=pair&word='+encodeURI(val); 
        //populate clues
        if (typeof req[row*2] !== 'undefined') {
          req[row*2].abort();
        }
        console.log(count++);
        req[row*2] = d3.json(url, function(data) {
          if(data !== null) {
            update_row_left(row,data,data[0].value_name);
            d3.select('#row-'+row+' .pair_id').property("value",data[0].pair_id);
            d3.select('#row-'+row+' .pair_flip').property("value",data[0].flip);
          }
        });
      }
      
      function init_left(row) {
        d3.select("#row-"+row+" .side--right .side__word")
          .on("input", debounce( function() { 
            console.log(this.value);
            load_left(row,this.value);
            d3.select('#row-'+row+' .side--right .side__progress').classed("hide",true);
            if (typeof req[row*2-1] !== 'undefined') {
              req[row*2-1].abort();
            }
          },1000));
        d3.select("#row-"+row+" .side--left .side__word")
          .on("input", function() { 
            d3.select('#row-'+row+' .side--left .side__progress').classed("hide",true);
            if (typeof req[row*2] !== 'undefined') {
              req[row*2].abort();
            }
          });
      }
      

      
      d3.selectAll('input[type="file"]')
        .on("change", function() {
          let src = '';
          if( typeof $('#config__image_radio--upload ~ .input-field input').get(0).files[0] !== "undefined" ) {
            src = window.URL.createObjectURL($('#config__image_radio--upload ~ .input-field input').get(0).files[0]);
          }
          d3.select('.image').property('src',src);
        });
      
      d3.select('#config__image_radio--url ~ .input-field input')
        .on("input", debounce( function() {
          src = this.value;
          d3.select('.image').property('src',src);
        },1000));
        
      d3.selectAll('input[name="config__image"]')
          .on("change", function() {
          if(this.value != 0) {            
            let src = '';
            if(this.value == 1) {
              d3.select('#config__image_radio--upload ~ .input-field .btn')
                .attr('disabled', 'disabled')
                .attr('required', null);
              d3.select('#config__image_radio--url ~ .input-field input')
                .attr('disabled', null)
                .attr('required', 'required'); 
              src = d3.select('#config__image_radio--url ~ .input-field input').property("value");
            }
            if(this.value == 2) {
              d3.select('#config__image_radio--upload ~ .input-field .btn')
                .attr('disabled', null)
                .attr('required', 'required');
              d3.select('#config__image_radio--url ~ .input-field input')
                .attr('disabled', 'disabled')
                .attr('required', null);
              src = window.URL.createObjectURL($('#config__image_radio--upload ~ .input-field input').get(0).files[0]);
            }
            d3.select('.image').property('src',src);
            d3.select('.image__wrapper').classed('hide',false);
          } else {
            d3.select('#config__image_radio--upload ~ .input-field .btn')
              .attr('disabled', 'disabled')
              .attr('required', null);
            d3.select('#config__image_radio--url ~ .input-field input')
              .attr('disabled', 'disabled')
              .attr('required', null);
            d3.select('.display__image')
              .style("display","none");
            d3.select('.image__wrapper').classed('hide',true);
          }
          });
      
      function update_row_left(row,data,val) {
        clear_row_left(row);
        d3.select('#row-'+row+' .side--left .side__word').property('value',val).dispatch('input');
        var rowleft = d3.select('datalist#l'+row).selectAll('option').data(data);
        rowleft.exit().remove();
        rowleft.enter().append("option").text(function(d) { return d.value_name; });    
      }
      
      function update_row_right(row,data,val) {
        clear_row_left(row);
        clear_row_right(row);
        d3.select('#row-'+row+' .side--right .side__word').property('value',val).dispatch('input');
        var rowleft = d3.select('datalist#r'+row).selectAll('option').data(data);
        rowleft.exit().remove();
        rowleft.enter().append("option").text(function(d) { return d.word_name; });                
      }
      
      function clear_row_left(row) {
        if(row===null) d3.selectAll('.line .side--left .side__word').property("value","");
        d3.select('#row-'+row+'.line .side--left .side__word').property("value","").dispatch('input');
      }
      
      function clear_row_right(row) {        
        if(row===null) d3.selectAll('.line .side--right .side__word').property("value","");
        clear_row_left(row)
        d3.select('#row-'+row+'.line .side--right .side__word').property("value","").dispatch('input');
      }
      
      var words = {
        left: d3.selectAll('.line .side--left .side__word'),
        right: d3.selectAll('.line .side--right .side__word')
      }
      var req = [];
      
      function init_rows(word) {
        count = 0;
        var url = path+'api.php?word='+encodeURI(word)+'&type=split';         
        if (typeof req[0] !== 'undefined') req[0].abort();
        console.log(count++);
        req[0] = d3.json(url,function(data) {
          d3.selectAll(".pair_id").property('value','');          
          d3.selectAll(".pair_flip").property('value','');          
          d3.selectAll(".pair_column").property('value','');          
          d3.selectAll('.line').classed("hide",true);        
          data.forEach(function(data,i) {    
            d3.selectAll(".tooltipped").classed("hide",false);            
            let row = i+1;
            d3.select('#row-'+row).classed("hide",false);
            d3.select('#row-'+row+' .side--right .side__progress').classed("hide",false);
            let char = encodeURI(data);
            if(char === '') return;
            let pos = slider_column_preference.noUiSlider.get()-1;
            let min = slider_number_of_characters.noUiSlider.get()[0];
            let max = slider_number_of_characters.noUiSlider.get()[1];
            let lang = d3.select(".config__language").property("value");
            let url = path+'/api.php?type=word&char='+char+'&pos='+pos+'&lang='+lang+'&min='+min+'&max='+max; 
            if (typeof req[row*2-1] !== 'undefined') req[row*2-1].abort();
            console.log(count++);
            req[row*2-1] = d3.json(url,function(data) {
              if(data !== 'undefined') update_row_right(row,data,data[0].word_name);
              init_left(row);
              d3.select('#row-'+row+' .pair_column').property('value',pos);
              d3.select('#row-'+row+' .side--right .side__progress').classed("hide",true);
            });
          });
        });
      }
      
      function debounce(func, wait, immediate) {
        var timeout;
        return function() {
          var context = this, args = arguments;
          var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
          };
          var callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
          if (callNow) func.apply(context, args);
        };
      };   
      var slider_number_of_characters = document.getElementById('config__number_of_characters');
      var slider_column_preference = document.getElementById('config__column_preference');
      
      noUiSlider.create(slider_number_of_characters, {
        start: [3, 12],
        connect: true,
        margin: 1,
        step: 1,
        tooltips:true,
        format: wNumb({
          decimals: 0
        }),
        range: {
          'min': 1,
          'max': 20
        }
      });	

      noUiSlider.create(slider_column_preference, {
        start: 1,
        tooltips:true,
        step: 1,
        format: wNumb({
          decimals: 0
        }),
        range: {
          'min': 1,
          'max': 20
        }
      });
      
      slider_column_preference.noUiSlider.on('update', debounce(function() {
        clear_row_left(null);
        clear_row_right(null);
        init_rows(d3.select(".solution").property("value"));
      },1000));
      slider_number_of_characters.noUiSlider.on('update', debounce(function(values,handle) {
        clear_row_left(null);
        clear_row_right(null);
        init_rows(d3.select(".solution").property("value"));
        slider_column_preference.noUiSlider.updateOptions({
          range: {
            'min': 1,
            'max': parseInt(values[1])
          }
        });
      },1000));

      $( document ).ready(function() {
        $('.modal-trigger').leanModal();
        $('.collapsible').collapsible();
      });  
    </script>
	</body>
</html>