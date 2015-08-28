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
class JFormFieldLWBVersionSelect extends JFormField
{
	protected function getInput()
	{
		global $lwConfig, $livingwordadmin, $bible_version, $bible_plan;
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    include_once( JPATH_ADMINISTRATOR.'/components/com_livingword/helpers/admin_lw_includes.php' );
    $bversionnt = $livingwordadmin->LWgetNT($lwConfig['config_bible_version']);
    $bversionav = $livingwordadmin->LWgetAudio($lwConfig['config_bible_version']);
    $livingwordadmin->LWgetPrefOptions($lwConfig['config_bible_version']);
		// Initialize variables.
		$html = array();
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		// Initialize JavaScript field attributes.
		$onchange = (string) $this->element['onchange'];
		// Build the script.
		$script = array();
		$script[] = '  var selectav = \''.JText::_('SELECTAV').'\'';
		$script[] = '  var selectbp = \''.JText::_('SELECTBP').'\'';
		$script[] = '  var selectbv = \''.JText::_('SELECTBV').'\'';
		$script[] = '  var bpcount = '.count($bible_plan).';';
    $script[] = '  var optionTmp = new Array(bpcount);';
    $script[] = '  optionTmp[0] = new Array(4);'; 
    $script[] = "  optionTmp[0][0] = '".JText::_('SELECTBP')."';";
    $script[] = '  optionTmp[0][1] = 0;';
    $script[] = '  optionTmp[0][2] = 0;';
    $script[] = '  optionTmp[0][3] = 0;';
    for($i=0,$j=0;$j<count($bible_plan);$i++,$j++){
      $script[] = '     optionTmp['.$j.'] = new Array(4);'; 
      $script[] = "     optionTmp[".$j."][0] = '".JText::_($bible_plan[$i]->description)."';";
      $script[] = "     optionTmp[".$j."][1] = '".$bible_plan[$i]->name."';";
      $script[] = "     optionTmp[".$j."][2] = '".$bible_plan[$i]->audio."';";
      $script[] = "     optionTmp[".$j."][3] = '".$bible_plan[$i]->newtest."';";
    }
    $script[] = '  function setNTAOptions(){';
		$script[] = '  var bpcount = '.count($bible_plan).';';
    $script[] = '  var bv = document.getElementById(\'config_bible_version\');';
    $script[] = '  var selPlan = document.getElementById(\'config_bible_plan\');';
    $script[] = '  var selIndex = bv.selectedIndex;';
    $script[] = '  if(selPlan.value == 0){';
    $script[] = '  document.adminForm.selplan.value = selPlan.selectedIndex;';
    $script[] = '  }';
    $script[] = '  var title = bv.options[selIndex].className;';
    $script[] = '  titlearray = title.split(/;/);';
    $script[] = '  var nt = titlearray[1];';
    $script[] = '  var audio = titlearray[2];';
    $script[] = '  var avt = titlearray[3];';
    $script[] = '  var a = optionTmp;';
    $script[] = '  if(audio == 0){';
    $script[] = '    if( nt == 2 ){';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){ ';
    $script[] = '       if(a[i][3] == 2){';
    $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '        }'; 
    $script[] = '      }'; 
    $script[] = '    }';
    $script[] = '    else if( nt == 1 ){';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){ ';
    $script[] = '        if(a[i][3] == 1){';
    $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '        }'; 
    $script[] = '      }'; 
    $script[] = '    }';
    $script[] = '    else {';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){';
    $script[] = '        selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '      }';
    $script[] = '    }';
    $script[] = '  }';
    $script[] = '  else {';
    $script[] = '    if( nt == 2 ){';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){ ';
    $script[] = '        if(a[i][2] == 1 && a[i][3] == 2){';
    $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '        }'; 
    $script[] = '      }'; 
    $script[] = '    }';
    $script[] = '    else if( nt == 1 ){';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){ ';
    $script[] = '        if(a[i][2] == 1 && a[i][3] == 1){';
    $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '        }'; 
    $script[] = '      }'; 
    $script[] = '    }';
    $script[] = '    else {';
    $script[] = '      selPlan.options.length = 0;';
    $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
    $script[] = '      for(i=0;i<bpcount;i++){';
    $script[] = '        if(a[i][2] == 1){';
    $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
    $script[] = '        }';
    $script[] = '      }';
    $script[] = '    }';
    $script[] = '  }';
    $script[] = '  document.adminForm.config_bible_version.options[selIndex].value = titlearray[0];';
    $script[] = '  return true;';
    $script[] = '  }';
    $script[] = ' function validateBP(){';
    $script[] = '  if(document.getElementById(\'config_bible_plan\').value == 0) {';
    $script[] = '    alert(\''.JText::_('SELECTBP').'\');';
    $script[] = '    document.getElementById(\'config_bible_plan\').focus();';
    $script[] = '    document.getElementById(\'config_bible_plan\').style.border = \'1px solid #ff0000\'';
    $script[] = '    document.getElementById(\'jform_params_config_bible_plan-lbl\').style.color = \'#ff0000\'';
    $script[] = '   }';
    $script[] = ' }';
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
    $html[] .= '<div class="fltlft"><select class="inputbox" id="config_bible_version" name="jform[params][config_bible_version]" size="1" onChange="javascript:setNTAOptions();validateBP();">';
    $html[] .= '<option value="0">'.JText::_('SELECTBV').'</option>';
    foreach($bible_version as $bv)
    {
      $html[] = '<option class="'.$bv['val'].';'.$bv['nt'].';'.$bv['audio'].';'.$bv['aval'].'" value="'.$bv['val'].'"';
      if ($bv['val'] == $lwConfig['config_bible_version']) $html[] = ' SELECTED ';
      $html[] = '>'.htmlentities($bv['desc']).'</option>';
    }
    $html[] = '</select></div>';
    ?>
    <script type="text/javascript">
    var setversion = document.getElementById('config_bible_version').options[document.getElementById('config_bible_version').selectedIndex].value;
    if(setversion != null){
      setNTAOptions();
      for(i=0;i<document.getElementById('config_bible_plan').options.length;i++){
        if(document.getElementById('config_bible_plan').options[i].value == '<?php echo $lwConfig['config_bible_plan'];?>'){ 
          document.getElementById('config_bible_plan').options[i].selected=true;
        }
      }
    }
    </script>
    <?php
		return implode("\n", $html);
	}
}