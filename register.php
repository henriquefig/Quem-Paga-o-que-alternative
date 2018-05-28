<html>
<head><title>QPO?</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./public/css/style.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
  <script src="./public/javascripts/util.js"></script>
  <script type="text/javascript"  src="./public/javascripts/dinamicdrop.js"></script>
  <script type="text/javascript"  src="./public/javascripts/valida.js"></script>
</head>
<body onload="data(1,0);">
 <div id="header"><img align=right src="./public/images/qpo.png"  width="70" height="70"/> <h1 align="center"> Quem paga o quê?! </h1> 
</div><br><br>
<div style="height:570px;">
<h1 align="center">Registo:</h1><br> 
<form align="center" method="post" onSubmit="return ValidateEmail();" action="./save_new.php">
  <h4>Primeiro nome: <input type="text" name="fname" placeholder="Primeiro Nome">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Sobrenome: <input type="text" name="lname" placeholder="Sobrenome"><br><br>
  Sexo:&nbsp;&nbsp;<input type="checkbox" name="sex" value="M"checked>&nbsp;&nbsp;M&nbsp;&nbsp;
  <input type="checkbox" name="sex" value="F">&nbsp;&nbsp;F<br><br>
  <div id="data">
  	Data de nascimento:
  </div><br><br>
  Cidade: <input type="text" name="city" placeholder="Cidade"><br><br>
  E-mail: <input type="text" name="email" id="mail" size="30" placeholder="Email"><br><br>
  Password: <input type="password" name="password" id="password" placeholder="Password"><br><br>
  Confirmar Password: <input type="password" id="password2" placeholder="Password"><br><br>
  
  <input type="checkbox" name="updados" value="update">&nbsp;&nbsp;Sim pretendo receber updates quando o meu saldo for alterado.<br>

  <input type="checkbox" name="alert" value="alert">&nbsp;&nbsp;Sim pretendo receber alertas quando o meu saldo for inferior a 0.<br><br>
  <input type="submit" value="Registar" name="op"><br></h4>
<br><br>
Já está registado?<br> Faca login <a 
href="./index.php">já!</a>
</form>
</div>
<div id="footer">  &copy Henrique Figueiredo - <a href="./contactos.html">Contactos</a>&nbsp;&nbsp;
  <img align="center" src="./public/images/qpo.png"  width="30" height="30"/>&nbsp;&nbsp;-&nbsp;&nbsp;<div style="display:inline" id="weather"></div></div>

 </div>
</body>
</html>
