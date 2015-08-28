<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewEditBook extends JViewLegacy
{
	public function display( $tpl = null)
	{
    $editor = JFactory::getEditor('none');
  	$edit	= JRequest::getVar('edit',true);
    $files = JRequest::getVar( 'fid', array(0), '', 'array' );
    if($edit){
    $file = $files[0];
    } else {
    $file = "";
    }
    $this->assignRef('edit', $edit);
    $this->assignRef('editor', $editor);
    $this->assignRef('file', $file);
		$this->assignRef('option', $option);
		$this->addToolbar();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
  	JToolBarHelper::title(   JText::_( 'Edit Bible Book' ).': <small><small>[ ' . JText::_( 'Edit' ).' ]</small></small>' , 'article' );
 		JToolBarHelper::save('livingword.savebook', 'Save' );
 		JToolBarHelper::cancel( 'livingword.canceleditbook', 'Close' );
		JHtmlSidebar::setAction('index.php?option=com_livingword');
	}
}
?>