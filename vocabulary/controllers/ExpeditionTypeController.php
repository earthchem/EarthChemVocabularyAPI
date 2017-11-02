<?php
/*
******************************************************************
Vocabulary REST API
Expedition Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				expedition type entries.
******************************************************************
*/

class ExpeditionTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("exptype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from action_type where action_sub_type='expedition_type' and action_type_num=$searchid and status = 1");
				if($row->action_type_num){
						$num = $row->action_type_num;
						$preflabel = $row->action_type_name;
						$altlabel = $row->action_type_name;
						$definition = $row->action_type_description;
					
						$data=$this->jsonObject("expeditionType", $num, $preflabel, $altlabel, $definition, "exptype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Expedition Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Expedition Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from action_type where action_sub_type='expedition_type' and lower(action_type_name) like '%$label%' and status = 1
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->action_type_num;
							$preflabel = $row->action_type_name;
							$altlabel = $row->action_type_name;
							$definition = $row->action_type_description;
					
							$data['results'][]=$this->jsonObject("expeditionType", $num, $preflabel, $altlabel, $definition, "exptype");
							
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
				$rows = $this->db->get_results("select * from action_type where action_sub_type='expedition_type' and status = 1 order by action_type_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->action_type_num;
					$preflabel = $row->action_type_name;
					$altlabel = $row->action_type_name;
					$definition = $row->action_type_description;
					
					$data['results'][]=$this->jsonObject("expeditionType", $num, $preflabel, $altlabel, $definition, "exptype");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("exptype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from action_type where action_type_num = $searchid");

				if($row->action_type_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update action_type set
										status = 0
										where action_type_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Expedition Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Expedition Type $id not found.";
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
								insert into action_type (
														action_type_name,
														action_type_description,
														action_sub_type
														) values (
														'$preflabel',
														'$description',
														'expedition_type'
														)
				");

				$returnpkey = $this->db->get_var("select currval('action_type_action_type_num_seq');");
				$returnuri = $this->baseUri."expeditionType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("exptype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from action_type where action_type_num = $searchid");

				if($row->action_type_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$description = $p['definition']->en;
				
						$this->db->query("
										update action_type
										set
										action_type_name='$preflabel',
										action_type_description='$description'
										where
										action_type_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Expedition Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Expedition Type $id not found.";
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


