  	var numbsong=0;
  	var myaudio = new Audio(numbsong+'.mp3');
  	var playing=false;
  	function dropnum(ini,nro,nome,id) {
	  	var i=0;
	  	var day=document.createElement('select');
	  	day.name=nome;
	  	console.log(id);
	  	id.appendChild(day);
	  	for(i=ini-1;i<=nro;i++)
	  	{
	  		var option=document.createElement('option');
	  		 day.appendChild(option);              
	  		if(i==ini-1)
	  		{			
	  			if(nome.includes("mult"))
	  				var textnodeb = document.createTextNode("-");
  				else
	  				var textnodeb = document.createTextNode(nome);
				option.appendChild(textnodeb);
	  			option.selected="selected";
	  		}
	  		else
	  		{
	  			var textnode = document.createTextNode(Math.abs(i));         // Create a text node
				option.appendChild(textnode);    
	  		}
	  		option.value=Math.abs(i);

		}
	}
	function data(valor,i)
	{

		if(valor==1)
		{
	  		var id=document.getElementById('data');
			dropnum(1,31,"day",id);
			dropnum(1,12,"month",id);
			dropnum(-2005,-1900,"year",id);
		}
		else
		{
	  		var id=document.getElementById('data'+i);
			dropnum(1,16,"mult"+i,id);
		}
	}
	function toogleplay()
	{
		if(playing==false)
		{
	  		myaudio.play();
			playing=true;
			myaudio.addEventListener('ended',changesong());
		}
		else
		{
			playing=false;
			myaudio.pause();
		}

	}
	function fowardsong()
	{
		if(!myaudio.paused)
		{
	  		myaudio.pause();
		}

  		numbsong++;
  		myaudio=new Audio(numbsong+'.mp3');
		myaudio.play();
		myaudio.addEventListener('ended',changesong());
	}
	function backsong()
	{
		if(numbsong>0)
		{
			if(!myaudio.paused)
			{
		  		myaudio.pause();
			}

	  		numbsong--;
	  		myaudio=new Audio(numbsong+'.mp3');
			myaudio.play();
			myaudio.addEventListener('ended',changesong());

		}
	}
	function changesong()
	{
		if(!myaudio.paused)
		{
	  		myaudio.stop();
		}
  		numbsong++;
  		myaudio=new Audio(numbsong+'.mp3');
		 $body.css('display', 'block');
		myaudio.play();
		myaudio.addEventListener('ended',changesong());
	}