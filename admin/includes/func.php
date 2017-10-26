<?php
/**
* func.php.
*
* This script contains some often-used functions
*
* @package    EC2ODM2 Application
* @author     Jason Ash <jasonash@ku.edu>
*/

/**
* Print Object
*
* This method prints out a human-readable version
* of the provided variable. The optional $label
* variable adds a label to the output.
*
* @param string $data Variable to output
* @param string $label Optional label
* @return string Human readable output.
*
*/
function printObj ($data = null, $label = null) {
  print "<pre>";
  if (isset($label)) {
    print $label;
  }
  if (isset($data)) {
    print_r($data);
  }
  print "</pre>";
} 

/**
* Upper Case Words
*
* Function to capitalize the first letter of each word separated by a delimiter
*
* @param string $str String to fix
* @param string $separator of string
* @return string Fixed string
*
*/
function ucwordsEx($str, $separator) {
  $str = str_replace($separator, " ", $str);
  $str = ucwords(strtolower($str));
  $str = str_replace(" ", $separator, $str);
  return $str;
}

/**
* EC2ODM2 Error
*
* Function to halt script and print an error message
*
* @param integer $die Whether to die or not
* @param string $msg Error Message
* @param string $display_msg Message to display
*
*/
function ec2odm2_error($die, $msg, $display_msg=null) {
  trigger_error($msg);
  if (isset($display_msg)) {
    //print $display_msg;
  }
  if ($die == 1) {
    if (function_exists('http_response_code')) {
        http_response_code(400);
    }
    else
    {
        header("Http/1.0 400 ");
    }
    exit;
  }
}

/**
* Do POST Request
*
* Function to POST to given URL
*
* @param string $url to POST to
* @param string $data to POST
* @param string $optional_headers Headers for Request
*
*/
function do_post_request($url, $data, $optional_headers = null) {
	$params = array('http' => array(
		'method' => 'post',
		'content' => $data
	));
	
	if ($optional_headers!== null) {
		$params['http']['header'] = $optional_headers;
	}

	$ctx = stream_context_create($params);
	$fp = @fopen($url, 'rb', false, $ctx);

	if (!$fp) {
		throw new Exception("Problem with $url, $php_errormsg");
	}
	
	$response = @stream_get_contents($fp);
	
	if ($response === false) {
		throw new Exception("Problem reading data from $url, $php_errormsg");
	}
	return $response;
}

/**
* Hash Unshift
*
* Function keep distinct values of two arrays
*
* @param array $keep Whether to die or not
* @param array $add_elems Existing elements
*
*/
function hash_unshift($keep, $add_elems) {
  if (is_array($add_elems)) {
    foreach ($add_elems as $idx => $val) {
      $new[$idx] = $val;
    }
  } 

  foreach ($keep as $idx => $val) {
    if (isset($new[$idx])) {
      error_log(__FUNCTION__ . "() duplicate index found ($idx).  keeping existing value in original hash.");
    }
    $new[$idx] = $val;
  }

  return $new;
}

/**
* Redirect
*
* Function to redirect browser to new location
*
* @param string $url to redirect to
*
*/
function redirect($url)
{
      if(function_exists('http_redirect') )
      {
        http_redirect($url,array(),TRUE,HTTP_REDIRECT_PERM);
      }
      else
      {
          header('Location:'.$url,TRUE,301);
          exit();
      }
}

/**
* newFileName
*
* Function to create new file name of an integer
* that does not exist in xlsfiles
*
*/
function newFileName()
{

	$finished = false;
	while (!$finished){
		$newfilename = rand(11111111,99999999);
		if (!file_exists("xlsfiles/$newfilename")){
			$finished = true;
		}
	}
	
	return $newfilename;
}

/**
* Check SQL Inject
*
* check to see if pass-in value is SQL injection string
* return true if it is attack otherwise false
*
* @param string $data to check for SQL Inject
*
*/
function check_sql_inject($data)
{
  $data = strtolower($data);

  if (strpos($data, "base64_") !== false)
      return true;

  if (strpos($data, "union") !== false && strpos($data, "select") !== false)
      return true;

  return false;
}

?>
