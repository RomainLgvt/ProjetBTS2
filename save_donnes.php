<html>
<head>
	<title>Projet BTS2</title>
</head>
<body>
<?php
	require_once('./login.php');
?>
<?php 
$id_station= $_GET['id_station'];
$vitesse= $_GET['vitesse'];
$temperature= $_GET['temperature'];
$profondeur= $_GET['profondeur'];
$query="INSERT INTO Mesures (id_station,vitesse,temperature,profondeur) VALUES ('$id_station','$vitesse','$temperature','$profondeur')";
$result = $conn->query($query);
if(!$result) die($conn->error);
else
{
echo"Données transmises";
}
?>
</body>
</html>
