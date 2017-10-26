<?php
/**
* constants.php.
*
* This script sets various constants used in the rest of the application.
*
* @package    EC2ODM2 Application
* @author     Jason Ash <jasonash@ku.edu>
*/
 
if(!defined('EC2ODM2_DIE'))
  define ('EC2ODM2_DIE', 1);

if(!defined('EC2ODM2_WARN'))
  define ('EC2ODM2_WARN', 0);

if(!defined('USER_FRIENDLY_ERROR'))
  define ('USER_FRIENDLY_ERROR', 
        'our site is own for maintenance at the moment.  please try back soon!');
if(!defined('ACCOUNT_UNAVAILABLE_MSG'))
  define ('ACCOUNT_UNAVAILABLE_MSG', 
        'There is a problem with your Geopass account.  Please contact the site administrator.');
if(!defined('CLASSIFICATION_ROCK'))
  define ('CLASSIFICATION_ROCK', 1);

// flag
if(!defined('REACTIVATE'))
  define ('REACTIVATE', 1);
if(!defined('DEACTIVATE'))
  define ('DEACTIVATE', 2);

if(!defined('EC2ODM2_HOST'))
{
  if(isset($_SERVER['HTTP_HOST']) && (strlen($_SERVER['HTTP_HOST']) !=0 ))
  {
    define ('EC2ODM2_HOST', $_SERVER['HTTP_HOST']);
  }
}

if(!defined('PATH_TO_UPLOAD_DIR'))
  define ('PATH_TO_UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/../uploads' );

?>
