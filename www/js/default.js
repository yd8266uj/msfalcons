var dispatch = d3.dispatch("load","config__image_load","config__solution","config__language","config__image","config__toggle_column");
      
      var puzzle = {
        "solution":"",
        "language":"",
        "image":""
      };
      
      var pair = {
        "column":"",
        "clue":"",
        "synonym":""
      }
      
      var pairs = [];

    	dispatch.on("load.config", function(puzzle) {
        d3.select('#config__column_preference')
          .style('opacity', '.5')
          .attr('disabled', 'disabled');
        d3.select(".config__solution")
          .on("input", function() { dispatch.call("config__solution", this, this.value); });
        d3.select(".config__language")
          .on("change", function() { dispatch.call("config__language", this, this.value); });
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
        state.split("").forEach( function(c,i) { 
          console.log(c);
          var li = d3.select(".config__tabs .tabs")
            .append("li")
              .attr("class","tab");
          li.append("a")
            .attr("href","#tab-"+i)
            .text(c);
          var tab = d3.selectAll(".config__tabs")
            .append("div")
              .attr("id","tab-"+i)
              .attr("style","display: none;")
          tab.append("select")
            .attr("class","browser-default");
          tab.append("select")
            .attr("class","browser-default");
        });        
        
        $('.config__tabs .tabs').tabs();
        $('select').material_select();
      });      
      
      dispatch.on("config__language", function(state) {
        d3.select(".display__language")
          .text(state);
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
        dispatch.call("load", this, puzzle);
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