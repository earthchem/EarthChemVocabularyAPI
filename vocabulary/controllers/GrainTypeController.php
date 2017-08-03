<?php

/*
******************************************************************
Vocabulary REST API
Grain Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				grain type entries.
******************************************************************
*/

class GraintypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("gtyp","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' and taxonomic_classifier_num=$searchid");
				if($row->taxonomic_classifier_num){
						$num = $row->taxonomic_classifier_num;
						$preflabel = $row->taxonomic_classifier_name;
						$altlabel = $row->taxonomic_classifier_common_name;
						$definition = "Grain Type from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("grainType", $num, $preflabel, $altlabel, $definition, "gtyp");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Grain Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Grain Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' and lower(taxonomic_classifier_common_name) like '%$label%';
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->taxonomic_classifier_num;
							$preflabel = $row->taxonomic_classifier_name;
							$altlabel = $row->taxonomic_classifier_common_name;
							$definition = "Grain Type from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("grainType", $num, $preflabel, $altlabel, $definition, "gtyp");
							
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
				$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' order by taxonomic_classifier_common_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$preflabel = $row->taxonomic_classifier_name;
					$altlabel = $row->taxonomic_classifier_common_name;
					$definition = "Grain Type from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("grainType", $num, $preflabel, $altlabel, $definition, "gtyp");

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


