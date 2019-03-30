
<?php
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
?>
