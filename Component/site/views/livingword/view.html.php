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
defined( '_JEXEC' ) or die( 'Restricted access' );
//jimport( 'joomla.application.component.view');
class LivingWordViewLivingWord extends JViewLegacy
{
	function display( $tpl = null)
	{
		global $lwConfig, $langfile, $livingword;
    $user = JFactory::getUser();
  	$db	= JFactory::getDBO();
    $sql = $db->setQuery("SELECT * FROM #__livingword WHERE userid='".(int)$user->id."'");
    $mysettings = $db->loadObjectList();
    $mycounts = count($mysettings);
    if(!$mycounts){
      $bplan = $lwConfig['config_bible_plan'];
      $bversion = $lwConfig['config_bible_version'];
    } else {
      $bplan = $mysettings[0]->bibleplan;
      $bversion = $mysettings[0]->bibleversion;
    }
    $langfile = $livingword->LWgetLang($bversion);
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
		// Set pathway information
		$title = JText::_('LWHOME');
    $intro = nl2br(JText::_('INTROMSG'));
    $this->assignRef('title', $title);
		$this->assignRef('intro',	$intro);
    $this->assignRef('langfile', $langfile);
    $this->assignRef('bversion', $bversion);
    $this->assignRef('bplan', $bplan);
		parent::display($tpl);
	}
}