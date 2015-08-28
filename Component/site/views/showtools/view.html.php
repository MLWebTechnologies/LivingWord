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
jimport( 'joomla.application.component.view');
class LivingWordViewShowTools extends JViewLegacy
{
	function display( $tpl = null)
	{
		global $lwConfig, $livingword, $dictionaries, $commentators, $matchcriteria, $langfile;
    $user = JFactory::getUser();
  	$db	= JFactory::getDBO();
    $sql = $db->setQuery("SELECT * FROM #__livingword WHERE userid='".(int)$user->id."'");
    $mysettings = $db->loadObjectList();
    $mycounts = count($mysettings);
    if($mycounts < 1){
      $bversion = $lwConfig['config_bible_version'];
    } else {
      $bversion = $mysettings[0]->bibleversion;
    }
    $langfile = $livingword->LWgetLang($bversion);
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
    $livingword->LWgetPrefOptions();
		// Set pathway information
		$this->assignRef('dictionaries',	$dictionaries);
		$this->assignRef('commentators',	$commentators);
    $this->assignRef('matchcriteria', $matchcriteria);
    $this->assignRef('langfile', $langfile);
    $this->assignRef('config_use_gb', $lwConfig['config_use_gb']);
		parent::display($tpl);
	}
}
?>