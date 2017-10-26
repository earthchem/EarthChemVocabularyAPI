<?php

/*
******************************************************************
Vocab REST API
Author: Jason Ash (jasonash@ku.edu)
Description: This codebase allows end-users to communicate with
			 the Vocabulary System.
******************************************************************
*/

//Initialize Databases
include "../includes/db.php";

//Load Base Controller
include "./controllers/RESTController.php";

//Load Additional Controllers
foreach (glob("./controllers/*.php") as $filename){
    include_once $filename;
}

include "./library/Request.php";
include "./views/ApiView.php";
include "./views/JsonView.php";
include "./views/HtmlView.php";

$request = new Request();

//log raw input for debug
if(file_exists("tlog.txt")){
	$rawinput = file_get_contents("php://input");
	file_put_contents ("log.txt", "\n\n************************************************************************************************************************\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "REQUEST: ".ucfirst($request->url_elements[1])."\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "REQUEST_URI: ".$_SERVER["REQUEST_URI"]."\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "Raw Input:\n".$rawinput, FILE_APPEND);
}




// route the request to the right place
$controller_name = ucfirst($request->url_elements[1]) . 'Controller';

$showcontroller = $request->url_elements[1];
if($showcontroller==""){$showcontroller="null";}

if (class_exists($controller_name)) {
    $controller = new $controller_name();
    $controller->setDB($db);
    $controller->setUri($baseuri);
    $action_name = strtolower($request->verb) . 'Action';
    $result = $controller->$action_name($request);
}else{
	
	if($showcontroller=="null"){//top-level
	
		//show list of vocabularies
		$result[0]['uri']="http://vocab.earthchemportal.org/vocabulary/grainType";
		$result[0]['prefLabel']['en']="Grain Type";
		$result[0]['definition']['en']="Vocabulary containing grain types.";

		$result[1]['uri']="http://vocab.earthchemportal.org/vocabulary/material";
		$result[1]['prefLabel']['en']="Material";
		$result[1]['definition']['en']="Vocabulary containing material names.";

		$result[2]['uri']="http://vocab.earthchemportal.org/vocabulary/mineral";
		$result[2]['prefLabel']['en']="Mineral";
		$result[2]['definition']['en']="Vocabulary containing mineral names.";

		$result[3]['uri']="http://vocab.earthchemportal.org/vocabulary/person";
		$result[3]['prefLabel']['en']="Person";
		$result[3]['definition']['en']="Vocabulary containing entries for known people.";

		$result[4]['uri']="http://vocab.earthchemportal.org/vocabulary/rockClass";
		$result[4]['prefLabel']['en']="Rock Classification";
		$result[4]['definition']['en']="Vocabulary containing rock classifications.";

		$result[5]['uri']="http://vocab.earthchemportal.org/vocabulary/rockType";
		$result[5]['prefLabel']['en']="Rock Type";
		$result[5]['definition']['en']="Vocabulary containing rock types.";

	}else{

		//send an error header with brief explanation.
		header("Bad Request", true, 404);
		$result['Error']="No such vocabulary (".$showcontroller.")";
		header('Content-Type: application/json; charset=utf8');
	
	}
}

$view_name = ucfirst($request->apiformat) . 'View';
if(class_exists($view_name)) {
	$view = new $view_name();
	$view->render($result);
}else{
	header("Bad Request", true, 400);
	echo "Error: $request->format output not supported.";
}