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
	if(isset($_POST['eliminar']))
	{
   		$ver=mysqli_escape_string($mydb,$_POST['Ver']);
   	 	$eliminar=mysqli_escape_string($mydb,$_POST['eliminar']);
		$array="<b>Submiss&atilde;o eliminada com sucesso!</b><br><input type=image src=\"/images/mais.jpeg\"  alt=\"novo\" padding=\"none\" height=\"20\" name=sub value=".$ver.">Nova Submiss&atilde;o<br><br><br>";
		$query="SELECT * FROM Submissao where Sub_id=".$eliminar.";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$row = mysqli_fetch_array($qry_result);
		$mult=split(',',$row['Pagantes']);
		$div=0;
		foreach($mult as $val) 
		{
			$multi=split('x',$val);
			$div=$div+$multi[0];
		}
		foreach($mult as $val)
		{
			$multi=split('x',$val);
			$novosaldo=($multi[0]*$row['Valor'])/$div;
			$query="SELECT * FROM Listas Where Nro_list=".$row['Nro_list']." AND Nro_User=".$multi[1].";";
			$qry_result2= mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$row2 = mysqli_fetch_array($qry_result2);
			$valor;
			if($row['Nro_User']==$multi[1])
			{
				$valor=$row2['Saldo']-($row['Valor']-$novosaldo);
			}
			else
			{
				$valor=($rrow2['Saldo']+$novosaldo);
			}
			$query="UPDATE Listas SET Saldo=".$valor." Where Nro_list=".$row['Nro_list']." AND Nro_User=".$multi[1].";";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$query="UPDATE Submissao SET Eliminada=1 Where Sub_id=".$eliminar.";";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		}
		echo $array;
	}
?>
<div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>