<?php
	include('session_timeout.php');
  	session_start();
  	session_expired();
	if(!isset($_SESSION['user_id']) || !isset($_POST['del']))
	{
		header("Location: ./index.php");
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
        <li class="songbut"><button type="button" onclick="backsong();"><--</button></li>
        <li class="songbut"><button type=button onclick="toogleplay();" >|></button></li>
        <li class="songbut"><button type="button" onclick="fowardsong();">--></button></li>
        <li class="last"><a align="right" href="./logout.php"><img src="./public/images/logout.png" height="30px" width="30px"/></a></li>
        <li class="last"><a href="./altperfil.php"><img src="./public/images/edit.png" style="margin-right:10px" width="30px" height="30px"></a></li>
        <li class="name">Bem-vindo <?php echo $_SESSION['F_name']." ".$_SESSION['L_name']; ?></a></li>
        </ul>
    </div>
 <?	
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "QPO";
    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
    $op=mysqli_escape_string($mydb,$_POST['del']);
    $list=mysqli_escape_string($mydb,$_POST['lista']);
	$query="UPDATE Listas SET Saldo=0, Fechada=1 WHERE Nro_list=".$list.";";
	$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));

	$query="UPDATE Submissao SET Eliminada=1 WHERE Nro_list=".$list.";";
	$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
	
	$query="SELECT * FROM Listas WHERE Nro_list=".$list.";";
	$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
	while($row = mysqli_fetch_array($qry_result))
	{
		$query="SELECT * FROM Users WHERE Nro_User=".$row['Nro_User'].";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$row2 = mysqli_fetch_array($qry_result);
		//$message="Foram acertadas as contas na sua lista - \"".$row['Nome']."\" por " .$_SESSION['F_name']." ".$_SESSION['L_name'].". Consequentemente todos os saldos foram repostos a 0 &#8364;.\n Podera ver as mudanças aqui:\nhttp://localhost:5000/MinhasListas";
		//$subject="Acerto de contas QPO";
		//emails($row['Email'],$message,$subject);

	}
	$array .= "Acerto efectuado com sucesso um e-mail foi enviado a todos os Utilizadores desta lista\n<br>";
	echo $array;
?>
<div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>