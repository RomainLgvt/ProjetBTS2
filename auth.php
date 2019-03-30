<?php


session_start();
if(!isset($_SESSION['login']) && !isset($_SESSION['pw']))
{
//echo "session not open";
header('Location: connexion.php');
}

?>
