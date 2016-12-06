<?php 
$json = file_get_contents('file.json');
//$json = utf8_encode($json); 
$aux = json_decode($json, false, 512, JSON_UNESCAPED_UNICODE);
echo json_encode($aux, JSON_UNESCAPED_UNICODE);

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
</body>
</html>


