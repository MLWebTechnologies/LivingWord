<?php
/* *************************************************************************************
Title          Livingword Component for Joomla
Author         Mike Leeper
License        This program is free software: you can redistribute it and/or modify
               it under the terms of the GNU General Public License as published by
               the Free Software Foundation, either version 3 of the License, or
               (at your option) any later version.
               This program is distributed in the hope that it will be useful,
               but WITHOUT ANY WARRANTY; without even the implied warranty of
               MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
               GNU General Public License for more details.
               You should have received a copy of the GNU General Public License
               along with this program.  If not, see <http://www.gnu.org/licenses/>.
Copyright      2008-2014 - Mike Leeper (MLWebTechnologies) 
****************************************************************************************
No direct access*/
defined( '_JEXEC' ) or die( 'Restricted access' );
global $lwConfig, $livingword;
$JVersion = new JVersion();
require_once( JPATH_ROOT.'/components/com_livingword/helpers/lw_class.php' );
$livingword = new livingword();
$livingword->intializeLWRights();
if( (real)$JVersion->RELEASE == 1.5 ) {
  $component = &JComponentHelper::getComponent( 'com_livingword' );
  $lwParams = new JParameter($component->params);
  $lwConfig = $lwParams->toArray();
} elseif( (real)$JVersion->RELEASE >= 1.6 ) {
  $lwParams = JComponentHelper::getParams('com_livingword');
  $lwParamsArray = $lwParams->toArray();
  foreach($lwParamsArray['params'] as $name => $value){
    $lwConfig[(string)$name] = (string)$value;
  }
}
$document = JFactory::getDocument();
$document->addScript('components/com_livingword/assets/js/lw.js');
$document->addStyleSheet(JURI::base().'components/com_livingword/assets/css/livingword.css');
$lang = Jfactory::getLanguage();
$lang->load( 'com_livingword' ); 
?>