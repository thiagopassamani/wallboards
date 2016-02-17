//
// Utilitario Data/Hora
// Desenvolvido por: Elsaby Antunes email: elsabyantunes@gmail.com
// Script que mostra Data e Hora do Computador Local no seu Web Site.
//
// Salve o arquivo "clock.js" 
// Instale o codigo abaixo no local da pag. web que queira mostrar DATA e HORA.:: Dentro da secao "<BODY> </BODY>"
//
// <script language='javascript' src='clock.js'></script>
//
//	  <span id='clock_tm' >Hora Atual!</span><br> <span id='clock_dt' >Data atual!</span>
//				
// <script language='javascript'>
// StartClock('d,m,Y','H:i:s');
// 
// 
// Mantenha os creditos ou envie email avisando que este relogio foi útil em seu site.
// Obrigado
// -->

// StartCode \\
var dt = new Array();
var clockID = 0;

var cl_tf = '0';
var cl_df = '0';

function UpdateClock()
{
	if(clockID)
  	clearTimeout(clockID);

	var tDate = new Date();
	dt[0] = tDate.getFullYear();
	dt[1] = pad(tDate.getMonth()+1);
	dt[2] = pad(tDate.getDate());
	dt[3] = pad(tDate.getHours());
	dt[4] = pad(tDate.getMinutes());
	dt[5] = pad(tDate.getSeconds());

	dt_obj = document.getElementById('clock_dt');  // Este é o identificador da chamada "DATA"
	tm_obj = document.getElementById('clock_tm');  // Este é o identificador da chamada "HORA"
	
	dt_obj.innerHTML = formatDate();
	tm_obj.innerHTML = formatTime();

	clockID = setTimeout("UpdateClock()", 1000);
}

function pad(val)
{
	if(val <= 9)
	{
		val.toString();
		val = "0" + val;
	}

	return val;
}

function formatDate()
{
  var d;

	d = cl_df.replace(/Y/,dt[0]);
  d = d.replace(/m/,dt[1]);
  d = d.replace(/d/,dt[2]);

	return d;
}

function formatTime()
{
  var t;

	t = cl_tf.replace(/H/,dt[3]);
  t = t.replace(/i/,dt[4]);
  t = t.replace(/s/,dt[5]);

	return t;
}


function StartClock(df,tf)
{
	cl_df = df;
	cl_tf = tf;

	clockID = setTimeout("UpdateClock()", 500);
}

function KillClock()
{
	if(clockID)
	{
		clearTimeout(clockID);
		clockID  = 0;
	}
}

function setCookie(name,val,first)
{
	if(first)
		document.cookie = name + "=" + val;
	else
	  document.cookie += name + "=" + val;
}


// EndCode \\