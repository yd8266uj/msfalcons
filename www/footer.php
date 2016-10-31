<footer></footer>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="js/nouislider.min.js"></script>
    <script type="text/javascript" src="js/http.js"></script>
    <script type="text/javascript" src="js/wNumb.js"></script>
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script src="js/materialize.min.js"></script>
		<script src="js/http.js"></script>
		<script src="js/default.js"></script>
    <script>
      var callback = {
        success: function(data) {
          console.log(1, 'success', JSON.parse(data));
        },
        error: function(data) {
          console.log(2, 'error', JSON.parse(data));
        }
      };

      var params = {
        type: 'word',
        character: 'a',
        position: '0'
      };
      var url = 'http://localhost/msfalcons/api.php?format=html&type='+params.type+'&char='+params.character+'&pos='+params.position;
      console.log(url);
      /*
      var params = {
        type: 'pair',
        id: '7'
      };
      var url = 'http://localhost/msfalcons/api.php?type='+params.type+'&id='+params.id+'&format='+params.format;
      */
      $http(url)
        .get()
        .then(callback.success)
        .catch(callback.error);
    </script>
	</body>
</html>