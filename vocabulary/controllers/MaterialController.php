<?php

/*
******************************************************************
Vocabulary REST API
Material Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				material entries.
******************************************************************
*/

class MaterialController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("mat","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Material' and taxonomic_classifier_num=$searchid");
				if($row->taxonomic_classifier_num){
						$num = $row->taxonomic_classifier_num;
						$name = $row->taxonomic_classifier_name;
						$definition = "Material from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("material", $num, $name, $name, $definition, "mat");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Material $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Material $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Material' and lower(taxonomic_classifier_name) like '%$label%';
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->taxonomic_classifier_num;
							$name = $row->taxonomic_classifier_name;
							$definition = "Material from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("material", $num, $name, $name, $definition, "mat");
							
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
				$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Material' order by taxonomic_classifier_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$name = $row->taxonomic_classifier_name;
					$definition = "Material from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("material", $num, $name, $name, $definition, "mat");

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


