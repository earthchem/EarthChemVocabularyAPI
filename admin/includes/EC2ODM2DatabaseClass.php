<?php

/**
* EC2ODM2 Database Class.
*
* This class provides an abstraction layer to
* common database functions.
*
* @package    EC2ODM2 Application
* @author     Jason Ash <jasonash@ku.edu>
*/


/**
* EC2ODM2 Database Class.
*
* This class provides an abstraction layer to
* common database functions.
*/
class EC2ODM2Database
{

  	/**
 	* Constructor
 	*
 	* @param object $db Database handle
 	*
 	*/
 	public function EC2ODM2Database($db){
 		$this->db=$db;
 	}

  	/**
 	* Dump Var
 	*
 	* Helper function to debug any
 	* variable.
 	*
 	*
 	*/
 	public function dumpVar($var){
 	
 		echo "<pre>";
 		print_r($var);
 		echo "</pre>"; 
 	
 	}

  	/**
 	* Set DB Handler
 	*
 	* Optional method of setting db handle.
 	*
 	* @param object $db Database handle
 	*
 	*/
 	public function setdbhandler($db){
 		$this->db=$db;
 	}


  	/**
 	* EC2ODM2 Die
 	*
 	* Die function for EC2ODM2
 	*
 	* @param string $message Message to output
 	*
 	*/
 	public function ec2odm2Die($message){
		$trace = debug_backtrace();
		$trace=end($trace);
		//$this->dumpVar($trace);exit();
		$tracefile=$trace['file'];
		$traceline=$trace['line'];
		die("Error: $message; Terminated on line " . $traceline . " in " . $tracefile);
 	}





  	/**
 	* Query
 	*
 	* Performs database query.
 	*
 	* @param string $querystring Query to pass to database
 	* @param array $parameters Array of parameters to pass to prepared statement
 	* @return object of database output
 	*
 	*/
	public function query($querystring,$parameters){
		
		$sth = $this->db->prepare($querystring);

		if (PEAR::isError($sth)) {
		ec2odm2_error(EC2ODM2_DIE, 
					'in ' . __FILE__ . 
					' on line ' . __LINE__ . ' :: ' . 
					$sth->getMessage() . " - " . $sth->getUserInfo(),
					USER_FRIENDLY_ERROR);
		}

		$result = $sth->execute($parameters);
		
		//printObj($result);exit();
		
		if (PEAR::isError($result)) {
		ec2odm2_error(EC2ODM2_DIE, 
					'in ' . __FILE__ . 
					' on line ' . __LINE__ . ' :: ' . 
					$result->getMessage() . " - " . $result->getUserInfo(),
					USER_FRIENDLY_ERROR);
		}


		//printObj($result);exit();
		
		$rv = $result->fetchAll();
		
		return $rv;
	}
	
  	/**
 	* Get Results
 	*
 	* Retrieves multiple rows from database.
 	*
 	* @param string $querystring Query to pass to database
 	* @param array $parameters Array of parameters to pass to prepared statement
 	* @return object of query results from database
 	*
 	*/
	public function get_row($querystring,$parameters){
	
		$rv = $this->query($querystring,$parameters);
		
		if(count($rv)>1){
			$this->ec2odm2Die("get_row query returned more than one row. Querystring: $querystring");
		}
		
		//convert to object
		$rv=$rv[0];
		
		return $rv;
	
	}

  	/**
 	* Get Row
 	*
 	* Retrieves single row from database.
 	*
 	* @param string $querystring Query to pass to database
 	* @param array $parameters Array of parameters to pass to prepared statement
 	* @return object of query results from database
 	*
 	*/
	public function get_results($querystring,$parameters){
	
		$rv = $this->query($querystring,$parameters);
		
		return $rv;
	
	}



  	/**
 	* Get Var
 	*
 	* Retrieves single var from database.
 	*
 	* @param string $querystring Query to pass to database
 	* @param array $parameters Array of parameters to pass to prepared statement
 	* @return string of query results from database
 	*
 	*/
	public function get_var($querystring,$parameters){
	
		$rv = $this->query($querystring,$parameters);

		if( count($rv)>1 || count($rv[0])>1 ){
			ec2odm2_error(EC2ODM2_DIE, 
						'in ' . __FILE__ . 
						' on line ' . __LINE__ . ' :: ' . 
						"More than one result returned for get_var. ($querystring)",
						USER_FRIENDLY_ERROR);
		}
		
		$rv = $rv[0];
		$rv = reset($rv);
		
		return $rv;
	
	}

	
}

?>