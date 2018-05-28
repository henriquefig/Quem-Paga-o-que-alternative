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
    <div align="center"><br><h3 align="center"><b>Para consultar as listas clique nos numeros</b></h3><br>
<?
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "root";
  $dbname = "QPO";

  $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));
  $query="SELECT Saldo,Nome,Fechada FROM Listas WHERE Nro_User=".$_SESSION['user_id'].";";
  $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
  $i=1;
  while($row = mysqli_fetch_array($qry_result))
  {
    $maior=0;
    $menor=0;
    if($i==1)
    {
      $array .="<table width=\"75%\">\n<form action=\"./MinhaLista.php\" method=\"post\">\n<tr>\n<td>Numero</td>\n<td>Nome</td>\n<td>O meu saldo</td>\n<td>Saldo mais Elevado</td>\n<td>Saldo mais Baixo</td></tr>";
    }
    if($row['Fechada'] == 0)
    {
      $query="SELECT * FROM Listas WHERE Nro_list=".$i.";";
      $qry_result2 = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
      while($row2 = mysqli_fetch_array($qry_result2))
      {
        if($row2['Saldo']>$maior)
        {
          $maior=$row2['Saldo']/100;
        }
        if($row2['Saldo']<$menor)
        {
          $menor=$row2['Saldo']/100;
        }
      }
      $self=($row['Saldo']/100);
      $array .="<tr>\n<td><input type=submit name=Ver value=".$i.">\n</td>\n<td>".$row['Nome']."</td>\n<td>";
      if($self<0)
      {
        $array.="<font color=#ff800>".$self." &#8364;</font></td>\n<td>";
      }
      else
      {
        $array.=$self." &#8364;</td>\n<td>";
      }
        $array.=$maior." &#8364;</td>\n<td>";
      if($menor<0)
      {
        $array.="<font color=#ff800>".$menor." &#8364;</font></td>\n</tr>";
      }
      else
      {
        $array.=$menor." &#8364;</td>\n</tr>";
      }
    }
    $i++;
  }
  if($i==1)
  {
    $array.="<b>Nenhuma lista criada/aderida</b>";
  }
  else
  {
    $array.="\n</form>\n</table>";
  }
  echo $array ."</div>";
?>
    <div id="footer">&copy; Henrique Figueiredo&nbsp;&nbsp;&nbsp;&nbsp;<img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div>
    </div>
  </body>
</html>