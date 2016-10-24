var dispatch = d3.dispatch(
  "load",
  "config__solution",
  "config__language",
  "config__image_load",
  "config__image",
  "config__clue",
  "config__synonym",
  "config__toggle_column");

      
var sample = {
"a": ["accurate","after","agent","alert","ago","aardvark"],
"b": ["bag","banker","behave","biodiversity","beyond"],
"c": [],
"d": [],
"e": [],
"f": [],
"g": [],
"h": [],
"i": [],
"j": [],
"k": [],
"l": [],
"m": [],
"n": [],
"o": [],
"p": [],
"q": [],
"r": ["rarely","radiation","recycle","release","rhyme"],
"s": ["scale","search","shadow","space","ship"],
"t": [],
"u": [],
"v": [],
"w": [],
"x": [],
"y": [],
"z": [],
};

function shuffle (array) {
  var i = 0
    , j = 0
    , temp = null

  for (i = array.length - 1; i > 0; i -= 1) {
    j = Math.floor(Math.random() * (i + 1))
    temp = array[i]
    array[i] = array[j]
    array[j] = temp
  }
}
    	dispatch.on("load", function(puzzle) {
        d3.select('#config__column_preference')
          .style('opacity', '.5')
          .attr('disabled', 'disabled');
        d3.select(".config__solution")
          .on("input", function() { dispatch.call("config__solution", this, this.value); });
        d3.select(".config__language")
          .on("change", function() { d3.select(".display__language").text(this.value); });
        d3.selectAll('.config__toggle_column input')
          .on("change", function() { dispatch.call("config__toggle_column", this, this.value); });
        d3.selectAll('input[name="config__image"]')
          .on("change", function() { dispatch.call("config__image", this, this.value); });
        d3.select('#config__image_radio--url ~ .input-field input')
          .on("change", function() { dispatch.call("config__image_load", this, this.value); });
        d3.select('#config__image_radio--upload ~ .input-field input')
          .on("change", function() { dispatch.call("config__image_load", this, window.URL.createObjectURL($('#config__image_radio--upload ~ .input-field input').get(0).files[0]));});
      });
      
      dispatch.on("config__solution", function() {
        var state = d3.select(".config__solution").property("value");
        d3.select(".display__solution")
          .text(state);
        d3.selectAll(".config__tabs .tabs .tab").remove();
        d3.selectAll(".config__tabs div").remove();
        var puzzle_lines = d3.select(".display__puzzle-lines");
        puzzle_lines.selectAll("li").remove();
        state.split("").forEach( function(c,i) {
          var puzzle_line = puzzle_lines.append("li")
            .attr("class","display__puzzle-line puzzle-line puzzle-line--tab-"+i);
          puzzle_line.append("div")
            .attr("class","puzzle-line__clue");
          puzzle_line.append("div")
            .attr("class","puzzle-line__synonym");
          
          var li = d3.select(".config__tabs .tabs")
            .append("li")
            .attr("class","tab");
          li.append("a")
            .attr("href","#tab-"+i)
            .text(c);
          var tab = d3.selectAll(".config__tabs")
            .append("div")
            .attr("id","tab-"+i)
            .attr("style","display: none;");          
          if(sample[c].length) {
          var select_1 = tab.append("select")
            .attr("class","browser-default")
            .on("change", function() { dispatch.call("config__synonym", this, this.value); });//
            shuffle(sample[c]);
            sample[c].forEach( function(a,i) {
              select_1.append("option") 
                .attr("value",a)
                .text(a);
            });   
            select_1.select("option")
              .attr("selected");
            dispatch.call("config__synonym", this, select_1.property("value"));
          } else {
            tab.append("p").text("no results");
          }
          
        });        
        
        $('.config__tabs .tabs').tabs();
        $('select').material_select();
      });      
      
      dispatch.on("config__synonym", function(state) {
        tab = d3.select(this.parentNode);
        tab.select("select:nth-of-type(2)").remove();
        tab.selectAll("p").remove();
        var asample = sample[state.charAt(1)];
        if(asample.length) {
            shuffle(asample);
            var select = tab.append("select")
              .attr("class","browser-default")
              .on("change", function() { 
                d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__clue")
                  .text(select.property("value"));
                d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__synonym")
                  .text(tab.select("select").property("value"));
              });
            asample.forEach( function(a,i) {
              select.append("option") 
                .attr("value",a)
                .text(a);
            });                         
          } else {
            tab.append("p")
              .text("no solution");
          }  
        
      });
      
      
      dispatch.on("config__toggle_column", function(state) {
        e = d3.select('#config__column_preference');
        if ( this.checked ) {
          e.attr('disabled', null)
            .style('opacity', '1');
        } else {
          e.attr('disabled', 'disabled')
            .style('opacity', '.5');
        }
      });
      dispatch.on("config__image_load", function(state) {
        d3.select('.display__image img')
          .remove();
        d3.select('.display__image') 
          .append("img")
          .attr("src",state);
      });
      
      dispatch.on("config__image", function(state) {    
        d3.select('.display__image img')
          .remove()      
        switch (state) {
          case '0':
            d3.select('#config__image_radio--upload ~ .input-field .btn')
              .attr('disabled', 'disabled')
              .attr('required', null);
            d3.select('#config__image_radio--url ~ .input-field input')
              .attr('disabled', 'disabled')
              .attr('required', null);
            break;
          case '1':
            d3.select('#config__image_radio--upload ~ .input-field .btn')
              .attr('disabled', 'disabled')
              .attr('required', null);
            d3.select('#config__image_radio--url ~ .input-field input')
              .attr('disabled', null)
              .attr('required', 'required');
            dispatch.call("config__image_load", this, d3.select('#config__image_radio--url ~ .input-field input').property("value"));
            break;
          case '2':
            d3.select('#config__image_radio--upload ~ .input-field .btn')
              .attr('disabled', null)
              .attr('required', 'required');
            d3.select('#config__image_radio--url ~ .input-field input')
              .attr('disabled', 'disabled')
              .attr('required', null);
            dispatch.call("config__image_load", this, window.URL.createObjectURL($('#config__image_radio--upload ~ .input-field input').get(0).files[0]));
            break;
        }
      });
      
			$( document ).ready(function() {
				$('.modal-trigger').leanModal();
				$('.collapsible').collapsible();
        dispatch.call("load", this, this);
			});

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
        start: 5,
        tooltips:true,
        step: 1,
        format: wNumb({
          decimals: 0
        }),
        range: {
          'min': 3,
          'max': 12
        }
      });
    
      slider_number_of_characters.noUiSlider.on('update', function(values,handle) {
        slider_column_preference.noUiSlider.updateOptions({
          range: {
            'min': parseInt(values[0]),
            'max': parseInt(values[1])
          }
        });
        dispatch.call("config__solution", this, this.value);
      });