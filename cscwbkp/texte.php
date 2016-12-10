<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
<button type="button" onclick="loadDoc()">Change Content</button>
	<script>
		function loadDoc() {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		     console.log(this.response.data);
		    }
		  };
		  xhttp.open("GET", "http://takahanga.me/evento2.php", true);
		  xhttp.send();
		} 
	</script>
</body>
</html>
