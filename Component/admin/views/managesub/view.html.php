<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewManageSub extends JViewLegacy
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
		JToolbarHelper::title(JText::_('LivingWord - Manage Subscribers'));
		JToolBarHelper::deleteList( "Remove Subscriber(s)?", "livingword.remove_sub", 'Remove' );
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
	protected function getSortFields()
	{
		return array(
			'name' => JText::_('Name'),
			'a.bibleplan' => JText::_('Bible Plan'),
			'a.bibleversion' => JText::_('Bible Version'),
			'a.audioversion' => JText::_('Audio Version'),
			'a.startdate' => JText::_('Alternate Start Date'),
			'a.planview' => JText::_('Plan View'),
			'a.readstate' => JText::_('Send Email'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
?>