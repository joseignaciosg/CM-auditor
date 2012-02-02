$(document).ready(function() {

	//executes auditory
	$("#exeauditory").click(function(){
		$("#download_button").html('');
		$("#content h2").html("Ejecutando Auditor&iacute;a");
//		$("#contentmain").load("php/exeauditory.php");
		$("#contentmain").load("auditory.html");
	});
	
	//shows turbo smtp data of current delivery
	$("#turbosmtp").click(function(){
		$("#download_button").html('<a href="php/downloadsmtplist.php"><button>Descargar Lista</button></a>');
		$("#contentmain").load("php/showturbosmtp.php");
		$("#content h2").html("Smtp - &uacute;ltimo env&iacute;o");
	});
	
	//show hard bounces of current delivery
	$("#hardlast").click(function(){
		$("#download_button").html('<a href="php/downloadhardlist.php"><button>Descargar Lista</button></a>');
		$("#contentmain").load("php/showhardlast.php");
		$("#content h2").html("Rebotes Hard del &uacute;ltimo env&iacute;o");
	});
	
	//show soft bounces of current delivery
	$("#softlast").click(function(){
		$("#download_button").html('<a href="php/downloadsoftlist.php"><button>Descargar Lista</button></a>');
		$("#contentmain").load("php/showsoftlast.php");
		$("#content h2").html("Rebotes Soft del &uacute;ltimo env&iacute;o");
	}); 
	
	//show active delivery list
	$("#sendlist").click(function(){
		$("#download_button").html('<a href="php/downloadactivelist.php"><button>Descargar Lista</button></a>');
		$("#contentmain").load("php/showactivelist.php");
		$("#content h2").html("Lista activa de env&iacute;o");
	}); 
	
	//show hard and soft graph
	$("#hardsoftgraph").click(function(){
		$("#download_button").html('');
		$("#contentmain").load("php/hardsoftgraph.php");
		$("#content h2").html("Hard and Soft");
	});
	
	//show bad imported into send blaster
	$("#badimported").click(function(){
		$("#download_button").html('');
		$("#contentmain").load("php/showsendblasterbadimported.php");
		$("#content h2").html("Cargados mal en sistema de env&iacute;o");
	});
	
});