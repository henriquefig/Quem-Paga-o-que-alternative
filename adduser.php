<?
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
    <br><div align="center">
<?
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "QPO";
    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
    $op=mysqli_escape_string($mydb,$_POST['op']);
	if(isset($_POST['op']))
	{
		$email=mysqli_escape_string($mydb,$_POST['email']);
		$query="SELECT * FROM Listas WHERE Nro_list=".mysqli_escape_string($mydb,$_POST['lista']).";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$row = mysqli_fetch_array($qry_result);
		$message="Foi registado na lista \"".$row['Nome']."\" por ".$_SESSION['F_name']." ".$_SESSION['L_name'].", para confirmar clique neste link:\nhttp://henrique.local/QPO/activarlista.php?email=".$email."&nome=";
		$n = count($row['Nome']);
		if($n>1)
		{
			foreach($row['Nome'] as $val) 
			{
				if($n--)
				{
					$message.=$val."%20";
				}
				else
				{
					$message.=$val."\n";
				}
			}

		}
		else
			$message.=$row['Nome']."\n";
		$message.="\n\nSe não pretender participar nesta lista por favor ignore este e-mail.";
		if(isset($_POST['desc']))
		{
			$message.="\nA mensagem de ".$_SESSION['F_name']." ".$_SESSION['L_name']." foi:\n\"".$_POST['desc']."\"";
		}
		$subject="Convite para Lista QPO!";
		$headers = "From: QPO@efigapp.com" . "\r\n";
		mail($email,$subject,$message,$headers);
		echo $array.="Utilizador convidado para a lista com sucesso.</div>";
	}
	else
	{
		$array = "Convida um amigo para participar na tua lista<br><br><form action='./adduser.php' method='post'>Email:<input type=email name=email><br><br>Adiciona uma mensagem:<br><textarea cols=80 rows=4 name=\"desc\" value=\"\" placeholder='(opcional)'></textarea>";
		echo $array .= "<input type=hidden name=lista value=".mysqli_escape_string($mydb,$_POST['lista'])."><br><input type=\"submit\" name=\"op\" value=\"Convidar\"></form></div>";
	}
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>