<?php
$servername = "localhost";
$username = "root";
$password = "98c0d45de2fcb9210ee6a20531777a897e627787c5947356";
$dbname = "cscw";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nome FROM Eventos";
$result = $conn->query($sql);
$ret = array('data'=>array());
$i = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ret['data'][$i] = array('id'=> $row["id"], 'nome'=> $row["nome"]);
$i++;
    }
} else {
    echo "0 results";
}
//var_dump($ret);
$conn->close();

header('Content-type: application/json; charset=utf-8');
echo json_encode($ret);
?> 
