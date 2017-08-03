<?php

/*
******************************************************************
Vocabulary REST API
Mineral Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				mineral entries.
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

class MineralController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("min","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Mineral' and taxonomic_classifier_num=$searchid");
				if($row->taxonomic_classifier_num){
						$num = $row->taxonomic_classifier_num;
						$name = $row->taxonomic_classifier_name;
						$definition = "Mineral from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("mineral", $num, $name, $name, $definition, "min");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Mineral $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Mineral $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Mineral' and lower(taxonomic_classifier_name) like '%$label%';
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->taxonomic_classifier_num;
							$name = $row->taxonomic_classifier_name;
							$definition = "Mineral from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("mineral", $num, $name, $name, $definition, "min");
							
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
				$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Mineral' order by taxonomic_classifier_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$name = $row->taxonomic_classifier_name;
					$definition = "Mineral from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("mineral", $num, $name, $name, $definition, "min");
					
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
