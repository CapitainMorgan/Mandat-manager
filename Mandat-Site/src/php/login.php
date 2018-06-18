<?php
/**
 * connection avec les classes
 */
spl_autoload_register(function($class) {
    include 'classes/' . $class . '.php';
});
session_start();
if(isset($_SESSION['remember']))
{
  header("Location: ?page=temp");
}
?>

<style>
body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}
</style>


<section>
  <form class="form-signin" method="post" action="classes/Login.php">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputPseudo" class="sr-only">Pseudo</label>
    <input name="inputPseudo" id="inputPseudo" class="form-control" placeholder="Pseudo" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
      <label>
        <input name="remember"type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
</section>
