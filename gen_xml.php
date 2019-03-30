<?php

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node


header("Content-type: text/xml");

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$host="127.0.0.1";
$username="Projet";
$password="password";
$db_name="Projet";
	
$conn= new mysqli($host,$username,$password,$db_name);
if($conn -> connect_errno)
{
	printf("Erreur mysql: %s\n", $conn->connect_error);
	exit();
}

// Select all the rows in the markers table

$query = "SELECT * FROM Station";
$result = $conn->query($query);
if(!$result) die($conn->error);

// Iterate through the rows, adding XML nodes for each

while ($row = mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("nom_station",$row['nom_station']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}

echo $dom->saveXML();

?>
