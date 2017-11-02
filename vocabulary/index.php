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
		$result[1]['uri']="http://vocab.earthchemportal.org/vocabulary/chemicalAnlysisType"; $result[1]['prefLabel']['en']="Chemical Analysis Type"; $result[1]['definition']['en']="Vocabulary containing Chemical Analysis Type entries.";
		$result[2]['uri']="http://vocab.earthchemportal.org/vocabulary/country"; $result[2]['prefLabel']['en']="Country"; $result[2]['definition']['en']="Vocabulary containing Country entries.";
		$result[3]['uri']="http://vocab.earthchemportal.org/vocabulary/equipmentType"; $result[3]['prefLabel']['en']="Equipment Type"; $result[3]['definition']['en']="Vocabulary containing Equipment Type entries.";
		$result[4]['uri']="http://vocab.earthchemportal.org/vocabulary/expeditionType"; $result[4]['prefLabel']['en']="Expedition Type"; $result[4]['definition']['en']="Vocabulary containing Expedition Type entries.";
		$result[5]['uri']="http://vocab.earthchemportal.org/vocabulary/grainType"; $result[5]['prefLabel']['en']="Grain Type"; $result[5]['definition']['en']="Vocabulary containing Grain Type entries.";
		$result[6]['uri']="http://vocab.earthchemportal.org/vocabulary/material"; $result[6]['prefLabel']['en']="Material"; $result[6]['definition']['en']="Vocabulary containing Material entries.";
		$result[7]['uri']="http://vocab.earthchemportal.org/vocabulary/methodType"; $result[7]['prefLabel']['en']="Method Type"; $result[7]['definition']['en']="Vocabulary containing Method Type entries.";
		$result[8]['uri']="http://vocab.earthchemportal.org/vocabulary/mineral"; $result[8]['prefLabel']['en']="Mineral"; $result[8]['definition']['en']="Vocabulary containing Mineral entries.";
		$result[9]['uri']="http://vocab.earthchemportal.org/vocabulary/organizationType"; $result[9]['prefLabel']['en']="Organization Type"; $result[9]['definition']['en']="Vocabulary containing Organization Type entries.";
		$result[10]['uri']="http://vocab.earthchemportal.org/vocabulary/rockClass"; $result[10]['prefLabel']['en']="Rock Class"; $result[10]['definition']['en']="Vocabulary containing Rock Class entries.";
		$result[11]['uri']="http://vocab.earthchemportal.org/vocabulary/rockType"; $result[11]['prefLabel']['en']="Rock Type"; $result[11]['definition']['en']="Vocabulary containing Rock Type entries.";
		$result[12]['uri']="http://vocab.earthchemportal.org/vocabulary/state"; $result[12]['prefLabel']['en']="State"; $result[12]['definition']['en']="Vocabulary containing State entries.";
		$result[13]['uri']="http://vocab.earthchemportal.org/vocabulary/uncertaintyType"; $result[13]['prefLabel']['en']="Uncertainty Type"; $result[13]['definition']['en']="Vocabulary containing Uncertainty Type entries.";


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