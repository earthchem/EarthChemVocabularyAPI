<?php

/*
******************************************************************
Vocabulary REST API
Person Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				person entries.
******************************************************************
*/

/*
        "uri": "http:\/\/vocab.earthchemportal.org\/vocabulary\/person\/per1546",
        "prefLabel": {
            "en": "Abranson E. C."
        },
        "altLabel": {
            "en": "Abranson E. C."
        },
        "definition": {
            "en": "Author from EarthChem Portal"
        }

jsonObject($controller, $num, $preflabel, $altlabel, $definition, $prefix)

*/

class PersonController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("per","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from person where person_num=$searchid");
				if($row->person_num){
						$num = $row->person_num;
						$name = trim($row->last_name.", ".$row->first_name." ".$row->middle_name);
						$definition = "Person from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("person", $num, $name, $name, $definition, "per");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Person $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Person $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("
													
													select person_num, name from (
													select
													person_num,
													trim(last_name || ', ' || first_name || ' ' || middle_name) as name
													from (
													select
													person_num,
													(CASE WHEN first_name is not null THEN first_name ELSE '' END) AS first_name,
													(CASE WHEN middle_name is not null THEN middle_name ELSE '' END) AS middle_name,
													(CASE WHEN last_name is not null THEN last_name ELSE '' END) AS last_name
													from person) foo
													) foob
													where lower(name) like '%$label%';
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->person_num;
							$name = $row->name;
							$definition = "Person from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("person", $num, $name, $name, $definition, "per");
							
						}
					}else{
						$data['resultcount']=0;
						$data['results']=array();
					}
        		
        		}else{
        		
					header("Bad Request", true, 400);
					$data["Error"] = "Invalid Query Parameter.";
        		
        		}
        	
        	}else{

				//list all person entries here
				$rows = $this->db->get_results("select * from person order by last_name, first_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->person_num;
					$name = trim($row->last_name.", ".$row->first_name." ".$row->middle_name);
					$definition = "Person from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("person", $num, $name, $name, $definition, "per");
					
					//{"uri":"http:\/\/vocab.earthchemportal.org\/vocabulary\/person\/per2509","prefLabel":{"en":"Dahren, B."},"altLabel":{"en":"Dahren, B."},"definition":{"en":"Author from EarthChem Portal"}}

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {

    }

    public function postAction($request) {

    }

    public function putAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function optionsAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function patchAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function copyAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function searchAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }


}

/*
        		unset($thisobject);
        		$thisobject['uri']="http://vocab.earthchemportal.org/vocabulary/person/$row->item_id";
        		$thisobject['prefLabel']['en']=$row->preferred_label;
        		$thisobject['altLabel']['en']=$row->alt_label;
        		$thisobject['definition']['en']=$row->definition;
        		$data[]=$thisobject;
*/
