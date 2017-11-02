<?php

/*
******************************************************************
Vocabulary REST API
Rock Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				rock type entries.
******************************************************************
*/

class RocktypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("rtyp","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Rock Type' and taxonomic_classifier_num=$searchid and status = 1");
				if($row->taxonomic_classifier_num){
						$num = $row->taxonomic_classifier_num;
						$preflabel = $row->taxonomic_classifier_name;
						$altlabel = $row->taxonomic_classifier_common_name;
						$definition = $row->taxonomic_classifier_description;
					
						$data=$this->jsonObject("rockType", $num, $preflabel, $altlabel, $definition, "rtyp");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Rock Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Rock Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Rock Type' and lower(taxonomic_classifier_name) like '%$label%' and status = 1
													
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
					
							$data['results'][]=$this->jsonObject("rockType", $num, $preflabel, $altlabel, $definition, "rtyp");
							
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
				$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Rock Type' and status = 1 order by taxonomic_classifier_common_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$preflabel = $row->taxonomic_classifier_name;
					$altlabel = $row->taxonomic_classifier_common_name;
					$definition = $row->taxonomic_classifier_description;
					
					$data['results'][]=$this->jsonObject("rockType", $num, $preflabel, $altlabel, $definition, "rtyp");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("rtyp","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_num = $searchid");

				if($row->taxonomic_classifier_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update taxonomic_classifier set
										status = 0
										where taxonomic_classifier_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Rock Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Rock Type $id not found.";
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
								insert into taxonomic_classifier (
														taxonomic_classifier_name,
														taxonomic_classifier_common_name,
														taxonomic_classifier_description,
														taxonomic_classifier_type_cv
														) values (
														'$preflabel',
														'$altlabel',
														'$description',
														'Rock Type'
														)
				");

				$returnpkey = $this->db->get_var("select currval('taxonomic_classifier_taxonomic_classifier_num_seq');");
				$returnuri = $this->baseUri."rockType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("rtyp","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from taxonomic_classifier where taxonomic_classifier_num = $searchid");

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
										update taxonomic_classifier
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
					$data["Error"] = "Rock Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Rock Type $id not found.";
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


