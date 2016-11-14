var dispatch = d3.dispatch(
  "load",
  "config__solution",
  "config__language",
  "config__image_load",
  "config__image",
  "config__clue",
  "config__synonym",
  "config__toggle_column");

      

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
          .on("input", debounce( function() { dispatch.call("config__solution", this, this.value) },1000 ));
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
        puzzle_lines.selectAll("li.puzzle-line").remove();
        var url = 'http://localhost/msfalcons/api.php?word='+encodeURI(state)+'&type=split';         
        console.log(url);
        d3.select(".config__tabs .tabs").text('loading');
        d3.json(url,function(data) {
          console.log(data);          
          data.forEach( function(c,i) {
          
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
            
            var puzzle_line = puzzle_lines.append("li")
              .attr("class","display__puzzle-line row puzzle-line puzzle-line--tab-"+i);
            puzzle_line.append("div")
              .attr("class","puzzle-line__clue col s12 m6");
            puzzle_line.append("div")
              .attr("class","puzzle-line__synonym col s12 m6");
            var url = 'http://localhost/msfalcons/api.php?format=html&type=word&char='+encodeURI(c)+'&pos='+(slider_column_preference.noUiSlider.get()-1)+'&lang='+d3.select(".config__language").property("value"); 
            console.log(url);
            
            d3.html(url,function(data) { 
              d3.select(".config__tabs .tabs").text('');            
              d3.select(data);              
              tab.node().appendChild(data);  
              var select = d3.select("#tab-"+i+" select:nth-of-type(1)").on("change", function() {
                var url = 'http://localhost/msfalcons/api.php?format=html&type=pair&id='+this.value;
                d3.html(url,function(data) {
                  d3.select("#tab-"+i+" select:nth-of-type(2)").remove();
                  d3.select(data);              
                  tab.node().appendChild(data);  
                  var select = d3.select("#tab-"+i+" select:nth-of-type(2)").on("change", function() {                    
                    d3.selectAll(".tooltipped").classed("hide",false);
                    d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__clue")
                      .style("opacity","0")
                      .text(d3.select("select option[value='"+d3.select(this).property("value")+"']").text())
                      .transition()
                      .style("opacity","1");
                      console.log();
                    d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__synonym")
                      .style("opacity","0")
                      .text(tab.select("select option[value='"+tab.select("select").property("value")+"']").text())
                      .transition()
                      .style("opacity","1");
                  })
                  select.dispatch("change");
                });
              })
              select.dispatch("change");
            });
          });        
        });
        $('.config__tabs .tabs').tabs();
        $('select').material_select();
        d3.selectAll('.display__puzzle-lines li')          
          .style("opacity","0");
        Materialize.showStaggeredList('.display__puzzle-lines');
      });      
      
      dispatch.on("config__synonym", function(state) {
        
        tab = d3.select(this.parentNode);
        tab.select("select:nth-of-type(2)").remove();

          var select = tab.append("select")
            .attr("class","browser-default")
            .on("change", function() { 
              d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__clue")
                .style("opacity","0")
                .text(select.property("value"))
                .transition()
                .style("opacity","1");
              d3.select(".puzzle-line--"+tab.attr("id")+" .puzzle-line__synonym")
                .style("opacity","0")
                .text(tab.select("select").property("value"))
                .transition()
                .style("opacity","1");
            });
            select.append("option")
              .attr("disabled","disabled")
              .text("select word");
          asample.forEach( function(a,i) {
            select.append("option") 
              .attr("value",a)
              .text(a);
          });
       
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
          .attr("class","responsive-img center valign")
          .attr("src",state);   
        d3.selectAll('.display__puzzle-lines li')          
          .style("opacity","0");
        Materialize.showStaggeredList('.display__puzzle-lines')
                d3.select('.display__image')
              .style("display","block");
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
            d3.select('.display__image')
              .style("display","none");
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
        Materialize.fadeInImage('.display__image img');
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
      
      slider_column_preference.noUiSlider.on('update', debounce(function() {dispatch.call("config__solution", this, this.value);},1000))
      slider_number_of_characters.noUiSlider.on('update', function(values,handle) {
        slider_column_preference.noUiSlider.updateOptions({
          range: {
            'min': 1,
            'max': parseInt(values[1])
          }
        });
      });
      
   
      
