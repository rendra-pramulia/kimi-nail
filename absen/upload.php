<script src="js/jquery-latest.js"></script>
<script>
 $(document).ready(function() {
 	 $("#responsecontainer").load("sended.php");
   var refreshId = setInterval(function() {
      $("#responsecontainer").load('sended.php?randval='+ Math.random());
   }, 5000);
   $.ajaxSetup({ cache: false });
});
</script>
<b>
<div id="responsecontainer"></div>
</b>