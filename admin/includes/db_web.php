<?php
/**
* DB Web.
*
* This script uses pre-defined credentials
* to connect to a postgres database
*
* @package    EC2ODM2 Application
* @author     Jason Ash <jasonash@ku.edu>
*/

require_once 'constants.php';
require_once 'func.php';
require_once 'MDB2.php';
$programRoot = $_SERVER['DOCUMENT_ROOT'];

if(!isset($programRoot) || strlen($programRoot) == 0 )
    $programRoot = dirname(__FILE__).'/../';

require_once "$programRoot/conf/DBCreds.php";

// connect to db
  $dsn_web = array('phptype' => 'pgsql',
               'username' => DBLOGIN_WEB,
               'password' => DBPASSWORD_WEB,
               'hostspec' => SERVERNAME,
               'port' => PORT,
               'database' => DBNAME);

  $db_web =& MDB2::connect($dsn_web);

if (PEAR::isError($db_web)) {
  ec2odm2_error(EC2ODM2_DIE, 
              'in ' . __FILE__ . 
              ' on line ' . __LINE__ . ' :: ' . 
              $db_web->getMessage() . " - " . $db_web->getUserInfo(), 
              //USER_FRIENDLY_ERROR);
              "database connection failed.");
}

// set db fetchmod 
$db_web->setFetchMode(MDB2_FETCHMODE_OBJECT); //OBJECTS are easier than associative arrays (MDB2_FETCHMODE_ASSOC)

?>
