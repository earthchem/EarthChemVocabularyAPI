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
				$row = $this->db->get_row("select * from earthchem.material where material_num=$searchid and status = 1");
				if($row->material_num){
					$num = $row->material_num;
					$preflabel = $row->material_code;
					$altlabel = $row->material_name;

					$data=$this->jsonObject("material", $num, $preflabel, $altlabel, $definition, "mat");
					
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
					
					$rows = $this->db->get_results("select * from earthchem.material where (lower(material_code) like '%$label%' or lower(material_code) like '%$label%') and status = 1
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->material_num;
							$preflabel = $row->material_code;
							$altlabel = $row->material_name;
					
							$data['results'][]=$this->jsonObject("material", $num, $preflabel, $altlabel, $definition, "mat");
							
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
				$rows = $this->db->get_results("select * from earthchem.material where status = 1 order by material_code");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->material_num;
					$preflabel = $row->material_code;
					$altlabel = $row->material_name;
			
					$data['results'][]=$this->jsonObject("material", $num, $preflabel, $altlabel, $definition, "mat");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("mat","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.material where material_num = $searchid");

				if($row->material_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update earthchem.material_num set
										status = 0
										where material_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Material $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Material $id not found.";
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
			$altlabel = $p['altLabel']->en;

			if($preflabel == ""){
			
				header("Bad Request", true, 400);
				$data["Error"] = "Preferred Label must be provided.";
			}elseif($altlabel == ""){
			
				header("Bad Request", true, 400);
				$data["Error"] = "Alternate Label must be provided.";
			}
			else{
			

				$description = $p['definition']->en;
				
				$this->db->query("
								insert into earthchem.material (
														material_code,
														material_name
														) values (
														'$preflabel',
														'$altlabel'
														)
				");

				$returnpkey = $this->db->get_var("select currval('earthchem.material_material_num_seq');");
				$returnuri = $this->baseUri."material/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;

			}

        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("mat","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.material where material_num = $searchid");

				if($row->material_num){

					$p = $request->parameters;
						
					$preflabel = $p['prefLabel']->en;
					$altlabel = $p['altLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}elseif($altlabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Alternate Label must be provided.";
					}
					else{

						$description = $p['definition']->en;
				
						$this->db->query("
										update earthchem.material
										set
										material_code='$preflabel',
										material_name='$altlabel'
										where
										material_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Material $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Material $id not found.";
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


