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
  global $livingword;
  $livingword->LWgetAuth('home');
  $user = JFactory::getUser();
  $itemid = $livingword->LWgetItemid();
  $JVersion = new JVersion();
  jimport('joomla.date.date');
  $date = new JDate();  
  jimport('joomla.environment.browser');
  $agent = new JBrowser();
  if (!isset($_REQUEST["month"])) $_REQUEST["month"] = $date->format('m');
  if (!isset($_REQUEST["year"])) $_REQUEST["year"] = $date->format('Y');
  $month = $_REQUEST["month"];
  $year = $_REQUEST["year"];
  $first_day = mktime(0,0,0,$month, 1, $year);
  $fddate = new JDate($first_day); 
  $title = $fddate->format('F'); 
  $day_of_week = $fddate->format('D'); 
  switch($day_of_week){ 
    case JText::_("SUN"): $blank = 0; break; 
    case JText::_("MON"): $blank = 1; break; 
    case JText::_("TUE"): $blank = 2; break; 
    case JText::_("WED"): $blank = 3; break; 
    case JText::_("THU"): $blank = 4; break; 
    case JText::_("FRI"): $blank = 5; break; 
    case JText::_("SAT"): $blank = 6; break; 
  }
  $days_in_month = cal_days_in_month(0, $month, $year) ;
  $prev_year = $year;
  $next_year = $year;
  $prev_month = $month-1;
  $next_month = $month+1; 
  if ($prev_month == 0 ) {  
    $prev_month = 12;
    $prev_year = $year - 1;
  }
  if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $year + 1;
  }
  $class = "";
  $class2 = "";
  $lwbookmark = "";
	$db	= JFactory::getDBO();
  $UserDataArray = $livingword->LWGetUserData(false);
  $bplan = $UserDataArray['bplan'];
  $bversion = $UserDataArray['bversion'];
  $bplansql = $bplan;
  $chplan = $livingword->LWGetPlanData($bplansql);
  $db->setQuery("SELECT message, description FROM #__livingword_plans WHERE name='".$bplansql."' ORDER BY ordering");
  $rplan = $db->loadObject();
  $startdate = $livingword->readingCurDate($bplan,'raw');
  $readingmsg = stripslashes(JText::_($rplan->message));
  $planmsg = $rplan->description;
  if(!$this->pop){
    $livingword->writeLWHeader(JText::_('LWVIEWBP'),$readingmsg);
  }
  $ical_link = JRoute::_("index.php?option=com_livingword&amp;task=createICS&amp;langfile=".$this->langfile."&amp;bv=".$bversion."&amp;bp=".$bplan."&amp;format=raw&amp;tmpl=component");
  $print_link = JRoute::_("index.php?option=com_livingword&amp;task=view_plan&amp;plan=".$this->plan."&amp;pop=1&amp;tmpl=component&amp;Itemid=".$itemid.'&layout=calendar');
	$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no';
	$image = JHTML::_('image',  JURI::base().'media/system/images/printButton.png', htmlentities(JText::_( 'LWPRINT' )), 'style="border:0;float:right;padding:4px 0px 0px 0px;"');
	$icalimage = JHTML::_('image',  JURI::base().'/components/com_livingword/assets/images/ical.gif', JText::_( 'LWICAL' ), 'style="border:0;float:right;margin-right:2px;padding:4px 0px 0px 4px;"' );
  if($this->config_show_bookmarks && !$this->pop){
    $user = JFactory::getUser();
    $langparams		= $user->getParameters(true);
    $userfelang = $langparams->get( 'language' );
    if(!empty($userfelang)){
      preg_match("#([a-zA-Z])[^-]#",$userfelang,$felangmatches);
      $bmlang = $felangmatches[0];
    } else {
      $langclient	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
      $langparams = JComponentHelper::getParams('com_languages');
      $defaultfelang = $langparams->get($langclient->name, 'en-GB');
      preg_match("#([a-zA-Z])[^-]#",$defaultfelang,$felangmatches);
      $bmlang = $felangmatches[0];
    }
  } else $bmlang = "";
	echo '<br /><form method="post" action="'.$this->action.'" name="adminForm">';
  echo "<table border=1 width=100% class=planlistcal>";
    if(!$this->pop){
      if($this->config_show_bookmarks){ 
        $rlshare = JURI::base()."index.php?option=com_livingword&task=view_plan&plan=$bplan&bibleversion=$bversion&Itemid=$itemid";
        $lwbookmark = '<div style="float:left;padding:4px 0px 0px 4px;"><script type="text/javascript">var addthis_config = {ui_language:"'.$bmlang.'",services_exclude:"print,email"}</script><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250" addthis:url="'.urldecode($rlshare).'"><img src="http://s7.addthis.com/static/btn/v2/lg-share-'.$bmlang.'.gif" width="125" height="16" alt="'.JText::_('LWBMSHAREPLAN').'" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script></div>';
      }  
      ?><thead><tr><td align="center" colspan="7" style="line-height:2em;vertical-align:bottom;"><?php if($this->config_show_bookmarks) echo $lwbookmark;?><a href="<?php echo $print_link; ?>" target="_blank" onclick="javascript:void window.open('<?php echo $print_link; ?>','win2','<?php echo $status; ?>'); return false;" title="<?php echo JText::_('LWPRINT');?>">
  	  <?php if($this->config_show_print) echo $image;?></a>
      <a href="<?php echo $ical_link; ?>" target="_blank" onclick="javascript:void window.open('<?php echo $ical_link; ?>','win2','<?php echo $status; ?>'); return false;" title="<?php echo JText::_('LWICAL');?>">
      <?php if($this->config_show_ical) echo $icalimage;?></a><b><?php echo JText::_($planmsg);?></b>
      </td></tr></thead><?php
    }
  if(!$this->pop){
    ?>
    <tr><td colspan="7"><table class="planlistpage">
      <tr><td width="20%" align="center" colspan="2" class="calpageprev" >
      <?php
      if(date("Y",strtotime($startdate)) > $prev_year || (date("Y",strtotime($startdate)) == $year && date("m",strtotime($startdate)) > $prev_month)) {
        echo JText::_('LWCALPREVMON');
      } else {
      ?>
        <a href="<?php echo "index.php?option=com_livingword&task=view_plan&Itemid=".$itemid."&month=".$prev_month."&year=".$prev_year; ?>"><?php echo JText::_('LWCALPREVMON');?></a>
      <?php } ?>
      </td>
      <td colspan="3" width="60%" align="left" class="calmonname"><?php echo $title.' '.$year; ?></td>
      <td width="20%" align="center" colspan="2" class="calpagenext">
        <a href="<?php echo "index.php?option=com_livingword&task=view_plan&Itemid=".$itemid."&month=".$next_month."&year=".$next_year; ?>"><?php echo JText::_('LWCALNEXTMON');?></a>
      </td></tr>
    </table></td></tr>
    <?php
  } else {
    ?><th colspan="7" width="20%" align="left" class="calmonname"><?php echo $title.' '.$year; ?></th><?php
  }
    echo "<tr class='caldayname'><td width='42'>".JText::_('SUN')."</td><td width='42'>".JText::_('MON')."</td><td width='42'>".JText::_('TUE')."</td><td width='42'>".JText::_('WED')."</td><td width='42'>".JText::_('THU')."</td><td width='42'>".JText::_('FRI')."</td><td width='42'>".JText::_('SAT')."</td></tr>";
    if($this->pop) echo '<br /><tr><td colspan="7" align="right"><center><b>'.JText::_($planmsg).'</b></center><input type="button" value="'.JText::_('LWPRINT').'" onclick="javascript:window.print();" /></td></tr>';
    $curdate = $livingword->readingCurDate($bplan);
    $day_count = 1;
    echo '<tbody>';
    echo '<tr class="">';
    while ( $blank > 0 ){ 
      echo "<td class=blankday></td>"; 
      $blank = $blank-1; 
      $day_count++;
    }
    $day_num = 1;
    if($startdate == '0000-00-00'){
      $syear = date("Y");
    } else {
      $syear = date("Y",strtotime($startdate));
    }
    $yeardiff = $year - $syear;
    $plancount = $livingword->LWGetPlanCount($bplan);
    $firstdaynum = date("z",strtotime($month.'/'.$day_num.'/'.$year));
    if($startdate == '0000-00-00'){
      $startdate = 1;
    } else {
      $now = $month.'-'.$day_num.'-'.$year;
      $mystartdiff = $livingword->dateDiff("-",$now,date("m-d-Y",strtotime($startdate)));
      $startdate = date("z",strtotime($startdate));
    }
    if(!$yeardiff){
      $d = $firstdaynum - $startdate;
      while ($d >= $plancount){
        $d = $d-$plancount;
      }
    } else {
      if($mystartdiff < $plancount){
        $d = $mystartdiff;
      } else {
        $d = $mystartdiff - $plancount;
        while ($d >= $plancount){
          $d = $d-$plancount;
        } 
      }
    }
    if($startdate == 1){
      $d++;
    }
    while ( $day_num <= $days_in_month ) 
    { 
      if($d == $livingword->readingCurDate($bplan) && !$this->pop){ $class = ' curdate'; $class2 = ' curlink';}
      if($d > -1) $readingarray = $livingword->LWGetReadingLink(false,$d,true);
      $browserstyle = '';
      if(($agent->getBrowser() == 'msie') && ($agent->getVersion() < 9.0)) $browserstyle = " style='position:relative;left:-40px;'";
      echo "<td class=\"calreadinglink".$class."\"><span class='caldaynum'".$browserstyle.">".$day_num."</span>";
      if(!$this->pop) echo "<span style='margin: -13px 0 0 0;float:right;'>".$readingarray['bmimg']." ".$readingarray['audimg']."</span>";
      echo "<br /><br />";
      if($this->pop){
        echo '<b>'.$readingarray['reading_str'].'</b>';
      } else {
        echo '<b>'.$readingarray['rlink'].'</b>';
      }
      echo "</td>"; 
      $day_num++; 
      $day_count++;
      $d++;
      if($d >= $plancount) $d=0;
      if ($day_count > 7)
      {
         echo "</tr><tr>";
         $day_count = 1;
      }
      $class = "";
      $class2 = "";
    }
    while ( $day_count >1 && $day_count <=7 ) 
    { 
      echo "<td class=blankday> </td>"; 
      $day_count++; 
    } 
    echo "</tr>";
  echo '</tbody>';
  echo '</table></form>';
  echo '<br />';
  if(!$this->pop){
    $livingword->writeLWFooter();
  }
?>   