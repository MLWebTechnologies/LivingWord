<?php
/**
 * @version		$Id: lwbversioniselect.php 160 2011-07-16 15:38:03Z ml $
 * @package		LivingWord
 * @subpackage	Form
 * @copyright	Copyright (C) 2008 - 2014 MLWebTechnologies All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldLWPVersionSelect extends JFormField
{
	protected function getInput()
	{
		global $lwConfig, $livingwordadmin, $bible_version, $bible_plan;
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    include_once( JPATH_ADMINISTRATOR.'/components/com_livingword/helpers/admin_lw_includes.php' );
    $livingwordadmin->LWgetPrefOptions($lwConfig['config_parallel_bible_version']);
		// Initialize variables.
		$html = array();
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		// Initialize JavaScript field attributes.
    $html[] .= '<div class="fltlft"><select class="inputbox" id="config_parallel_bible_version" name="jform[params][config_parallel_bible_version]" size="1">';
    $html[] .= '<option value="0">'.JText::_('SELECTBV').'</option>';
    foreach($bible_version as $bv)
    {
      $html[] = '<option class="'.$bv['val'].';'.$bv['nt'].';'.$bv['audio'].';'.$bv['aval'].'" value="'.$bv['val'].'"';
      if ($bv['val'] == $lwConfig['config_parallel_bible_version']) $html[] = ' SELECTED ';
      $html[] = '>'.htmlentities($bv['desc']).'</option>';
    }
    $html[] = '</select></div>';
		return implode("\n", $html);
	}
}