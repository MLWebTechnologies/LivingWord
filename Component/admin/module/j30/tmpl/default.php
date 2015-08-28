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
defined( '_JEXEC' ) or die( 'Restricted access' );// no direct access
if(file_exists(JPATH_ROOT."/administrator/components/com_livingword/config.xml")){
  $lang = JFactory::getLanguage();
  $lang->load( 'com_livingword', JPATH_SITE); 
  include_once( JPATH_ROOT."/components/com_livingword/helpers/lw_class.php" );
  include_once( JPATH_ROOT."/components/com_livingword/helpers/lw_includes.php" );
  $livingwordmod = new livingword();
  $itemid = $livingwordmod->LWgetItemid();
  $modDataArray = $livingwordmod->LWGetUserData();
  $langfile = $livingwordmod->LWgetLang($modDataArray['bversion']);
  $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
  $curdate = $livingwordmod->readingCurDate($modDataArray['bplan'])-1;
  if($config_show_image) echo '<div><img src="components/com_livingword/assets/images/bible.jpg" style="width:60px;height:95px;float:right;border:1px solid #000;margin-left:2px;" /></div>';
  $readingarray = $livingwordmod->LWGetReadingLink();
  if($curdate >= 0) {
    echo '<div class="mainlevel'.$moduleclass_sfx.'"><br />'.JText::_('LWTODAYSREADING').':<br /><ul style="list-style-type:none;margin-top:3px;margin-bottom:5px;margin-left:5px;padding-left:0px;"><li>';
    echo $readingarray['rlink'];
    echo '</li></ul>';
  } else {
    echo '<div class="mainlevel'.$moduleclass_sfx.'">'.wordwrap(JText::_('LWPLANNOTBEGIN'),26,"<br />").'<br /><br />';
  }
  echo '<br /><a href="'.JRoute::_("index.php?option=com_livingword&task=view_plan&plan=".$modDataArray['bplan']."&bibleversion=".$modDataArray['bversion']."&Itemid=".$itemid."").'" target="_self">'.JText::_('LWVIEWFULLPLAN').'</a><br /><br />';
  if($config_show_links){
    echo '<small><a href="'.JRoute::_("index.php?option=com_livingword&task=tools&Itemid=".$itemid."").'" target="_self">'.JText::_('LWTOOLS').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
    echo '<a href="'.JRoute::_("index.php?option=com_livingword&task=resources&Itemid=".$itemid."").'" target="_self">'.JText::_('LWRESOURCES').'</a></small><br />';
  }
  echo '</div>';
} else { 
    if(!defined('LWCOMNOTINSTALL')) define('LWCOMNOTINSTALL','LivingWord Component Not Installed');
    echo '<div><center><font color="red"><b>'.JText::_('LWCOMNOTINSTALL').'</b></font></center></div>';
}
?>