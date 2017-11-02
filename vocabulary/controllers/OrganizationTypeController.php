<?php

/*
******************************************************************
Vocabulary REST API
Organization Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				organization type entries.
******************************************************************
*/

class OrganizationTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("orgtype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from organization_type where organization_type_num=$searchid and status = 1");
				if($row->organization_type_num){
						$num = $row->organization_type_num;
						$preflabel = $row->organization_type_name;
						$altlabel = $row->organization_type_name;
						$definition = $row->organization_type_description;
					
						$data=$this->jsonObject("organizationType", $num, $preflabel, $altlabel, $definition, "orgtype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Organization Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Organization Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from organization_type where lower(organization_type_name) like '%$label%' and status = 1 order by organization_type_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->organization_type_num;
							$preflabel = $row->organization_type_name;
							$altlabel = $row->organization_type_name;
							$definition = $row->organization_type_description;
					
							$data['results'][]=$this->jsonObject("organizationType", $num, $preflabel, $altlabel, $definition, "orgtype");
							
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
				$rows = $this->db->get_results("select * from organization_type where status = 1 order by organization_type_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->organization_type_num;
					$preflabel = $row->organization_type_name;
					$altlabel = $row->organization_type_name;
					$definition = $row->organization_type_description;
					
					$data['results'][]=$this->jsonObject("organizationType", $num, $preflabel, $altlabel, $definition, "orgtype");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("orgtype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from organization_type where organization_type_num = $searchid");

				if($row->organization_type_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update organization_type set
										status = 0
										where organization_type_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Organization Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Organization Type $id not found.";
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
								insert into organization_type (
														organization_type_name,
														organization_type_description
														) values (
														'$preflabel',
														'$description'
														)
				");

				$returnpkey = $this->db->get_var("select currval('organization_type_organization_type_num_seq');");
				$returnuri = $this->baseUri."organizationType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;
			
			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("orgtype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from organization_type where organization_type_num = $searchid");

				if($row->organization_type_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$description = $p['definition']->en;
				
						$this->db->query("
										update organization_type
										set
										organization_type_name='$preflabel',
										organization_type_description='$description'
										where
										organization_type_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Organization Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Organization Type $id not found.";
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


