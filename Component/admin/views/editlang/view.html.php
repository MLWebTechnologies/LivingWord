<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class LivingWordViewEditLang extends JViewLegacy
{
	function display( $tpl = null)
	{
  $editor = JFactory::getEditor('none');
	$edit		= JRequest::getVar('edit',true);
  $files 		= JRequest::getVar( 'fid', array(0), '', 'array' );
  if($edit){
  $file = str_replace('DS','/',$files[0]);
  } else {
  $file = "";
  }
    $this->assignRef('edit', $edit);
    $this->assignRef('editor', $editor);
    $this->assignRef('file', $file);
		$this->assignRef('option', $option);
		parent::display($tpl);
	}
}
?>