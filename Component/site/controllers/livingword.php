<?php
/* *************************************************************************************
Title          LivingWord Component for Joomla
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
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class LivingWordControllerLivingWord extends LivingWordController
{
  function savesettings()
  {
    global $db, $livingword;
 		JRequest::checkToken() or jexit( 'Invalid Token' );
    jimport('joomla.date.date');
    $user = JFactory::getUser();
  	$db	= JFactory::getDBO();
    $app = JFactory::getApplication();
    $itemid = $livingword->LWgetItemid();
    $chgdate = 0;
    $selectplan = JRequest::getVar('selectplan',null,'post','string');
    $selectversion = JRequest::getVar('selectversion',null,'post','string');
    $selectpbversion = JRequest::getVar('selectpbversion',null,'post','string');
    $selectaudio = JRequest::getVar('audioversion',null,'post','string');
    $selectemail = JRequest::getVar('selectemail',null,'post','int');
    $selectaltplanview = JRequest::getVar('selectaltplanview',null,'post','string');
    $selectaltdate = JRequest::getVar('selectaltdate',null,'post','string');
    $selectoffset = JRequest::getVar('selectoffset',null,'post','string');
    if(!$selectaltdate) $selectaltdate = '0000-00-00';
    $chk = $db->setQuery("SELECT COUNT(*) FROM #__livingword WHERE userid='".(int)$user->id."'");
    $chkcount = $db->loadResult();
    if($chkcount > 0)
    { 
      $sql = $db->setQuery("UPDATE #__livingword SET bibleplan=".$db->quote($selectplan).", bibleversion=".$db->quote($selectversion).", pbversion=".$db->quote($selectpbversion).", audioversion=".$db->quote($selectaudio).", email=".$db->quote((int)$selectemail).", planview=".$db->quote((int)$selectaltplanview).", dateoffset=".$db->quote($selectoffset).", startdate=".$db->quote($selectaltdate)." WHERE userid='".(int)$user->id."'");
    } else {
      $sql = $db->setQuery("INSERT INTO #__livingword (id,userid,bibleplan,bibleversion,pbversion,audioversion,email,planview,readstate,startdate,dateoffset) VALUES ('','".(int)$user->id."',".$db->quote($selectplan).",".$db->quote($selectversion).",".$db->quote($selectpbversion).",".$db->quote($selectaudio).",".$db->quote((int)$selectemail).",".$db->quote((int)$selectaltplanview).",'0',".$db->quote($selectaltdate).",".$db->quote($selectoffset).")");
    }
    $db->query();
  	$returnurl = JRoute::_('index.php?option=com_livingword&task=settings&Itemid='.$itemid);
    $app->redirect($returnurl, JText::_('LWSETTINGSSAVED'));
  }
}
?>