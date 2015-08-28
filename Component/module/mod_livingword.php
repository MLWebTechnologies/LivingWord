<?php
/****************************************************************************************
 Title          Mod_livingword Daily Bible Reading Module for Joomla
 Author         Mike Leeper
 URL            http://www.mlwebtechnologies.com
 Email          web@mlwebtechnologies.com
 License        This is free software and you may redistribute it under the GPL.
                Mod_livingword comes with absolutely no warranty. For details, 
                see the license at http://www.gnu.org/licenses/gpl.txt
                YOU ARE NOT REQUIRED TO KEEP COPYRIGHT NOTICES IN
                THE HTML OUTPUT OF THIS SCRIPT. YOU ARE NOT ALLOWED
                TO REMOVE COPYRIGHT NOTICES FROM THE SOURCE CODE.
                Requires the Livingword component v3.x or higher
                Bookmarks by AddThis
*****************************************************************************************/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).'/helper.php' );
$moduleclass_sfx = 'mainlevel'.$params->get('moduleclass_sfx');
$config_show_image = $params->get('config_show_image');
$config_show_links = $params->get('config_show_links');
require( JModuleHelper::getLayoutPath( 'mod_livingword' ) );
?>