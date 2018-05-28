<?
function insersaolist($nro,$cadapaga,$value)
{
	$div=0;
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "QPO";
    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
	foreach($cadapaga as $val) 
	{
		$mult=split('x',$val);
		$div=$div+$mult[0];
	}
	foreach($cadapaga as $val) 
	{
		$mult=split('x',$val);
		$saldo;
		$query="SELECT * FROM Listas WHERE Nro_list=".$nro." AND Nro_User=".$mult[1].";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$row = mysqli_fetch_array($qry_result);
		if($_SESSION['user_id'] != $mult[1])
	  	{
	  		$saldo=$row['Saldo']-($value*100*$mult[0])/$div;

		  	$query="SELECT * FROM Users WHERE Nro_User=".$mult[1].";";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$row2 = mysqli_fetch_array($qry_result);
			if($row2['Alert'] == 1)
			{
				if($saldo < 0)
				{
					$ssa=($saldo/100);
					$message="Olá ".$row2['F_name']." ".$row2['L_name']."!\nFoi submetido uma nova compra na lista ".$row['Nome']." que deixou o teu saldo negativo.\nSaldo: " .$ssa."€ .\n Podera ver as mudanças aqui:\nhttp://henrique.local/QPO/MinhasListas.php";
					$subject="QPO Alerta: Saldo negativo";
					$headers = "From: QPO@efigapp.com" . "\r\n";
					mail($row2['Email'],$subject,$message,$headers);
				}
			}
	  	}
	  	else
	  	{
	  		$saldo=$row['Saldo']+($value*100-($value*100*$mult[0])/$div);
	  	}
	  	$query="UPDATE Listas SET Saldo=".$saldo." WHERE Nro_list=".$nro." AND Nro_User=".$mult[1].";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
  	}
}
include('session_timeout.php');
session_start();
session_expired();
date_default_timezone_set("GMT");
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
    $nro=mysqli_escape_string($mydb,$_POST['sub']);
	if(isset($_POST['op']))
	{
		$data=mysqli_escape_string($mydb,$_POST['data']);
		$valor=mysqli_escape_string($mydb,$_POST['amount']);
		$des=mysqli_escape_string($mydb,$_POST['desc']);
		$nrouser=mysqli_escape_string($mydb,$_POST['nro']);
		$pagantes;
		$count=0;
		for($i=1;$i<=$nrouser;$i++)
		{
			$paga=mysqli_escape_string($mydb,$_POST['mult'.$i]);
			$query="SELECT * FROM Users WHERE Email=\"".mysqli_escape_string($mydb,$_POST['email'.$i])."\";";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$row = mysqli_fetch_array($qry_result);
			$pagantes[$count]=$paga."x".$row['Nro_User'];
			if($row['Updates'] == 1)
			{
				$message="Foi submetido uma nova compra na sua lista de valor " .$valor."€ consequentemente o seu saldo foi alterado.\n Podera ver as mudanças aqui:\nhttp://henrique.local/QPO/MinhasListas.php";
				$subject="Update do seu saldo QPO";
				$headers = "From: QPO@efigapp.com" . "\r\n";
				mail($row['Email'],$subject,$message,$headers);
			}
			if($i<$nrouser)
			{
				$count++;
			}
		}
		$query="INSERT INTO Submissao(Nro_User,Nro_list,Data,Descricao,Pagantes,Valor) VALUES(".$_SESSION['user_id'].",".$nro.",\"".$data."\",\"".$des."\",\"";
		for($i=0;$i<=$count;$i++)
			$query.=$pagantes[$i].",";
		$query.="\",".($valor*100).");";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		insersaolist($nro,$pagantes,$valor);
		$array .= "<embed src=\"s.wav\" autostart=false loop=\"infinite\" hidden=true><h2>Submissao feita com sucesso! Poder&aacute; alter aos detalhes da mesma no menu das suas lista</h2><br>";
	}
	else
	{
		$array .="<form align=center onSubmit=\"return ValidateValor();\" method=\"post\">\nDescri&ccedil;&atilde;o:<br><textarea name=\"desc\" cols=60 value=\"\"></textarea>\n<br>";
		$query="SELECT * FROM Listas WHERE Nro_list=".$nro.";";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$i=1;
		$now = new DateTime();
		$datestring = strftime("%F", $now->getTimestamp());
		$array.="Data:<input type=date name=data value=".$datestring.">      Valor:<input type=text id=valor placeholder=\"0.00\" name=amount><br>Quem participou?<br><br>";
		while ($row = mysqli_fetch_array($qry_result))
		{
			$query="SELECT * FROM Users WHERE Nro_User=".$row['Nro_User'].";";
			$qry_result2 = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$row2 = mysqli_fetch_array($qry_result2);
			$array .="<input type=hidden name=email".$i." value=".$row2['Email']."><div id=data".$i.">".$row2['F_name']." ".$row2['L_name']." x <script>data(2,".$i.");</script></div>";
			$i++;
		}
		$array .= "<input type=hidden name=sub value=".$nro."><input type=hidden name=nro value=".($i-1)."><input type=\"submit\" name=\"op\" value=\"Inserir\">";
	}
	echo $array;
?>
<div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>
