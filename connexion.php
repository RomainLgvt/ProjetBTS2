<html>
<?php
		require_once('./header1.php');
		require_once('./login.php');
		
?>

<?php
session_start();
if(isset($_POST['login']) && isset($_POST['pw']))
{
	$login=$_POST['login'];
	$password=$_POST['pw'];
	$query = "SELECT identifiant, password FROM User WHERE identifiant='".$login."' AND password='".$password."'";
	$result = $conn->query($query);
	if(!$result) die($conn->error);
	if(mysqli_num_rows($result)==0)
	{
	echo "Mot de passe incorrect, Réessayer";
	}	
	else
	{
	$_SESSION['login']=$login;
	$_SESSION['pw']=$password;
	header('Location: index.php');	
	}
}
?>
<link href='./css/signin.css' rel='stylesheet'>
<body>

<main role="main" class="container">
     <form class="form-signin" action="connexion.php" method="post">
        <h2 align="center">Connexion</h2>
        <label for="login" class="sr-only">Login</label>
        <input name="login" id="inputLogin" class="form-control" placeholder="Login" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="pw" id="inputPassword" class="form-control" placeholder="Password" required="" type="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit">VALIDER</button>
     </form>
</main>

</body>
</html>
