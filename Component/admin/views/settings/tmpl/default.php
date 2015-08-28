<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
	global $mainframe, $lwConfig, $livingwordadmin, $bible_version, $bible_plan;
  $bversionnt = $livingwordadmin->LWgetNT($lwConfig['config_bible_version']);
  $bversionav = $livingwordadmin->LWgetAudio($lwConfig['config_bible_version']);
  $livingwordadmin->LWgetPrefOptions($lwConfig['config_bible_version']);
  JHTML::_('behavior.calendar');
//  echo '<script language="JavaScript" type="text/javascript" src="components/com_livingword/assets/js/lwa.js"></script>';
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
  for($i=0,$j=1;$i<count($bible_plan);$i++,$j++){
    $script[] = '     optionTmp['.$j.'] = new Array(4);'; 
    $script[] = "     optionTmp[".$j."][0] = '".JText::_($bible_plan[$i]->description)."';";
    $script[] = "     optionTmp[".$j."][1] = '".$bible_plan[$i]->name."';";
    $script[] = "     optionTmp[".$j."][2] = '".$bible_plan[$i]->audio."';";
    $script[] = "     optionTmp[".$j."][3] = '".$bible_plan[$i]->newtest."';";
  }
  $script[] = '  function setNTAOptions(){';
	$script[] = '  var bpcount = '.count($bible_plan).'+1;';
  $script[] = '  var bv = document.getElementById(\'config_bible_version\');';
  $script[] = '  var selPlan = document.getElementById(\'config_bible_plan\');';
  $script[] = '  var selIndex = bv.selectedIndex;';
  $script[] = '  if(selPlan.value == 0){';
  $script[] = '  document.adminForm.config_bible_plan.value = selPlan.selectedIndex;';
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
  $script[] = '      for(i=1;i<bpcount;i++){ ';
  $script[] = '        if(a[i][3] == 2){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }'; 
  $script[] = '      }'; 
  $script[] = '    }';
  $script[] = '    else if( nt == 1 ){';
  $script[] = '      selPlan.options.length = 0;';
  $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
  $script[] = '      for(i=1;i<bpcount;i++){ ';
  $script[] = '        if(a[i][3] == 1){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }'; 
  $script[] = '      }'; 
  $script[] = '    }';
  $script[] = '    else {';
  $script[] = '      selPlan.options.length = 0;';
  $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
  $script[] = '      for(i=1;i<bpcount;i++){';
  $script[] = '        if(a[i][3] == 0){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }';
  $script[] = '      }';
  $script[] = '    }';
  $script[] = '  }';
  $script[] = '  else {';
  $script[] = '    if( nt == 2 ){';
  $script[] = '      selPlan.options.length = 0;';
  $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
  $script[] = '      for(i=1;i<bpcount;i++){ ';
  $script[] = '        if(a[i][2] == 1 && a[i][3] == 2){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }'; 
  $script[] = '      }'; 
  $script[] = '    }';
  $script[] = '    else if( nt == 1 ){';
  $script[] = '      selPlan.options.length = 0;';
  $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
  $script[] = '      for(i=1;i<bpcount;i++){ ';
  $script[] = '        if(a[i][2] == 1 && a[i][3] == 1){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }'; 
  $script[] = '      }'; 
  $script[] = '    }';
  $script[] = '    else {';
  $script[] = '      selPlan.options.length = 0;';
  $script[] = '      selPlan.options[selPlan.options.length] = new Option(selectbp,0);';
  $script[] = '      for(i=1;i<bpcount;i++){';
  $script[] = '        if(a[i][2] == 1 && a[i][3] == 0){';
  $script[] = '          selPlan.options[selPlan.options.length] = new Option(a[i][0],a[i][1]);';
  $script[] = '        }';
  $script[] = '      }';
  $script[] = '    }';
  $script[] = '  }';
  $script[] = '  document.adminForm.config_bible_version.options[selIndex].value = titlearray[0];';
  $script[] = '  return true;';
  $script[] = '  }';
	// Add the script to the document head.
	JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
  $userarray = array();
  $userarray[] = JHTML::_( 'select.option', 0 , 'Public' );
  $userarray[] = JHTML::_( 'select.option', 18 , 'Registered Users' );
  $userarray[] = JHTML::_( 'select.option', 24 , 'Administrator' );
  $userarray[] = JHTML::_( 'select.option', 99 , 'Disable Menu Link' );
  $templatearray = array();
  $templatearray[] = JHTML::_( 'select.option', 'default' , 'List' );
  $templatearray[] = JHTML::_( 'select.option', 'calendar' , 'Calendar' );
  $shorturlarray = array();
  $shorturlarray[] = JHTML::_( 'select.option', '0' , 'tinyurl.com' );
  $shorturlarray[] = JHTML::_( 'select.option', '1' , 'is.gd' );
  $shorturlarray[] = JHTML::_( 'select.option', '2' , 'u.nu' );
  jimport('joomla.html.pane');
  JHTML::_('behavior.tooltip');
  ?><script language="javascript" type="text/javascript">
    var selectav = "<?php echo JText::_('SELECTAV'); ?>";
    var selectbp = "<?php echo JText::_('SELECTBP'); ?>";
    var selectbv = "<?php echo JText::_('SELECTBV'); ?>";
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
        submitform( pressbutton );
        return;
        }
		// do field validation
      var bv = document.getElementById('config_bible_version');
      var bp = document.getElementById('config_bible_plan');
      if( bv.selectedIndex == 0 )
      {
      alert(selectbv);
      return false;
      } else if( bp.selectedIndex == 0 )
      {
      alert(selectbp);
      return false;
  		} else {
			submitform( pressbutton );
      return true;
      }
    }
    </script>
 		<form action="index.php?option=com_livingword" method="post" name="adminForm">
		<fieldset>
			<div style="float: right">
				<button type="button" onclick="if(submitbutton('save')){window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700)};">
					<?php echo JText::_( 'Save' );?></button>
				<button type="button" onclick="window.parent.document.getElementById('sbox-window').close();">
					<?php echo JText::_( 'Cancel' );?></button>&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
      <div class="configuration" >
				<?php echo JText::_('LivingWord Parameters') ?>
			</div>
		</fieldset>
    <div>
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Configuration' ); ?></legend>
		<table class="admintable">
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Select Global Start Date::Select Global Start Date.  Defaults to current date.">Select Global Start Date:</td>
      <?php if(empty($this->config_global_startdate)){$config_global_startdate = date("Y-m-d");}else{$config_global_startdate = $this->config_global_startdate;}?>
			<td><?php echo JHTML::_('calendar', $config_global_startdate, 'params[config_global_startdate]', '', '%Y-%m-%d', array('class' => 'inputbox')); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Select Default Bible Version::Choose a bible version">Select Default Bible Version:</td>
      <?php
        $bvlist = '<td><select class="inputbox" id="config_bible_version" name="params[config_bible_version]" size="1" onChange="javascript:setNTAOptions();">';
        $bvlist .= '<option value="0">'.JText::_('SELECTBV').'</option>';
        foreach($this->bible_version as $bv)
        {
          $bvlist .= '<option class="'.$bv['val'].';'.$bv['nt'].';'.$bv['audio'].';'.$bv['aval'].'" value="'.$bv['val'].'"';
          if ($bv['val'] == $this->config_bible_version) $bvlist .= ' SELECTED ';
          $bvlist .= '>'.htmlentities($bv['desc']).'</option>';
        }
        echo '</select>';
        echo $bvlist.'</td>';
      ?>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Select Default Bible Plan::Choose a bible reading plan">Select Default Bible Plan:</td>
      <?php
        $bplist = '<input type="hidden" id="selplan" name="selplan" value="'.$lwConfig['config_bible_plan'].'" />';
        $bplist .= '<td><select class="inputbox" id="config_bible_plan" name="params[config_bible_plan]" size="1">';
        $bplist .= '<option value="0">'.JText::_('SELECTBP').'</option>';
        $bplist .= '</select>';
        $bplist .= "<script type=\"text/javascript\">
        var setversion = document.getElementById('config_bible_version').options[document.getElementById('config_bible_version').selectedIndex].value;
        if(setversion > 0){
          setNTAOptions();
          for(i=0;i<document.getElementById('config_bible_plan').options.length;i++){
            if(document.getElementById('config_bible_plan').options[i].value == \"".$lwConfig['config_bible_plan']."\"){ 
              document.getElementById('config_bible_plan').options[i].selected=true;
            }
          }
        }
        </script>";
        echo $bplist.'</td>';
      ?>			
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show Audio Icon::When selecting a Bible version supports both audio and text, select Yes to show an audio icon with text link or No to show only a link to the audio on all displayed pages.">Show Audio Icon:</td>
      <td><?php echo JHTML::_('select.booleanlist', "params[config_show_audio]", '1', $this->config_show_audio); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Select Alternate Audio Bible Version::If you choose a default bible version that has no audio version available, you can select a alternate version to use.">Select Alternate Audio Bible Version:</td>
      <?php
        $avlist = '<td><select class="inputbox" id="config_altaudio_version" name="params[config_altaudio_version]" size="1">';
        $avlist .= '<option value="0">'.JText::_('SELECTAV').'</option>';
        foreach($this->bible_version as $av)
        {
          if($av['audio'] == 1){
            $avlist .= '<option class="'.$av['val'].';'.$av['nt'].';'.$av['audio'].';'.$av['aval'].'" value="'.$av['val'].'"';
            if ($av['val'] == $this->config_altaudio_version) $avlist .= ' SELECTED ';
            $avlist .= '>'.htmlentities($av['desc']).'</option>';
          }
        }
        echo '</select>';
        echo $avlist.'</td>';
      ?>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Plan Template::Template to use when displaying full plan view.">Plan Template:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $templatearray, "params[config_plan_template]", 'size="1" class="inputbox"', 'value', 'text', $this->config_plan_template ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Enable Email::Enable email of daily readings. Requires the LivingWord plugin to be installed / enabled">Enable Email:</td>
      <td><?php echo JHTML::_('select.booleanlist', "params[config_enable_email]", '1', $this->config_enable_email); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show Print Icon::Show print icon on View Full Plan page">Show Print Icon:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_print]", '1', $this->config_show_print); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show iCalendar Icon::Show iCalendar icon on View Full Plan page">Show iCalendar Icon:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_ical]", '1', $this->config_show_ical); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show Bookmarks Icon::Show social bookmarks icon on View Full Plan page">Show Bookmarks Icon:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_bookmarks]", '1', $this->config_show_bookmarks); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show Developer Credit::Show developer credit at bottom of component frontend">Show Developer Credit:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_credit]", '1', $this->config_show_credit); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show RSS Icon::Show RSS icon at bottom of component frontend">Show RSS Icon:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_rss]", '1', $this->config_show_rss); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Use Squeezebox Popup Effect::Select to use Squeezebox popup effect or standard browser">Use Squeezebox Popup Effect:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_use_gb]", '1', $this->config_use_gb); ?></td>
		</tr>
  	</table>
			</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Menu Settings' ); ?></legend>
		<table class="admintable">
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Show LivingWord menu::">Show Menu:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_show_menu]", '1', $this->config_show_menu); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Users Allowed to View LivingWord Home Menu Link::Users that are allowed to view the LivingWord home menu link.  Set to Disable Menu Link to disable the link for all users">Users Allowed to View Home Menu Link:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $userarray, "params[config_user_view_lwhome]", 'size="1" class="inputbox"', 'value', 'text', $this->config_user_view_lwhome ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Users Allowed to View User Preferences::Users that are allowed to view the users preferences menu link.  Set to Disable Menu Link to disable the link for all users">Users Allowed to View User Preferences:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $userarray, "params[config_user_view_userpref]", 'size="1" class="inputbox"', 'value', 'text', $this->config_user_view_userpref ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Users Allowed to View Study Tools::Users that are allowed to view the study tools menu link.  Set to Disable Menu Link to disable the link for all users">Users Allowed to View Study Tools:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $userarray, "params[config_user_view_stools]", 'size="1" class="inputbox"', 'value', 'text', $this->config_user_view_stools ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Users Allowed to View Bible Resources::Users that are allowed to view the bible resources menu link.  Set to Disable Menu Link to disable the link for all users">Users Allowed to View Bible Resources:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $userarray, "params[config_user_view_bresource]", 'size="1" class="inputbox"', 'value', 'text', $this->config_user_view_bresource ); ?></td>
		</tr>
   	<tr>
			<td class="key"><span class="editlinktip hasTip" title="Use Alternate Menu Module Class Suffix::By default LivingWord uses your templates MAINLEVEL CSS menu module class.<br /> To define an alternative class the LivingWord CSS contains a MAINLEVELALT definition to use">Use Alternate Menu Module Class:</td>
			<td><?php echo JHTML::_('select.booleanlist', "params[config_moduleclass_sfx]", '0', $this->config_moduleclass_sfx); ?></td>
		</tr>
  	</table>
			</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( '3rd Party Integration' ); ?></legend>
		<table class="admintable">
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Enable Twitter::Enable updating of Twitter status of daily readings. Requires the LivingWord plugin to be installed / enabled">Enable Twitter:</td>
      <td><?php echo JHTML::_('select.booleanlist', "params[config_enable_twitter]", '1', $this->config_enable_twitter); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Twitter App Consumer Key::Twitter App Consumer Key">Twitter App Consumer Key:</td>
			<td><input type="text" name="params[config_twitter_ck]" value="<?php echo $this->config_twitter_ck; ?>" size="20" /></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Twitter App Consumer Secret::Twitter App Consumer Secret">Twitter App Consumer Secret:</td>
			<td><input type="text" name="params[config_twitter_cs]" value="<?php echo $this->config_twitter_cs; ?>" size="20" /></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Twitter App Auth Token::Twitter App Auth Token">Twitter App Auth Token:</td>
			<td><input type="text" name="params[config_twitter_at]" value="<?php echo $this->config_twitter_at; ?>" size="20" /></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Twitter App Auth Secret::Twitter App Auth Secret">Twitter App Auth Secret:</td>
			<td><input type="text" name="params[config_twitter_as]" value="<?php echo $this->config_twitter_as; ?>" size="20" /></td>
		</tr>
		<tr>
			<td class="key"><span class="editlinktip hasTip" title="Twitter Short URL Service::Twitter limits the length of posts.  Choose a short url service to use to shorten the post length.">Twitter Short URL Service:</td>
			<td><?php echo JHTML::_( 'select.genericlist', $shorturlarray, "params[config_twitter_shortutl]", 'size="1" class="inputbox"', 'value', 'text', $this->config_twitter_shortutl ); ?></td>
		</tr>
  	</table>
		</fieldset>
		</div>
		<div class="clr"></div>
    <input type="hidden" name="selplan" value="0" />
		<input type="hidden" id="config_audio_version" name="params[config_audio_version]" value="<?php echo $this->config_audio_version;?>" />
		<input type="hidden" name="option" value="com_livingword" />
 		<input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="livingword" />
		<input type="hidden" name="id" value="<?php echo $this->component->id;?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>