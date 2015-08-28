<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewManageLang extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	public function display( $tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->state		= $this->get('State');
  	$this->pagination	= $this->get('Pagination');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		// Preprocess the list of items to find ordering divisions.
		// TODO: Complete the ordering stuff with nested sets
//		foreach ($this->items as &$item) {
//			$item->order_up = true;
//			$item->order_dn = true;
//		}
		$this->addToolbar();
  	$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
    JToolBarHelper::title( 'Manage Languages' );
		JToolBarHelper::addNew( "addlang");
		$cb = JToolBar::getInstance('toolbar');
		$cb->appendButton( 'confirm', 'Do you wish to reset the English LivingWord language file to default settings?', 'undo', 'Reset', 'resetlang', false);
		JToolBarHelper::divider();
		JToolBarHelper::editList( "editlang");
		JToolBarHelper::deleteList( "Remove Language File(s)?", "deleteLangfile", 'Remove' );
		JToolBarHelper::divider();
    JToolBarHelper::help( 'language.help.html', true);
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
}?>