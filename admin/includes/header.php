<?
session_start();

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['username'];

function dumpVar($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EarthChem Vocabulary Admin Interface</title>

	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	
	<link rel="stylesheet" href="resources/style.css">

	<link rel="stylesheet" href="resources/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" href="resources/jquery-ui/jquery-ui.theme.css">
	
	<!--
	<link rel="stylesheet" type="text/css" href="resources/fancybox/src/css/core.css">
	-->
	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="resources/jquery-ui/jquery-ui.js"></script>
	
	<!--
	<script src="resources/fancybox/src/js/core.js"></script>
	-->
	<!--
	<script src="resources/easyautocomplete/jquery.easy-autocomplete.js"></script> 
	<link rel="stylesheet" href="resources/easyautocomplete/easy-autocomplete.min.css"> 
	<link rel="stylesheet" href="resources/easyautocomplete/easy-autocomplete.themes.min.css"> 
	-->

</head>
<body>


	<div id="wrapper">
		<div class="clearfloat" id="header">
		EarthChem Vocabulary Admin
		</div>
		
		<!--
		<div class="loginbar">
			Logged in as <?=$firstname?> <?=$lastname?> - <?=$email?> <a href="/logout">(Logout)</a>
		</div>
		-->
	
		<div style="clear:both;"></div>

		<div style="padding-bottom:300px">