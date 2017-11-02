<?php

/*
******************************************************************
Vocabulary REST API
Equipment Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				equipment type entries.
******************************************************************
*/

class EquipmentTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("eqtype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from equipment_type where equipment_type_num=$searchid and status = 1");
				if($row->equipment_type_num){
						$num = $row->equipment_type_num;
						$preflabel = $row->equipment_type_name;
						$altlabel = $row->equipment_type_name;
						$definition = $row->equipment_type_description;
					
						$data=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from equipment_type where lower(equipment_type_name) like '%$label%' and status = 1 order by equipment_type_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->equipment_type_num;
							$preflabel = $row->equipment_type_name;
							$altlabel = $row->equipment_type_name;
							$definition = $row->equipment_type_description;
					
							$data['results'][]=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");
							
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
				$rows = $this->db->get_results("select * from equipment_type where status = 1 order by equipment_type_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->equipment_type_num;
					$preflabel = $row->equipment_type_name;
					$altlabel = $row->equipment_type_name;
					$definition = $row->equipment_type_description;
					
					$data['results'][]=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("eqtype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from equipment_type where equipment_type_num = $searchid");

				if($row->equipment_type_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update equipment_type set
										status = 0
										where equipment_type_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment Type $id not found.";
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
								insert into equipment_type (
														equipment_type_name,
														equipment_type_description
														) values (
														'$preflabel',
														'$description'
														)
				");
			
				$returnpkey = $this->db->get_var("select currval('equipment_type_equipment_type_num_seq');");
				$returnuri = $this->baseUri."equipmentType/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}


        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("eqtype","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from equipment_type where equipment_type_num = $searchid");

				if($row->equipment_type_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$description = $p['definition']->en;
				
						$this->db->query("
										update equipment_type
										set
										equipment_type_name='$preflabel',
										equipment_type_description='$description'
										where
										equipment_type_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment Type $id not found.";
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


