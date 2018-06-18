<?php
include "BD.php";
session_start();
$bd = new BD();

$sqlQuery = "SELECT * FROM t_user WHERE useName = '{$_POST['inputPseudo']}'";

$user = $bd->executeQueryReturn($sqlQuery);
if($user !== array())
{
  if(password_verify($_POST['inputPassword'],$user[0][2]))
  {
    $_SESSION['pseudo'] = $_POST['inputPseudo'];

    if(isset($_POST['remember']))
    {
      $_SESSION['remember'] = true;
    }
    header("Location: ../?page=temp");
  }else{
    header("Location: ../?error=password");
  }
}else{
  header("Location: ../?error=user");
}
