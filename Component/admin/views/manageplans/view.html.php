<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewManagePlans extends JViewLegacy
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
		foreach ($this->items as &$item) {
			$item->order_up = true;
			$item->order_dn = true;
		}
		$this->addToolbar();
  	$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('LivingWord - Manage Plans'));
		JToolBarHelper::addNew( "addplan");
		JToolBarHelper::deleteList( "Remove Plan(s)?", "livingword.remove_plan", 'Remove' );
		JToolbarHelper::publish('livingword.publishplan', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('livingword.unpublishplan', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::custom( "manage_plan", 'screen', 'screen', 'Manage Plan');
		JToolBarHelper::editList( "editplan");
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
	protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.name' => JText::_('Name'),
			'a.description' => JText::_('Description'),
			'a.message' => JText::_('Message'),
			'a.audio' => JText::_('Audio'),
			'a.newtest' => JText::_('Coverage'),
			'a.published' => JText::_('JPUBLISHED'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
?>