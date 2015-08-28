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
class LivingWordViewShowResources extends JViewLegacy
{
	function display( $tpl = null)
	{
		global $lwConfig, $livingword;
  	$db	= JFactory::getDBO();
		// Set pathway information
    $this->assignRef('langfile', $langfile);
    $this->assignRef('rightsarray', $rightsarray);
    $this->assignRef('config_default_bv', $lwConfig['config_bible_version']);
    $query = "SELECT a.name,a.url,a.catid,a.target,c.title as category,c.lft FROM #__livingword_links AS a LEFT JOIN #__categories AS c ON (c.id = a.catid) WHERE a.published='1' AND c.title='Bible Study' ORDER BY c.lft,a.ordering";
    $db->setQuery($query);
    $alinksArray = $db->loadObjectList();
    $query = "SELECT a.name,a.url,a.catid,a.target,c.title as category,c.lft FROM #__livingword_links AS a LEFT JOIN #__categories AS c ON (c.id = a.catid) WHERE a.published='1' AND c.title='For Teens' ORDER BY c.lft,a.ordering";
    $db->setQuery($query);
    $tlinksArray = $db->loadObjectList();
    $query = "SELECT a.name,a.url,a.catid,a.target,c.title as category,c.lft FROM #__livingword_links AS a LEFT JOIN #__categories AS c ON (c.id = a.catid) WHERE a.published='1' AND c.title='Just For Kids' ORDER BY c.lft,a.ordering";
    $db->setQuery($query);
    $klinksArray = $db->loadObjectList();
    $ebibleArray = $livingword->getEBibles();
		$this->assignRef('alinksArray', $alinksArray);
		$this->assignRef('tlinksArray', $tlinksArray);
		$this->assignRef('klinksArray',	$klinksArray);
		$this->assignRef('ebibleArray',	$ebibleArray);
    $this->assignRef('config_use_gb', $lwConfig['config_use_gb']);
		parent::display($tpl);
	}
}
?>