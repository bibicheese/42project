<?php
session_start();
require "php/db.php";

$fake_login = false;
$fake_passwd = false;

if (isset($_GET['token']))
{
  $token = $_GET['token'];
  make_query("UPDATE users SET active=1 WHERE `token` = '$token'");
}

if (isset($_POST['submit']) && $_POST['submit'] == "se connecter")
{
  $login = $_POST['account'];
  $passwd = $_POST['passwd'];
  $ret = make_query("SELECT * FROM users WHERE `login` = '$login'");
  $ret = $ret->fetch(PDO::FETCH_ASSOC);
  if (!$ret)
    $fake_login = true;
  if ($ret["password"] != $passwd)
    $fake_passwd = true;
  else {
    $_SESSION['login'] = $_POST['account'];
    header("location: php/connected.php");
  }
}

?>

<html>
<head>

<title>Photogru</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/signin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body>

<div id="all">
  <div class="login_form">
    <div class="content">
    <div class="header" id="header">
      <div class="title">S'identifier
        <div id="close" class="close">x</div>
      </div>
    </div>
    <form method="post">
    <div class="form">
      <div class="fill">
        <?php
            if ($fake_login)
              echo "<div class=\"error_log\" id=\"error_log\">Le nom de compte est incorrect</div>";
            if ($fake_passwd && !$fake_login)
              echo "<div class=\"error_log\" id=\"error_log\">Le mot de passe est incorrect</div>";

            if ($fake_login || $fake_passwd) {
              echo "<script>
                document.getElementById('all').style.display = 'block';
                document.getElementById('error_log').style.display = 'block';
                </script>";
            }
           ?>
        <div class="each">
          <label for="account" class="text">Nom de compte</label><br>
          <input type="text" class="champ" placeholder="Nom de compte" name="account" value="<?php if (isset($_POST['account'])) echo $_POST['account']?>" required>
        </div>
        <div class="each">
          <label for="passwd" class="text">Mot de passe</label><br>
          <input type="password" class="champ" placeholder="Mot de passe" name="passwd" required>
        </div>
          <div class="terminate">
            <input class="button" type="submit" name="submit" value="se connecter" required>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
</div>

<div class="topnav" id="myTopnav">
  <a href="index.php"><img src="ressources/photo.gru.png" class="img"></a>
  <a href="#" class="fa fa-camera-retro"></a>
  <a href="#" class="fa fa-image"></a>
  <a href="php/signup.php" class="burger">S'inscrire</a>
  <a class="burger" id="login">S'identifier</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>



<script src="js/login.js"></script>
<script src="js/header.js"></script>
</body>
</html>
