<html>
<head>
	<title>Projet BTS2</title>
</head>
<body>
<?php
	require_once('./login.php');
?>

<?php 
$nom_station= $_GET['nom_station'];
$address= $_GET['address'];
$lat= $_GET['lat'];
$lng= $_GET['lng'];
$type= $_GET['type'];
$query="INSERT INTO Station (nom_station,address,lat,lng,type) VALUES ('$nom_station','$address','$lat','$lng','$type')";
$result = $conn->query($query);
if(!$result) die($conn->error);
else
{
echo"Données transmises";
}
?>
</body>
</html>
