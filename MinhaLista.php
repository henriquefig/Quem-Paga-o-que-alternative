<?php
function stringarPagantes($values)
{
  $res;
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "root";
  $dbname = "QPO";
  $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
  foreach($values as $val)
  {
    $array=split('x',$val);
    $query="SELECT F_name FROM Users WHERE Nro_User=".$array[1].";";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $row = mysqli_fetch_array($qry_result);
    if($array[0]!=0)
    {
      $res.=$row['F_name']." x";
      if($val!=$values[count($values)-1])
        $res.=$array[0].", ";
      else
        $res.=$array[0];
    }
  }
  return $res;
}
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
    <div align="center"><br>Para consultar as listas clique nos numeros<br>
<?php
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "root";
  $dbname = "QPO";
  $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
  $ver=mysqli_escape_string($mydb,$_POST['Ver']);
  $array.="<div align=center><br><form action='./criarsubmissao.php' method='post'><button type=submit height=\"60\" width=\"60\" name=Ver value=".$ver."><span class=\"glyphicon glyphicon-plus-sign\"></span></button> Nova Submiss&atilde;o</form><br>";
  $query="SELECT * FROM Submissao WHERE Nro_list=".$ver." ORDER BY Data DESC;";
  $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
  $i=1;
  while($row = mysqli_fetch_array($qry_result))
  {
    $maior=0;
    $menor=0;
    $count=0;
    if($i==1)
    {
      $array.="<table><tr>";
      $query="SELECT * FROM Listas WHERE Nro_list=".$ver.";";
      $qry_result2 = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
      while($row2 = mysqli_fetch_array($qry_result2))
      {
        $query="SELECT * FROM Users WHERE Nro_User=".$row2['Nro_User'].";";
        $qry_result3 = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
        if($row3 = mysqli_fetch_array($qry_result3))
        {
          $array .="<th>".$row3['F_name']." ".$row3['L_name']."</th>\n";
          $novo[$count]=$row2['Saldo']/100;
          $count++;
        }
      }
        $array.="</tr>\n<tr>\n";
      for($j=0;$j<$count;$j++)
      {
        if($novo[$j]<0)
        {
          $array .="\n<td><font color=#ff8000>".$novo[$j]." &#8364;</font></td>\n";
        }
        else
        {
          $array .="\n<td>".$novo[$j]." &#8364;</td>\n";
        }
      }
      $array.="</tr></table><br>";
        $array .="<table width=\"75%\">\n<form action=\"./eliminar_sub.php\" method=\"post\">\n<tr>\n<td>Quem Pagou:</td>\n<td>Data</td>\n<td>Valor</td>\n<td>Descri&ccedil;&atilde;o</td>\n<td>Pagantes</td>\n<td>Eliminada</td></tr>";
    }
    $valor=($row['Valor'])/100;
    $persons=split(',',$row['Pagantes']);
    array_pop($persons);
    $query="SELECT * FROM Users WHERE Nro_User=".$row['Nro_User'].";";
    $qry_result2 = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $row2 = mysqli_fetch_array($qry_result2);
    if($row['Eliminada'] == 1)
    {
      $array.="<tr class=del>\n<td>".$row2['F_name']." ".$row2['L_name']."</td>\n<td>".$row['Data']."</td>\n<td>".$valor." &#8364;</td>\n<td>".$row['Descricao']."</td>\n<td>";
      $array.=stringarPagantes($persons);
      $array.="</td>\n<td><input type=image src=./public/images/delete.png onclick=\"return false;\" alt=\"novo\" padding=\"none\" height=\"20\" name=eliminar value=x></td>\n</tr>";
    }
    else
    {
      $array.="<tr>\n<td>".$row2['F_name']." ".$row2['L_name']."</td>\n<td>".$row['Data']."</td>\n<td>".$valor." &#8364;</td>\n<td>".$row['Descricao']."</td>\n<td>";
      $array.=stringarPagantes($persons);
      $array.="</td>\n<td><input type=image src=./public/images/delete.png  alt=\"novo\" padding=\"none\" height=\"20\" name=eliminar value=".$row['Sub_id']."></td>\n</tr>";      
    } 
    $i++;
  }
  if($i==1)
  {
    $array.="<b>Nenhuma submiss&atilde;o criada nesta lista</b><br>";
  }
  else
  {
    $array.="\n<input type=hidden name=Ver value=".$ver."></form>\n</table>";
  }
  $array .= "<br><form action='./adduser.php' method='post'><button type=submit height=\"60\" width=\"60\" name=sub value=".$ver."><span class=\"glyphicon glyphicon-plus-sign\"></span></button>  Adicionar novo utilizador a lista<input type=hidden name=lista value=".$ver."></form><br><br>";
  if($i!=1)
  {
    $array .="<form action='./acerto.php' method='post'><input type=hidden name=lista value=".$ver."><input type=submit onclick='return conf();' name=\"del\" value=\"Acertar Contas da Lista\"></form>";
  }
  echo $array."</div>";
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>