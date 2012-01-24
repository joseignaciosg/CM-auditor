$(document).ready(function() {

	//executes auditory
	$("#exeauditory").click(function(){
		$("#content h2").html("Ejecutando Auditor&iacute;a");
//		$("#contentmain").load("php/exeauditory.php");
		$("#contentmain").load("auditory.html");
	});
	
	//shows turbo smtp data of current delivery
	$("#turbosmtp").click(function(){
		$("#contentmain").load("php/showturbosmtp.php");
		$("#content h2").html("Turbo Smtp - &uacute;ltimo env&iacute;o");
	});
	
	//show hard bounces of current delivery
	$("#hardlast").click(function(){
		$("#contentmain").load("php/showhardlast.php");
		$("#content h2").html("Rebotes Hard del &uacute;ltimo env&iacute;o");
	});
	
	//show soft bounces of current delivery
	$("#softlast").click(function(){
		$("#contentmain").load("php/showsoftlast.php");
		$("#content h2").html("Rebotes Soft del &uacute;ltimo env&iacute;o");
	}); 
	
	//show active delivery list
	$("#sendlist").click(function(){
		$("#contentmain").load("php/showactivelist.php");
		$("#content h2").html("Lista activa de env&iacute;o");
	}); 
	
	//show hard and soft graph
	$("#hardsoftgraph").click(function(){
		$("#contentmain").load("php/hardsoftgraph.php");
		$("#content h2").html("Hard and Soft");
	});
	
	//show bad imported into send blaster
	$("#badimported").click(function(){
		$("#contentmain").load("php/showsendblasterbadimported.php");
		$("#content h2").html("Cargados mal en sistema de env&iacute;o");
	});
	
});