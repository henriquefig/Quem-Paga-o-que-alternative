<?php
  include('session_timeout.php');
  session_start();
  session_expired();
  if(!isset($_SESSION['user_id']))
  {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "QPO";

    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));

    $password=mysqli_escape_string($mydb,$_POST['password']);
    $email=mysqli_escape_string($mydb,$_POST['email']);
    $query="SELECT Nro_User,SU,F_name,L_name,Email FROM Users WHERE Email=\"".$email."\" && Verificado=1 && Existente=1;";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $row=mysqli_fetch_array($qry_result);
    $user_id=$row[0];
    if($user_id=="")
      header("Location: ./index.php?error=1");
    $su=$row[1];
    $query="SELECT Password FROM Autenticacao Where Nro_User=".$user_id." && Password=\"".$password."\";";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    if($qry_result->{'num_rows'}!=0)
    {
      $_SESSION['user_id']=$user_id;
      $_SESSION['SU']=$su;
      $_SESSION['F_name']=$row[2];
      $_SESSION['L_name']=$row[3];
      $_SESSION['Email']=$row[4];
    }
    else
    {
      header("Location: ./index.php?error=1");
    }
      
  }
?>
<html lang="pt">
<head>
<meta charset="UTF-8">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
<script src="./public/javascripts/util.js"></script>
<link rel="shortcut icon" href="./public/images/favicon.ico"><title>QPO?</title><link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
  <div id="header">
    <h1 align="center">Quem paga o qu&ecirc;?!</h1></div>
    <script type="text/javascript"  src="./public/javascripts/dinamicdrop.js"></script>
    <script type="text/javascript"  src="./public/javascripts/valida.js"></script>
    <div id="navi">
      <ul>
        <li><a href="./MinhasListas.php">Minhas Listas</a></li>
        <li><a href="./criarlista.php">Criar Lista</a></li>
        <?php if($_SESSION['SU']==1) echo "<li><a href=\"./lista.php\">Listar Users</a></li>"; ?>
        <li><a href="./contactos.html">Contactos</a></li>
        <li class="songbut"><div type="button" onclick="backsong();" class="glyphicon glyphicon glyphicon-step-backward"></div></li>
        <li class="songbut"><div type="button" onclick="toogleplay();" class="glyphicon glyphicon-play" ></div></li>
        <li class="songbut"><div type="button" onclick="fowardsong();" class="glyphicon glyphicon-step-forward"></div></li>
        <li class="last"><a align="right" href="./logout.php"><img src="./public/images/logout.png" height="30px" width="30px"/></a></li>
        <li class="last"><a href="./altperfil.php"><img src="./public/images/edit.png" style="margin-right:10px" width="30px" height="30px"></a></li>
        <li class="name">Bem-vindo <?php echo $_SESSION['F_name']." ".$_SESSION['L_name']; ?></a></li>
        </ul>
    </div>
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
      <img src="./public//images/henrique.jpg" width="130px" height="180px"/><br>
      <h4>Henrique Figueiredo</h4><br>
      e-mail: <a href="mailto:1120401@isep.ipp.pt" target="_top">1120401@isep.ipp.pt</a><br>
      Tel.: <a href="tel:+351938746977">938 746 977</a><br>
      <a href="https://www.facebook.com/henrique.figueiredo.125" target="_blank">Facebook</a> | 
      <a href="https://github.com/henriquefig" target="_blank">GitHub</a>
    </div>
    <div>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>