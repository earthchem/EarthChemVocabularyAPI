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
				$row = $this->db->get_row("select * from earthchem.taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' and taxonomic_classifier_num=$searchid and status = 1");
				if($row->taxonomic_classifier_num){
						$num = $row->taxonomic_classifier_num;
						$preflabel = $row->taxonomic_classifier_name;
						$altlabel = $row->taxonomic_classifier_common_name;
						$definition = $row->taxonomic_classifier_description;
					
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
					
					$rows = $this->db->get_results("select * from earthchem.taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' and lower(taxonomic_classifier_name) like '%$label%' and status = 1
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->taxonomic_classifier_num;
							$preflabel = $row->taxonomic_classifier_name;
							$altlabel = $row->taxonomic_classifier_common_name;
							$definition = $row->taxonomic_classifier_description;
					
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
				$rows = $this->db->get_results("select * from earthchem.taxonomic_classifier where taxonomic_classifier_type_cv='Grain Type' and status = 1 order by taxonomic_classifier_common_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$preflabel = $row->taxonomic_classifier_name;
					$altlabel = $row->taxonomic_classifier_common_name;
					$definition = $row->taxonomic_classifier_description;
					
					$data['results'][]=$this->jsonObject("grainType", $num, $preflabel, $altlabel, $definition, "gtyp");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("gtyp","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.taxonomic_classifier where taxonomic_classifier_num = $searchid");

				if($row->taxonomic_classifier_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update earthchem.taxonomic_classifier set
										status = 0
										where taxonomic_classifier_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Grain Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Grain Type $id not found.";
			}

        } else {

			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }
        return $data;
    }

    public function postAction($request) {
    
        if(isset($request->url_elements[2])) {
        
			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }else{

			$p = $request->parameters;

			$preflabel = $p['prefLabel']->en;

			if($preflabel == ""){
			
				header("Bad Request", true, 400);
				$data["Error"] = "Preferred Label must be provided.";
			}
			else{
			
				$altlabel = $p['altLabel']->en;
				$description = $p['definition']->en;
				
				$this->db->query("
								insert into earthchem.taxonomic_classifier (
														taxonomic_classifier_name,
														taxonomic_classifier_common_name,
														taxonomic_classifier_description,
														taxonomic_classifier_type_cv
														) values (
														'$preflabel',
														'$altlabel',
														'$description',
														'Grain Type'
														)
				");

				$returnpkey = $this->db->get_var("select currval('earthchem.taxonomic_classifier_taxonomic_classifier_num_seq');");
				$returnuri = $this->baseUri."grainType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("gtyp","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.taxonomic_classifier where taxonomic_classifier_num = $searchid");

				if($row->taxonomic_classifier_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$altlabel = $p['altLabel']->en;
						$description = $p['definition']->en;
				
						$this->db->query("
										update earthchem.taxonomic_classifier
										set
										taxonomic_classifier_name='$preflabel',
										taxonomic_classifier_common_name='$altlabel',
										taxonomic_classifier_description='$description'
										where
										taxonomic_classifier_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Chemical Analysis Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Chemical Analysis Type $id not found.";
			}

        } else {

			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }
        
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


