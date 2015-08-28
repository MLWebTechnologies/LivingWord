<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
global $lwConfig, $livingwordadmin;
require( JPATH_ADMINISTRATOR.'/components/com_livingword/helpers/admin_lw_class.php' );
$livingwordadmin = new livingwordadmin();
$JVersion = new JVersion();
$lwParams = JComponentHelper::getParams('com_livingword');
if( (real)$JVersion->RELEASE == 1.5 ) {
  $lwConfig = $lwParams->toArray();
} elseif( (real)$JVersion->RELEASE >= 1.6 ) {
  $lwParamsArray = $lwParams->toArray();
  foreach($lwParamsArray['params'] as $name => $value){
    $lwConfig[(string)$name] = (string)$value;
  }
}
$lang = Jfactory::getLanguage();
$lang->load( 'com_livingword', JPATH_SITE); 
?>