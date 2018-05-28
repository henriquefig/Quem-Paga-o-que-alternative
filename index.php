<?
  include('session_timeout.php');
  session_start();
  session_expired();
  if(isset($_SESSION['user_id'])) 
    header("Location: main.php");
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>QPO?</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./public/css/style.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
  <script src="./public/javascripts/util.js"></script>
  <script type="text/javascript"  src="./public/javascripts/dinamicdrop.js"></script>
  <script type="text/javascript"  src="./public/javascripts/valida.js"></script>
</head>
<body>
<div id="header">
 <h1 align="center"> Quem paga o quê?! </h1>
</div><br>
<div id="maintext" align="center">
      <h2 align="center">Breve resumo do trabalho:</h3><br> 
      Este trabalho foi 
      desenvolvido no ambito da 
      cadeira Modulação de Sistemas Industriais, tem como objectivo a criação de uma Aplicação Web.<br>
      Foi projectada a criação de uma aplicação de gestão de recursos económicos de pessoas com despesas partilhadas.<br>
      Este sistema implica o registo e <i>login</i> e implica ainda o uso de um e-mail válido. Se tiverem questões relativas à aplicação por favor consultem o relatório referente ao mesmo!<br>
      Espero que se divirtam! :D<br><br>
    </div>
<div align="center">
<h1>Login</h1>
<form method="post" action="./main.php">
  <?  if(isset($_GET['error']))
        echo "<h2 align=center color=#ff800>Erro credenciais inv&aacute;lidas!!!</h2>"; ?>
  Email: <input type="text" name="email" placeholder="Email"><br>
  Password: <input type="password" name="password" placeholder="Password"><br>
  <input type="submit" value="Login" onclick="ValidateEmail()" name="op">
  <audio id="audio" src="./public/t.mp3" ></audio>
</form>
Não tem credenciais?<br> Registe-se <a 
href="./register.php">já!</a>
</div>
<div id="footer">  &copy Henrique Figueiredo - <a href="./contactos.html">Contactos</a>&nbsp;&nbsp;
 <img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div></div>
</body>
</html>