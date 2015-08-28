<?php
/**
 * @version		$Id: lwbplanselect.php 170 2011-07-16 15:38:03Z ml $
 * @package		LivingWord
 * @subpackage	Form
 * @copyright	Copyright (C) 2008 - 2014 MLWebTechnologies All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldLWBPlanSelect extends JFormField
{
	protected function getInput()
	{
    global $lwConfig;
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
		// Initialize variables.
		$html = array();
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
    $html[] = '<input type="hidden" id="selplan" name="jform[params][selplan]" value="'.$lwConfig['config_bible_plan'].'" />';
    $html[] = '<div class="fltlft"><select class="inputbox" id="config_bible_plan" name="jform[params][config_bible_plan]" size="1">';
    $html[] = '<option value="0">'.JText::_('SELECTBP').'</option>';
    $html[] = '</select></div>';
    $html[] = "<script type=\"text/javascript\">
    var setversion = document.getElementById('config_bible_version').options[document.getElementById('config_bible_version').selectedIndex].value;
    if(setversion != null){
      setNTAOptions();
      for(i=0;i<document.getElementById('config_bible_plan').options.length;i++){
        if(document.getElementById('config_bible_plan').options[i].value == \"".$lwConfig['config_bible_plan']."\"){ 
          document.getElementById('config_bible_plan').options[i].selected=true;
        }
      }
    }
    </script>";
		return implode("\n", $html);
	}
}