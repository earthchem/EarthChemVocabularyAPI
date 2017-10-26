<?php
/**
 * <pre>
 * File:       results.php
 * Time-stamp: Sun Mar 25 07:17:22 2012 
 * Author:     
 * Maintainer:
 * Created: Sun Sep 19 01:23:32 2010
 *
 * Commentary:
 *
 *
 * </pre>
 * @package
 */

require_once '../../api/db_web.php';
require_once '../../api/get.php';
require_once '../../api/func.php';
require_once '../../api/sesarUser.php';

session_start();
//error_log(print_r($_REQUEST,1));
$logged_in_user_id = null;

if (isset($_SESSION['user']) && 
    isset($_SESSION['user']->sesar_user_id) &&
    !empty($_SESSION['user']->sesar_user_id)) {
  $logged_in_user_id = $_SESSION['user']->sesar_user_id;
}
// if any search filter supplied
if ((isset($_REQUEST['top_level_classification_id']) && 
     !empty($_REQUEST['top_level_classification_id'])) ||
    (isset($_REQUEST['polygon']) && !empty($_REQUEST['polygon'])) ||
    (isset($_REQUEST['country']) && !empty($_REQUEST['country'])) ||
    (isset($_REQUEST['geo']) && !empty($_REQUEST['geo'])) ||
    (isset($_REQUEST['north']) && is_numeric($_REQUEST['north'])) ||
    (isset($_REQUEST['south']) && is_numeric($_REQUEST['south'])) ||
    (isset($_REQUEST['east']) && is_numeric($_REQUEST['east'])) ||
    (isset($_REQUEST['west']) && is_numeric($_REQUEST['west'])) ||
    (isset($_REQUEST['classification_id']) && !empty($_REQUEST['classification_id'])) ||
    (isset($_REQUEST['name_number']) && !empty($_REQUEST['name_number'])) ||
    (isset($_REQUEST['igsn']) && !empty($_REQUEST['igsn'])) ||
    (isset($_REQUEST['archive']) && !empty($_REQUEST['archive'])) ||
    (isset($_REQUEST['registrar_id']) && !empty($_REQUEST['registrar_id'])) ||
    (isset($_REQUEST['registration_date_start']) && !empty($_REQUEST['registration_date_start'])) ||
    (isset($_REQUEST['registration_date_end']) && !empty($_REQUEST['registration_date_end'])) ||
    (isset($_REQUEST['collector']) && !empty($_REQUEST['collector'])) ||
    (isset($_REQUEST['cruise_field_prgrm']) && !empty($_REQUEST['cruise_field_prgrm'])) ||
    (isset($_REQUEST['collection_method']) && !empty($_REQUEST['collection_method'])) ||
    (isset($_REQUEST['platform_type']) && !empty($_REQUEST['platform_type'])) ||
    (isset($_REQUEST['platform_name']) && !empty($_REQUEST['platform_name'])) ||
	(isset($_REQUEST['classFieldName']) && !empty($_REQUEST['classFieldName'])) 
	) {
  // do search
  // if we are not counting
  if (!isset($_REQUEST['counting']) || $_REQUEST['counting'] != 1) {
    $matches = sesar_get_search_matches($db_web, $_REQUEST, null, $logged_in_user_id);
    if (!isset($_REQUEST['download'])) {
      print json_encode($matches);
    } 
  } else if (count($_REQUEST) > 5) { 
    unset($_REQUEST['sample_type_id']);
  //  $num_matches = sesar_get_search_num_matches($db_web, $_REQUEST, $logged_in_user_id);
    $num_matches = sesar_get_search_num_matches_new($db_web, $_REQUEST, $logged_in_user_id);
    print json_encode($num_matches);
  }

  if (isset($_REQUEST['download'])) {
    require_once '../../api/MetadataExcelWriter.php';

    // title of download file
    $title = 'sesar_search_' . time();
    $file_name =  $title.'.xlsx';
    MetadataExcelWriter::writeToExcel($matches,$title,'extended',$file_name);
  }
}
?>
