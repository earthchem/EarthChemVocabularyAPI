<?php

/*
******************************************************************
Vocabulary REST API
Country Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				country entries.
******************************************************************
*/

class countryController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("country","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from country where country_num=$searchid and status = 1");
				if($row->country_num){
						$num = $row->country_num;
						$preflabel = $row->country_name;
						$altlabel = $row->country_full_name;
						$definition = "country from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Country $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Country $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from country where lower(country_name) like '%$label%' and status = 1 order by country_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->country_num;
							$preflabel = $row->country_name;
							$altlabel = $row->country_full_name;
							$definition = "Country from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");
							
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
				$rows = $this->db->get_results("select * from country where country_name != '' and status = 1 order by country_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->country_num;
					$preflabel = $row->country_name;
					$altlabel = $row->country_full_name;
					$definition = "Country from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("country","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from country where country_num = $searchid");

				if($row->country_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update country set
										status = 0
										where country_num = $searchid
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Country $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Country $id not found.";
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
				
				$this->db->query("
								insert into country (
														country_name,
														country_code,
														country_abbrev,
														country_full_name
														) values (
														'$preflabel',
														'',
														'',
														'$altlabel'
														)
				");
				
				$returnpkey = $this->db->get_var("select currval('country_country_num_seq');");
				$returnuri = $this->baseUri."country/".$returnpkey;
				$data=$p;
				$data['uri']=$returnuri;
			
			}



        }
        
        return $data;


    }

    public function putAction($request) {

        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("country","",$id);

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from country where country_num = $searchid");

				if($row->country_num){

					$p = $request->parameters;
					
					//print_r($p);exit();
						
					$preflabel = $p['prefLabel']->en;

					if($preflabel == ""){
			
						header("Bad Request", true, 400);
						$data["Error"] = "Preferred Label must be provided.";
					}
					else{
			
						$altlabel = $p['altLabel']->en;
				
						$this->db->query("
										update country
										set
										country_name='$preflabel',
										country_code='',
										country_abbrev='',
										country_full_name='$altlabel'
										where
										country_num = $searchid;
						");
			
					}

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Country $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Country $id not found.";
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


