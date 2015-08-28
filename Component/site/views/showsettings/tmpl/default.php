<?php
/* *************************************************************************************
Title          LivingWord Component for Joomla
Author         Mike Leeper
License        This program is free software: you can redistribute it and/or modify
               it under the terms of the GNU General Public License as published by
               the Free Software Foundation, either version 3 of the License, or
               (at your option) any later version.
               This program is distributed in the hope that it will be useful,
               but WITHOUT ANY WARRANTY; without even the implied warranty of
               MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
               GNU General Public License for more details.
               You should have received a copy of the GNU General Public License
               along with this program.  If not, see <http://www.gnu.org/licenses/>.
Copyright      2008-2014 - Mike Leeper (MLWebTechnologies) 
****************************************************************************************
No direct access*/
defined('_JEXEC') or die('Restricted access');
  global $itemid, $livingword;
  $livingword->LWgetAuth('settings');
  $itemid = $livingword->LWgetItemid();
  $livingword->writeLWHeader($this->title,$this->setmsg);
  if($this->user->id == 0){
    echo '<div style="text-align:center;"><br /><br /><b>'.html_entity_decode(JText::_('LWNOTAUTH')).'<br />';
    echo html_entity_decode(JText::_('LWDOLOGIN')).'</b><br /><br /></div>';
  } else {
    $mysetcount = count($this->mysettings);
    if($mysetcount > 0){ 
      $mybplan = $this->mysettings[0]->bibleplan;
      $mybversion = $this->mysettings[0]->bibleversion;
      $mypversion = $this->mysettings[0]->pbversion;
      $myaversion = $this->mysettings[0]->audioversion;
      $myemail = $this->mysettings[0]->email;
      $myplanviewoffset = $this->mysettings[0]->planview;
      $mydateoffset = $this->mysettings[0]->dateoffset;
      $mystartdate = $this->mysettings[0]->startdate;
      $mybversionnt = $livingword->LWgetNT($mybversion);
      $mybversionav = $livingword->LWgetAudio($mybversion);
    } else {
      $mybplan = "";
      $mybversion = "";
      $mypversion = "";
      $myaversion = "";
      $myemail = "";
      $myplanviewoffset = "";
      $mydateoffset = "";
      $mystartdate = "";
      $mybversionnt = "";
      $mybversionav = ""; 
    }
    $selpv0 = '';
    $selpv1 = '';
		$script = array();
		$script[] = '  var selectav = \''.JText::_('SELECTAV').'\'';
		$script[] = '  var selectbp = \''.JText::_('SELECTBP').'\'';
		$script[] = '  var selectbv = \''.JText::_('SELECTBV').'\'';
		$script[] = '  var selectsd = \''.JText::_('SELECTSD').'\'';
		$script[] = '  var bpcount = '.count($this->bible_plan).';';
    $script[] = '  var optionTmp = new Array(bpcount);';
    $script[] = '  optionTmp[0] = new Array(4);'; 
    $script[] = "  optionTmp[0][0] = '".JText::_('SELECTBP')."';";
    $script[] = '  optionTmp[0][1] = 0;';
    $script[] = '  optionTmp[0][2] = 0;';
    $script[] = '  optionTmp[0][3] = 0;';
    for($i=0,$j=1;$j<count($this->bible_plan);$i++,$j++){
      $script[] = '     optionTmp['.$j.'] = new Array(4);'; 
      $script[] = "     optionTmp[".$j."][0] = '".JText::_($this->bible_plan[$i]->description)."';";
      $script[] = "     optionTmp[".$j."][1] = '".$this->bible_plan[$i]->name."';";
      $script[] = "     optionTmp[".$j."][2] = '".$this->bible_plan[$i]->audio."';";
      $script[] = "     optionTmp[".$j."][3] = '".$this->bible_plan[$i]->newtest."';";
    }
    $script[] = '  function setNTAOptions(){';
		$script[] = '  var bpcount = '.count($this->bible_plan).';';
    $script[] = '  var bv = document.getElementById(\'selectversion\');';
    $script[] = '  var selPlan = document.getElementById(\'selectplan\');';
    $script[] = '  var selIndex = bv.selectedIndex;';
    $script[] = '  if(selPlan.value == 0){';
    $script[] = '  document.settingspage.selplan.value = selPlan.selectedIndex;';
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
    $script[] = '  return true;';
    $script[] = '  }';
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
    echo '<div>';
    echo '<form method="post" action="index.php?option=com_livingword&task=settings" name="settingspage" onSubmit="javascript:return validatep1(this);return false;">';
    echo '<input type="hidden" name="selplan" value="0" />';
    echo '<div><label id="selectversion-lbl"><b>'.JText::_('BVLABEL').'</b></label>';
    $bvlist = '<select class="inputbox" id="selectversion" name="selectversion" size="1" onChange="javascript:setNTAOptions();">';
    $bvlist .= '<option value="0">'.JText::_('SELECTBV').'</option>';
    foreach($this->bible_version as $bv)
    {
      $bvlist .= '<option class="'.$bv['val'].';'.$bv['nt'].';'.$bv['audio'].';'.$bv['aval'].'" value="'.$bv['val'].'"';
      if ($bv['val'] == $mybversion) $bvlist .= ' SELECTED ';
      $bvlist .= '>'.htmlentities($bv['desc']).'</option>';
    }
    $bvlist .= '</select>';
    echo $bvlist.'</div>';
    echo '<div><br /><label id="selectpbversion-lbl"><b>'.JText::_('PBVLABEL').'</b></label>';
    $pvlist = '<select class="inputbox" id="selectpbversion" name="selectpbversion" size="1">';
    $pvlist .= '<option value="0">'.JText::_('SELECTPV').'</option>';
    foreach($this->bible_version as $pv)
    {
      $pvlist .= '<option class="'.$pv['val'].';'.$pv['nt'].';'.$pv['audio'].';'.$pv['aval'].'" value="'.$pv['val'].'"';
      if ($pv['val'] == $mypversion) $pvlist .= ' SELECTED ';
      $pvlist .= '>'.htmlentities($pv['desc']).'</option>';
    }
    $pvlist .= '</select>';
    echo $pvlist.'</div>';
    echo '<div><br /><label id="selectplan-lbl"><b>'.JText::_('BPLABEL').'</b></label>';
    $bplist = '<select class="inputbox" id="selectplan" name="selectplan" size="1" value="'.$mybplan.'">';
    $bplist .= '<option value="0">'.JText::_('SELECTBP').'</option>';
    $bplist .= '</select>';
    echo $bplist.'</div>';
    echo '<div><br /><label id="selectplan-lbl"><b>'.JText::_('AVLABEL').'</b></label>';
    $avlist = '<select class="inputbox" id="audioversion" name="audioversion" size="1">';
    $avlist .= '<option value="0">'.JText::_('SELECTAV').'</option>';
    foreach($this->bible_version as $av)
    {
      if($av['audio']){
        $avlist .= '<option class="'.$av['val'].';'.$av['nt'].';'.$av['audio'].';'.$av['aval'].'" value="'.$av['val'].'"';
        if($av['val'] == $myaversion) $avlist .= ' SELECTED ';
        $avlist .= '>'.htmlentities($av['desc']).'</option>';
      }
    }
    $avlist .= '</select>';
    echo $avlist.'</div>';
    ?>
    <script type="text/javascript">
    var setversion = document.getElementById('selectversion').options[document.getElementById('selectversion').selectedIndex].value;
    if(setversion != null){
      setNTAOptions();
      for(i=0;i<document.getElementById('selectplan').options.length;i++){
        if(document.getElementById('selectplan').options[i].value == '<?php echo $mybplan;?>'){ 
          document.getElementById('selectplan').options[i].selected=true;
        }
      }
    }
    </script>
    <?php
    if($this->config_enable_email){
      echo '<div><br /><label id="selectemail-lbl"><b>'.JText::_('EMLABEL').'</b></label>';
      if($myemail){
        $yemail = 'checked';
        $nemail = '';
      }else{
        $yemail = '';
        $nemail = 'checked';
      }
      echo '<input type="radio" class="btn-group" name="selectemail" value="1" '.$yemail.' />'.JText::_('LWYES').'&nbsp;';
      echo '<input type="radio" class="btn-group" name="selectemail" value="0" '.$nemail.' />'.JText::_('LWNO');
      echo '</div>';
    }
    if($myplanviewoffset == 1) $selpv0 = 'SELECTED';
    if($myplanviewoffset == 2) $selpv1 = 'SELECTED';
    echo '<div><br /><label id="selectaltplanview-lbl"><b>'.JText::_('ALTPLANVIEWLABEL').'</b></label>';
    echo '<select class="inputbox" name="selectaltplanview" id="selectaltplanview">';
    echo '<option value="">'.JText::_('SELECTALTPLANVIEW').'</option>';
    echo '<option value="1" '.$selpv0.'>'.JText::_('SELECTALTPLANVIEWOPT1').'</option>';
    echo '<option value="2" '.$selpv1.'>'.JText::_('SELECTALTPLANVIEWOPT2').'</option>';
    echo '</select></div>';
    echo '<div><br /><label id="selectaltdate-lbl"><b>'.JText::_('ALTDATELABEL').'</b></label>';
    $y = date("Y",time());
    $today = date("Y-m-d",time());
    if($mystartdate == '0000-00-00' || empty($mystartdate)) $mystartdate = $today;
    echo $livingword->LWcalendar($mystartdate,'selectaltdate','selectaltdate',true);
    echo '</div>';
    echo '<div><br /><label id="altselectoffset-lbl"><b>'.JText::_('ALTLESSONLABEL').'</b></label>';
    $altlist = '<select class="inputbox" id="altselectoffset" name="altselectoffset" onChange="javascript:document.settingspage.selectoffset.value=document.settingspage.altselectoffset.value;document.settingspage.selectaltdate.value=getdate();">';
    $altlist .= '<option value="0">'.JText::_('SELECTALTDATE').'</option>';
    $db = JFactory::getDBO();
    $db->setQuery("SELECT COUNT(id) FROM #__livingword_plans_details WHERE plan='".$mybplan."'");
    $d = $db->loadResult();
    for($i=1;$i<$d;$i++)
    {
      if ($i == $mydateoffset) {
        $altlist .= '<option value="0" SELECTED ';
      } else {
        $altlist .= '<option value="'.$i.'"';
      }
      $altlist .= '>'.JText::_('DAY').$i.'</option>';
    }
    echo '</select>';
    echo $altlist.'</div>';
    echo '<input type="hidden" name="selectoffset" value="'.$mydateoffset.'" />';
    echo '<input type="hidden" name="bibleversion" value="'.$mybversion.'" />';
    echo '<input type="hidden" name="bibleplan" value="'.$mybplan.'" />';
    echo '<input type="hidden" name="option" value="com_livingword" />';
    echo '<input type="hidden" name="task" value="livingword.savesettings" />';
	  echo JHTML::_( 'form.token' );
  	echo '<div><br /><br /><input type="submit" name="select" value="'.JText::_('LWSUBMIT').'"><br /><br /><br /></div>';
    echo '</div></form></div>';
  }
  $livingword->writeLWFooter();
?>