<?PHP
/**
 * logincheck.php
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

session_start();

$_SESSION['foo']="bar";

$userpkey = $_SESSION['userpkey'];

if ($_SESSION['loggedin']!="yes" ) {
	$_SESSION['currentpage']=$_SERVER['REQUEST_URI'];

	header("Location:login");
}

?>