<?php
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
<?php
	$dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "QPO";

    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
	if(isset($_POST['op']))
	{
		$op=mysqli_escape_string($mydb,$_POST['op']);
		$pname=mysqli_escape_string($mydb,$_POST['pname']);
		$lname=mysqli_escape_string($mydb,$_POST['lname']);
		$date=mysqli_escape_string($mydb,$_POST['date']);
		$city=mysqli_escape_string($mydb,$_POST['city']);
		$up=mysqli_escape_string($mydb,$_POST['updados']);
		$alt=mysqli_escape_string($mydb,$_POST['alert']);
		$query="UPDATE Users SET F_name='".$pname."', L_name='".$lname."', Bday='".$date."', City='".$city;
		if($up == "update")
		{
			$query.="', Updates=1";
		}
		else
		{
			$query.="', Updates=0";
		}
		if($alt == "alert")
		{
			$query.=", Alert=1";
		}
		else
		{
			$query.=", Alert=0";
		}
		$query.=" WHERE Nro_User=".$_SESSION['user_id'].";";
   		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
   		$_SESSION['F_name']=$pname;
		$_SESSION['L_name']=$lname;
   		$array.="<h3 align=center><b>Perfil actualizado com sucesso!</b></h3>";

	}
	$query2="SELECT * FROM Users WHERE Nro_User=".$_SESSION['user_id'].";";
	$qry_result = mysqli_query($mydb,$query2) or die(mysqli_error($mydb));
	$row = mysqli_fetch_array($qry_result);
	$array .="<table align=center class=\"except\"><form method=POST><tr><td>\nPrimeiro Nome:</td><td><input type=text name=\"pname\" value=\"".$row['F_name']."\"></td>\n<tr><td>Ultimo Nome:</td><td><input type=text name=\"lname\" value=\"".$row['L_name']."\"></td></tr>\n<tr><td>Data de nascimento:</td><td><input type=date name=\"date\" value=\"".$row['Bday']."\"></td></tr>\n<tr><td>Cidade:</td><td><input type=text name=\"city\" value=\"".$row['City']."\"></td></tr>";
	$array .="<tr><td colspan=\"2\"><input type=\"checkbox\" name=\"updados\" value=\"update\"";
	if($row['Updates'] == 1)
	{
		$array.=" checked";
	}
	$array .="> Sim pretendo receber updates quando o meu saldo for alterado.</td></tr><tr><td colspan=\"2\"><input type=\"checkbox\" name=\"alert\" value=\"alert\"";
	if($row['Alert'] == 1)
	{
		$array.=" checked";
	}
	$array .="> Sim pretendo receber alertas quando o meu saldo for inferior a 0.</td></tr><br><tr><td colspan=\"2\"><input type=\"submit\" value=\"Alterar dados pessoais\" name=\"op\"></td></tr>\n</form></table>";
	echo $array;
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>