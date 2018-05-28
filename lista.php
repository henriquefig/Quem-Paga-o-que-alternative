<?
	include('session_timeout.php');
  session_start();
  session_expired();
	if($_SESSION['SU']!=1)
	{
		header("Location: ./MinhasListas.php");
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
        <li class="songbut"><div type="button" onclick="toogleplay();" class="glyphicon glyphicon-play" > </div></li>
        <li class="songbut"><div type="button" onclick="fowardsong();" class="glyphicon glyphicon-step-forward"> </div></li>
        <li class="last"><a align="right" href="./logout.php"><img src="./public/images/logout.png" height="30px" width="30px"/></a></li>
        <li class="last"><a href="./altperfil.php"><img src="./public/images/edit.png" style="margin-right:10px" width="30px" height="30px"></a></li>
        <li class="name">Bem-vindo <? echo $_SESSION['F_name']." ".$_SESSION['L_name']; ?></a></li>
        </ul>
    </div>
    <br><h2 align="center">Utilizadores</h2><table>
<?
	if($_SESSION['SU'] == 1)
	{
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "root";
		$dbname = "QPO";
	    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
	    $op=mysqli_escape_string($mydb,$_POST['Del']);
		if(isset($_POST['Del']))
		{
			$query="SELECT * FROM Users WHERE Verificado=0";
			$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			$i=1;
			while($row = mysqli_fetch_array($qry_result))
			{
				$query="DELETE FROM Autenticacao WHERE Nro_User=".$row['Nro_User'].";";
				$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
				$query="DELETE FROM Users WHERE Nro_User=".$row['Nro_User'].";";
				$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
			}
			$array .="<h3 align=center><b>Utilizadores n&atilde;o validados eliminados com sucesso!</b></h3>";
		}
		$query="SELECT * FROM Users;";
		$qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
		$array .="<tr><td>N&uacute;mero</td>\n<td>Primeiro Nome</td>\n<td>SobreNome</td>\n<td>Email</td><td>Data de nascimento</td>\n<td>Sexo</td>\n<td>Cidade</td>\n<td>SU</td>\n<td>Updates</td>\n<td>Alertas</td>\n<td>Verificado</td>\n<td>Existente</td>\n</tr>\n";
		while ($row = mysqli_fetch_array($qry_result))
		{
			$array .="<tr><td><input type=\"submit\" nome='nro' value=".$row['Nro_User']."></td>\n<td>".$row['F_name']."</td>\n<td>".$row['L_name']."</td>\n<td>".$row['Email']."</td>\n<td>".$row['Bday']."</td>\n<td>";
			if($row['Sex'] == 1)
			{
				$array.="F";
			}
			else
			{
				$array.="M";
			}
			$array.="</td>\n<td>".$row['City'];
			for($i=7;$i<=11;$i++)
			{
				if($row[$i] == 0)
				{
					$array.="</td>\n<td>N&atilde;o";
				}
				else
				{
					$array.="</td>\n<td>Sim";
				}
			}
			$array .= "</td>\n</tr>\n";
		}
		$array .= "</table><br><br><form align=center><input type=submit name=Del value=\"Eliminar n&atilde;o validados\">\n</form>";
		echo $array;
	}
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>