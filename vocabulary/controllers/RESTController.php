<?php

/*
******************************************************************
Vocabulary REST API
REST Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This is the base controller for the Vocabulary API.
				All other controllers stem from this class.
******************************************************************
*/

class RESTController
{
 	
 	public function setDB($db){
 		$this->db = $db;
 	}

 	public function dumpVar($var){
 		echo "<pre>";
 		print_r($var);
 		echo "</pre>";
 	}
 	
 	function setUri($uri){
 		$this->baseUri=$uri;
 	}

	public function jsonObject($controller, $num, $preflabel, $altlabel, $definition, $prefix){
		
		if(!$altlabel)$altlabel=$preflabel;
		
		$thisobj = [];
		$thisobj['uri']=$this->baseUri."$controller/$prefix$num";
		$thisobj['prefLabel']['en']=$preflabel;
		$thisobj['altLabel']['en']=$altlabel;
		$thisobj['definition']['en']=$definition;
		
		return $thisobj;
	}

}
