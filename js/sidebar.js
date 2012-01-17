$(document).ready(function() {

	//executes auditory
	$("#exeauditory").click(function(){
		$("#content h2").html("Ejecutando Auditor&iacute;a");
		$("#contentmain").load("php/exeauditory.php");
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
	
});