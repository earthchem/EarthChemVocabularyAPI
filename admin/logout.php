<?PHP
/**
 * logout.php
 *
 * longdesc
 *
 * LICENSE: This source file is subject to version 4.0 of the Creative Commons
 * license that is available through the world-wide-web at the following URI:
 * https://creativecommons.org/licenses/by/4.0/
 *
 * @category   Administration
 * @package    Administration Interface
 * @author     Jason Ash <jasonash@ku.edu>
 * @copyright  IEDA (http://www.iedadata.org/)
 * @license    https://creativecommons.org/licenses/by/4.0/  Creative Commons License 4.0
 * @version    GitHub: $
 * @link       http://admin.earthchemportal.org
 * @see        Earthchem, Admin
 */

function dumpVar($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

//kill session
session_start();
$_SESSION['user_pkey']='';
$_SESSION['user_level']='';
$_SESSION['loggedin']="no";
$_SESSION = array();
session_destroy();

header("Location:/");

?>