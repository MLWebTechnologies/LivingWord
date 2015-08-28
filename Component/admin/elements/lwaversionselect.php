<?php
/**
 * @version		$Id: lwaversioniselect.php 160 2011-07-16 15:38:03Z ml $
 * @package		LivingWord
 * @subpackage	Form
 * @copyright	Copyright (C) 2008 - 2012 MLWebTechnologies All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldLWAVersionSelect extends JFormField
{
	protected function getInput()
	{
		global $lwConfig, $livingwordadmin, $bible_version, $bible_plan;
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    include_once( JPATH_ADMINISTRATOR.'/components/com_livingword/helpers/admin_lw_includes.php' );
		// Initialize variables.
		$html = array();
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
    $html[] .= '<div class="fltlft"><select class="inputbox" id="config_altaudio_version" name="jform[params][config_altaudio_version]" size="1">';
    $html[] .= '<option value="0">'.JText::_('SELECTAV').'</option>';
    foreach($bible_version as $bv)
    {
      if($bv['audio']){
        $html[] = '<option class="'.$bv['val'].';'.$bv['nt'].';'.$bv['audio'].';'.$bv['aval'].'" value="'.$bv['val'].'"';
        if ($bv['val'] == $lwConfig['config_altaudio_version']) $html[] = ' SELECTED ';
        $html[] = '>'.htmlentities($bv['desc']).'</option>';
      }
    }
    $html[] = '</select></div>';
		return implode("\n", $html);
	}
}