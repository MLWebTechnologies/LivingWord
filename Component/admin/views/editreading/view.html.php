<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewEditReading extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;
	public function display( $tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
    $this->edit   = $this->get('edit');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
  	$lists = array();
  	$name	= JRequest::getVar('name',true);
  	$edit	= JRequest::getVar('edit',true);
  	$plan	= JRequest::getVar('plan',true);
  	if(!isset($plan)) $plan = "";
    $bookarray = array();
    $bookarray[] = JHTML::_( 'select.option', '' , JText::_('Select Book') );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK01' , ucwords(JText::_('LWBIBLEBOOK01')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK02' , ucwords(JText::_('LWBIBLEBOOK02')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK03' , ucwords(JText::_('LWBIBLEBOOK03')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK04' , ucwords(JText::_('LWBIBLEBOOK04')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK05' , ucwords(JText::_('LWBIBLEBOOK05')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK06' , ucwords(JText::_('LWBIBLEBOOK06')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK07' , ucwords(JText::_('LWBIBLEBOOK07')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK08' , ucwords(JText::_('LWBIBLEBOOK08')) );
    $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK09' , ucwords(JText::_('LWBIBLEBOOK09')) );
    for($i=10;$i<74;$i++){
      $bookarray[] = JHTML::_( 'select.option', 'LWBIBLEBOOK'.$i , ucwords(JText::_('LWBIBLEBOOK'.$i)) );
    }
//  	$lists['ordering'] 			= JHTML::_('list.specificordering',  $row, $row->id, $oquery );
		$this->assignRef('item', $this->item);
		$this->assignRef('edit', $edit);
		$this->assignRef('lists',		$lists);
		$this->assignRef('option', $option);
		$this->assignRef('plan', $plan);
		$this->assignRef('bookarray', $bookarray);
		$this->addToolbar();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
    global $livingwordadmin;
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo		= $livingwordadmin->getActions($this->item->id, 0);
		JToolbarHelper::title(JText::_('Edit Plan'), 'article.png');
		JToolbarHelper::apply('livingword.apply');
		JToolbarHelper::save('livingword.savereading');
  	if (!$this->edit)  {
  		JToolBarHelper::cancel('livingword.canceleditreading');
  	} else {
  		JToolBarHelper::cancel( 'livingword.canceleditreading', 'Close' );
  	}
	}
}
?>