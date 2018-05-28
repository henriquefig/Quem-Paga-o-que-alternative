function ValidateEmail()   
{  
	var email=document.getElementById('mail').value
  var p1=document.getElementById('password').value
  var p2=document.getElementById('password2').value
	var reg=/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i ;
 if(reg.test(email) && p1==p2)  
  {  
    return (true)  
  }  
  if(!reg.test(email))  
  {  
    alert("You have entered an invalid email address!")  

    return (false)  
  }
  if(p1!=p2)  
  {  
    alert("Your passwords don't match!!!")  

    return (false)  
  }
}
function ValidateValor()
{
	var valor=document.getElementById('valor').value
	var reg=/^\d+(?:\.\d{1,2})?$/;
	if(reg.test(valor))  
 	{  
		return (true)  
	}
	alert("Insere um numero como valor!!")

    return (false)
}
function conf()
{
  return confirm('Tem a certeza que deseja acertar as contas?\n Isto fará com que todos os saldos fiquem a 0 e a lista fechada.');
}