<?
  include('session_timeout.php');
  session_start();
  session_expired();
  if(!isset($_SESSION['user_id']))
  {
  	header("Location: index.php");
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
        <? if($_SESSION['SU']==1) echo "<li><a href=\"./lista.php\">Listar Users</a></li>"; ?>
        <li><a href="./contactos.html">Contactos</a></li>
        <li class="songbut"><div type="button" onclick="backsong();" class="glyphicon glyphicon glyphicon-step-backward"></div></li>
        <li class="songbut"><div type="button" onclick="toogleplay();" class="glyphicon glyphicon-play" ></div></li>
        <li class="songbut"><div type="button" onclick="fowardsong();" class="glyphicon glyphicon-step-forward"></div></li>
        <li class="last"><a align="right" href="./logout.php"><img src="./public/images/logout.png" height="30px" width="30px"/></a></li>
        <li class="last"><a href="./altperfil.php"><img src="./public/images/edit.png" style="margin-right:10px" width="30px" height="30px"></a></li>
        <li class="name">Bem-vindo <? echo $_SESSION['F_name']." ".$_SESSION['L_name']; ?></a></li>
        </ul>
    </div>
    <div align="center"><br>
<?
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "root";
  $dbname = "QPO";
  if(isset($_POST['op']))
  {
    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
    $nome=mysqli_escape_string($mydb,$_POST['nome']);
    $op=mysqli_escape_string($mydb,$_POST['op']);
    $query="SELECT MAX(Nro_list) FROM Listas;";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $row = mysqli_fetch_array($qry_result);
    if(($row[0]) == "")
    {
      $nro=1;
    }
    else
    {
      $nro=$row[0]+1;
    }
    $query="INSERT INTO Listas(Nro_list,Nro_User,Nome,Saldo) VALUES(".$nro.",".$_SESSION['user_id'].",\"".$nome."\",0);";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $array .= "<h2 align=center><b>Lista criada com sucesso!</b></h2><br>";
    $message="Foi registado na lista \"".$nome."\" com sucesso, para adicionar pessoas à sua lista clique neste link:\nhttp://henrique.local/QPO/adduser.php";
    $headers = "From: QPO@efigapp.com" . "\r\n";
    mail($_SESSION['email'],$subject,$message,$headers);
  }
  else
  {
    $array.="<form method=POST>Nome da Lista:<input type=\"text\" name=\"nome\"><br><br><br><input type=\"submit\" name=\"op\" value=Criar></form>";
  }
  echo $array ."</div>";
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>