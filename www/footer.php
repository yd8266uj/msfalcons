<footer></footer>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="js/nouislider.min.js"></script>
    <script type="text/javascript" src="js/http.js"></script>
    <script type="text/javascript" src="js/wNumb.js"></script>
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script src="js/materialize.min.js"></script>
    <script>
      var path = 'http://localhost/msfalcons/';
      //var path = 'http://sp-cfsics.metrostate.edu/~ics499fa160124/msfalcons/www/';
      
      function post_row(row) {
        url = path+'api.php';
        data = {
          type: "pair",
          word_1: d3.select("#row-"+row+" input[name='word_1']").property('value'),
          word_2: d3.select("#row-"+row+" input[name='word_2']").property('value'),
          language: d3.select(".config__language").property("value")
        };    
        $.post(url,data)
        .done(function( data ) {
          console.log($.parseJSON(data).message);
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
          init_rows(this.value);
        },300));
      
      function init_left(row) {
        d3.select("#row-"+row+" .side--right .side__word")
        .on("input", debounce( function (data) {
          update_row_left(row,[]);
          d3.select('#row-'+row+' .side--left .side__progress').classed("hide",false);
          let url = path+'api.php?type=pair&word='+encodeURI(this.value); 
          console.log(url);
          d3.json(url, function(data) {
            update_row_left(row,data);
              d3.select('#row-'+row+' .side--left .side__progress').classed("hide",true);
          });
        },300));
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
        },300));
        
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
      
      function update_row_left(row,data) {
        clear_row_left(row);
        d3.select('#row-'+row+' .side--left .side__word').property('placeholder',data.length+' matches found');
        var rowleft = d3.select('datalist#l'+row).selectAll('option').data(data);
        rowleft.exit().remove();
        rowleft.enter().append("option").text(function(d) { return d.value_name; });    
      }
      
      function update_row_right(row,data) {
        d3.select('#row-'+row+' .side--right .side__word').property('placeholder',data.length+' matches found');
        var rowleft = d3.select('datalist#r'+row).selectAll('option').data(data);
        rowleft.exit().remove();
        rowleft.enter().append("option").text(function(d) { return d.word_name; });    
      }
      
      function clear_row_left(row) {
        if(row===null) d3.selectAll('.line .side--left .side__word').property("value","");
        d3.select('#row-'+row+'.line .side--left .side__word').property("value","");
      }
      
      function clear_row_right(row) {
        
        if(row===null) d3.selectAll('.line .side--right .side__word').property("value","");
        clear_row_left(row)
        d3.select('#row-'+row+'.line .side--right .side__word').property("value","");
      }
      
      function init_rows(word) {
        var url = path+'api.php?word='+encodeURI(word)+'&type=split';         
        console.log(url);
        d3.json(url,function(data) {
          d3.selectAll('.line').classed("hide",true);        
          data.forEach(function(data,i) {    
            d3.selectAll(".tooltipped").classed("hide",false);          
            let row = i+1;
            d3.select('#row-'+row).classed("hide",false);
            update_row_right(row,[]);
            update_row_left(row,[]);
            d3.select('#row-'+row+' .side--right .side__progress').classed("hide",false);
            let char = encodeURI(data);
            let pos = slider_column_preference.noUiSlider.get()-1;
            let min = slider_number_of_characters.noUiSlider.get()[0];
            let max = slider_number_of_characters.noUiSlider.get()[1];
            let lang = d3.select(".config__language").property("value");
            let url = path+'/api.php?type=word&char='+char+'&pos='+pos+'&lang='+lang+'&min='+min+'&max='+max; 
            console.log(url);
            d3.json(url,function(data) {
              console.log(data);
              update_row_right(row,data);
              init_left(row);
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
          'min': 3,
          'max': 12
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
          'max': 12
        }
      });
      
      slider_column_preference.noUiSlider.on('update',function() {
        clear_row_left(null);
        clear_row_right(null);
        init_rows(d3.select(".solution").property("value"));
      });
      slider_number_of_characters.noUiSlider.on('update', function(values,handle) {
        clear_row_left(null);
        clear_row_right(null);
        init_rows(d3.select(".solution").property("value"));
        slider_column_preference.noUiSlider.updateOptions({
          range: {
            'min': 1,
            'max': parseInt(values[1])
          }
        });
      });

      $( document ).ready(function() {
        $('.modal-trigger').leanModal();
        $('.collapsible').collapsible();
      });  
    </script>
	</body>
</html>