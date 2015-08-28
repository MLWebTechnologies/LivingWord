<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewManagePlan extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	public function display( $tpl = null)
	{
    global $livingwordadmin,$lwConfig;
    $langfile = $livingwordadmin->LWgetLang($lwConfig['config_bible_version']);
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
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
    $cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
    $id = $cid[0];
    if(!$id) $id	= JRequest::getVar( 'planid', null, '', 'int' );
		$this->assignRef('id', $id);
		$this->addToolbar();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('LivingWord - Manage Plan'));
		JToolBarHelper::addNew( "addreading");
		JToolBarHelper::deleteList( "Remove Plan(s)?", "livingword.remove_plan", 'Remove' );
		JToolBarHelper::editList( "editreading");
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
	protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.plan' => JText::_('Plan'),
			'a.descrip' => JText::_('Description'),
			'a.reading' => JText::_('Reading'),
			'a.audio' => JText::_('Audio'),
			'a.figure' => JText::_('Figure'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
?>