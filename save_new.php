<?
  session_start();
  if(!isset($_SESSION['user_id'])) 
  {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "QPO";

    $mydb=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die(mysqli_error($mydb));

    $fname=mysqli_escape_string($mydb,$_POST['fname']);
    $lname=mysqli_escape_string($mydb,$_POST['lname']);
    $cidade=mysqli_escape_string($mydb,$_POST['city']);
    $sex=mysqli_escape_string($mydb,$_POST['sex']);
    $password=mysqli_escape_string($mydb,$_POST['password']);
    $email=mysqli_escape_string($mydb,$_POST['email']);
    $day=mysqli_escape_string($mydb,$_POST['day']);
    $month=mysqli_escape_string($mydb,$_POST['month']);
    $year=mysqli_escape_string($mydb,$_POST['year']);
    $update=mysqli_escape_string($mydb,$_POST['updados']);
    $alert=mysqli_escape_string($mydb,$_POST['alert']);
    $query="INSERT INTO Users(F_name,L_name,Email,Bday,Sex,City,Updates,Alert) VALUES(\"".$fname."\",\"".$lname."\",\"".$email."\",\"".$year."-".$month."-".$day."\",";
    if($sex == "M")
    {
      $query .= "0,\"";
    }
    else
    {
      $query.="1,\'";
    }
    $query.=$cidade."\",";
    if($update == "update")
    {
      $query.="1,";
    }
    else
    {
      $query.="0,";
    }
    if($alert == "alert")
    {
      $query.="1";
    }
    else
    {
      $query.="0";
    }
    $query.=");";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $query="INSERT INTO Autenticacao(Password) VALUES(\"".$password."\");";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $query="SELECT Nro_User FROM Users WHERE F_name=\"".$fname."\" && Email=\"".$email."\";";
    $qry_result = mysqli_query($mydb,$query) or die(mysqli_error($mydb));
    $row = mysqli_fetch_array($qry_result);
    $_SESSION['user_id']=$row['Nro_User'];
    $_SESSION['F_name']=$fname;
    $_SESSION['L_name']=$lname;
    $message="O teu registo na platforma QPO está a um passo de estar completa, por favor clique aqui para activar a sua conta:\nhttp://henrique.local/QPO/activate.php?email=".$email."\nObrigado pelo seu registo!\n\nSe não se registou neste website, por favor ignore este e-mail.";
    $subject="Registo QPO!";
    $headers = "From: QPO@efigapp.com" . "\r\n";
    mail($email,$subject,$message,$headers);
  }
    header("Location: ./index.php");
?>