<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewLivingWord extends JViewLegacy
{
	function display( $tpl = null)
	{
    $version = new JVersion();
		$this->assignRef('JVersion', $version);
		$this->addToolbar();
  	$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('LivingWord - Control Panel'));
		JToolbarHelper::preferences('com_livingword');
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
}
?>