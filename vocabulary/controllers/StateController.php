<?php

/*
******************************************************************
Vocabulary REST API
State Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				state entries.
******************************************************************
*/

class StateController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("state","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from state where state_num=$searchid and status = 1");
				if($row->state_num){
						$num = $row->state_num;
						$preflabel = $row->state_name;
						$altlabel = $row->state_name;
						$definition = "State from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "State $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "State $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from state where lower(state_name) like '%$label%' and status = 1 order by state_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->state_num;
							$preflabel = $row->state_name;
							$altlabel = $row->state_name;
							$definition = "State from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");
							
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
				$rows = $this->db->get_results("select * from state where state_name != '' and status = 1 order by state_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->state_num;
					$preflabel = $row->state_name;
					$altlabel = $row->state_name;
					$definition = "State from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("state","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from state where state_num = $searchid");

				if($row->state_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update state set
										status = 0
										where state_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "State $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "State $id not found.";
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
								insert into state (
														state_name,
														country_num
														) values (
														'$preflabel',
														840
														)
				");

				$returnpkey = $this->db->get_var("select currval('state_state_num_seq');");
				$returnuri = $this->baseUri."state/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("state","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from state where state_num = $searchid");

				if($row->state_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
				
						$this->db->query("
										update state
										set
										state_name='$preflabel'
										where
										state_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "State $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "State $id not found.";
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


