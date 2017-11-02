<?php

/*
******************************************************************
Vocabulary REST API
Uncertainty Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				uncertainty type entries.
******************************************************************
*/

class UncertaintyTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("uncerttype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from dataquality_type where dataquality_type_num=$searchid and status = 1");
				if($row->dataquality_type_num){
						$num = $row->dataquality_type_num;
						$preflabel = $row->dataquality_type_name;
						$altlabel = $row->dataquality_type_name;
						$definition = $row->dataquality_type_description;
					
						$data=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Uncertainty Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Uncertainty Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from dataquality_type where lower(dataquality_type_name) like '%$label%' and status = 1 order by dataquality_type_description;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->dataquality_type_num;
							$preflabel = $row->dataquality_type_name;
							$altlabel = $row->dataquality_type_name;
							$definition = $row->dataquality_type_description;
					
							$data['results'][]=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");
							
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

				//list all action_type entries here
				$rows = $this->db->get_results("select * from dataquality_type where status = 1 order by dataquality_type_description;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->dataquality_type_num;
					$preflabel = $row->dataquality_type_name;
					$altlabel = $row->dataquality_type_name;
					$definition = $row->dataquality_type_description;
					
					$data['results'][]=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("uncerttype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from dataquality_type where dataquality_type_num = $searchid");

				if($row->dataquality_type_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update dataquality_type set
										status = 0
										where dataquality_type_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Uncertainty Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Uncertainty Type $id not found.";
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
			
				$description = $p['definition']->en;
				
				$this->db->query("
								insert into dataquality_type (
														dataquality_type_name,
														dataquality_type_description
														) values (
														'$preflabel',
														'$description'
														)
				");

				$returnpkey = $this->db->get_var("select currval('dataquality_type_dataquality_type_num_seq');");
				$returnuri = $this->baseUri."uncertaintyType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("uncerttype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from dataquality_type where dataquality_type_num = $searchid");

				if($row->dataquality_type_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$description = $p['definition']->en;
				
						$this->db->query("
										update dataquality_type
										set
										dataquality_type_name='$preflabel',
										dataquality_type_description='$description'
										where
										dataquality_type_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Uncertainty Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Uncertainty Type $id not found.";
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


