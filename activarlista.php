<?php
	include('session_timeout.php');
  session_start();
  session_expired();
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
    <br><div align="center">
<?php

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "QPO";
    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
    $nome=mysqli_escape_string($mydb,$_GET['nome']);
	$array;
	if(isset($_SESSION['user_id']))
	{
    	$email=mysqli_escape_string($mydb,$_GET['email']);
		if($_SESSION['Email'] == $email)
		{

			
			$query="SELECT * FROM Listas WHERE Nome=\"".$nome."\" AND Fechada=0;";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$row = mysqli_fetch_array($qry_result);
			$query="INSERT INTO Listas(Nro_list,Nro_User,Saldo,Nome) VALUES(".$row['Nro_list'].",".$_SESSION['user_id'].",0,\"".$nome."\");";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));

			$array .= "<h2>Lista subscrita com sucesso! Poder&aacute; aceder aos detalhes da mesma no menu das suas listas</h2><br>";

		}
		else
		{
			$array .= "<h2 align=center>Sess&atilde;o n&atilde;o corresponde ao email de confirmaç&atilde;o por favor faça <a align=center href=./logout.php>Logout</a> e tente novamente.</h2>\n";
		}
	}
	else
	{
		$array .= "<h2 align=center>Por favor faça login para confirmar a subscriç&atilde;o na lista!</h2>\n<br>\n<form align=center action=\"./main.php\" method=\"post\">\n<table align=center>\n<tr>\n<td>Email:</td>\n<td>\n<input type=\"text\" name=\"email\" size=\"40\" value=\"\"></td>\n</tr>\n";
		$array .= "<tr>\n<td>Password:</td>\n<td><input type=\"password\" name=\"password\" size=\"32\" value=\"\">\n</td>\n</tr>\n</table>\n";
		$array .= "<input type=hidden name=nome value=".$nome.">\n";
		$array .= "<input type=\"submit\" name=\"op\" value=\"Login\">";
	}
	echo $array."</div>";
?>

<div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>
