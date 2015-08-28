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
Copyright      2008-2014 Mike Leeper (MLWebTechnologies) 
****************************************************************************************
No direct access*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class LivingWordViewShowSettings extends JViewLegacy
{
	function display( $tpl = null)
	{
		global $lwConfig, $livingword, $langfile, $bible_plan, $bible_version;
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    $user = JFactory::getUser();
    $db	= JFactory::getDBO();
    $sql = $db->setQuery("SELECT * FROM #__livingword WHERE userid='".(int)$user->id."'");
    $mysettings = $db->loadObjectList();
    $livingword->LWgetPrefOptions();
		// Set pathway information
		$title = JText::_('LWPSET');
    $setmsg = nl2br(JText::_('SETMSG'));
    $this->assignRef('title', $title);
		$this->assignRef('setmsg',	$setmsg);
    $this->assignRef('config_enable_email', $lwConfig['config_enable_email']);
    $this->assignRef('bible_plan', $bible_plan);
    $this->assignRef('bible_version', $bible_version);
    $this->assignRef('mysettings', $mysettings);
    $this->assignRef('user', $user);
		parent::display($tpl);
	}
}