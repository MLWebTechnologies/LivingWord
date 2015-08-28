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
  jimport('joomla.html.pagination');
  $itemid = $livingword->LWgetItemid();
  $JVersion = new JVersion();
  if($this->config_use_gb) {
    JHtml::_('behavior.modal');
    $linkattribs['class']='modal';
    $linkattribs['rel'] = "{handler: 'iframe', size: {x: 800, y: 500}}";
    $alinkattribs['class'] = 'modal'; 
    $alinkattribs['rel'] = "{handler: 'iframe', size: {x: 400, y: 200}}";
    } else {
    $linkattribs['onclick'] = "window.open(this.href,this.target,'width=800,height=500,scrollbars=1');return false;";
    $alinkattribs['onclick'] = "window.open(this.href,this.target,'width=400,height=200');return false;";
  }
  $class = "";
  $class2 = "";
  $lwbookmark = "";
  if( (real)$JVersion->RELEASE == 1.5 ) {
      global $mainframe;
      $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
  } elseif( (real)$JVersion->RELEASE >= 1.6 ){
    $app = JFactory::getApplication();
  	$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
  }
  if (empty($limitstart)) $limitstart = 0;
  $limitstart = JRequest::getVar('limitstart','','get','int');
  $limitpage = $limit + $limitstart;
	$db	= JFactory::getDBO();
  $UserDataArray = $livingword->LWGetUserData(false);
  $bplan = $UserDataArray['bplan'];
  $bversion = $UserDataArray['bversion'];
  $bplansql = $bplan;
  $chplan = $livingword->LWGetPlanData($bplansql);
  $db->setQuery("SELECT message, description FROM #__livingword_plans WHERE name='".$bplansql."' ORDER BY ordering");
  $rplan = $db->loadObject();
  $readingmsg = stripslashes(JText::_($rplan->message));
  $planmsg = $rplan->description;
  if(!$this->pop){
    $livingword->writeLWHeader(JText::_('LWVIEWBP'),$readingmsg);
  }
  $ical_link = JRoute::_("index.php?option=com_livingword&amp;task=createICS&amp;langfile=".$this->langfile."&amp;bv=".$bversion."&amp;bp=".$bplan."&amp;format=raw&amp;tmpl=component");
  $print_link = JRoute::_("index.php?option=com_livingword&amp;task=view_plan&amp;plan=".$this->plan."&amp;pop=1&amp;tmpl=component&amp;Itemid=".$itemid);
	$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no';
  if( (real)$JVersion->RELEASE == 1.5 ) {
		$image =  JHTML::_('image', 'printButton.png', '/images/M_images/', NULL, NULL, htmlentities(JText::_('LWPRINT')), 'style="border:0;float:right;padding:4px 0px 0px 0px;"');
  } elseif( (real)$JVersion->RELEASE >= 1.6 ){
		$image =  JHTML::_('image', 'printButton.png', '/media/system/images/', NULL, NULL, htmlentities(JText::_('LWPRINT')), 'style="border:0;float:right;padding:4px 0px 0px 0px;"');
  }
	$icalimage = JHTML::_('image',  'ical.gif', '/components/com_livingword/assets/images/', NULL, NULL, JText::_( 'LWICAL' ), 'style="border:0;float:right;margin-right:2px;padding:4px 0px 0px 4px;"' );
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
	echo '<br /><form method="post" action="'.$this->action.'" name="adminForm"><table class="planlist">';
  $audio_version = $livingword->LWgetAudio($bversion);
  if(!$this->pop){
    if($this->config_show_bookmarks){ 
      $rlshare = JURI::base()."index.php?option=com_livingword&task=view_plan&plan=$bplan&bibleversion=$bversion&Itemid=$itemid";
      $lwbookmark = '<div style="float:left;padding:4px 0px 0px 4px;"><script type="text/javascript">var addthis_config = {ui_language:"'.$bmlang.'",services_exclude:"print,email"}</script><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250" addthis:url="'.urldecode($rlshare).'"><img src="http://s7.addthis.com/static/btn/v2/lg-share-'.$bmlang.'.gif" width="125" height="16" alt="'.JText::_('LWBMSHAREPLAN').'" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script></div>';
    }  
    ?><thead><tr><td align="center" colspan="3" style="line-height:2em;vertical-align:bottom;"><?php if($this->config_show_bookmarks) echo $lwbookmark;?><a href="<?php echo $print_link; ?>" target="_blank" onclick="javascript:void window.open('<?php echo $print_link; ?>','win2','<?php echo $status; ?>'); return false;" title="<?php echo JText::_('LWPRINT');?>">
	  <?php if($this->config_show_print) echo $image;?></a>
    <a href="<?php echo $ical_link; ?>" target="_blank" onclick="javascript:void window.open('<?php echo $ical_link; ?>','win2','<?php echo $status; ?>'); return false;" title="<?php echo JText::_('LWICAL');?>">
    <?php if($this->config_show_ical) echo $icalimage;?></a><b><?php echo JText::_($planmsg);?></b>
    </td></tr></thead><?php
  }
  if($this->pop) echo '<br /><tr><td colspan="3" align="right"><center><b>'.JText::_($planmsg).'</b></center><input type="button" value="'.JText::_('LWPRINT').'" onclick="javascript:window.print();" /></td></tr>';
  $curdate = $livingword->readingCurDate($bplan);
  if(count($chplan) - $limitstart < $limit) $limitpage = count($chplan);
  if(!$this->pop){
  	$pageNav = new JPagination( count($chplan), $limitstart, $limit  );
    $s = $limitstart;
    $l = $limitpage;
  } else {
    $s = 0;
    $l = count($chplan);
  }
  for($d=$s;$d<$l;$d++){
    $e = $d + 1;
    if($e == $livingword->readingCurDate($bplan) && !$this->pop){ $class = 'class="curdate"'; $class2 = 'class="curlink"';}
    $readingarray = $livingword->LWGetReadingLink(false,$d);
    echo '<tbody>';
    echo '<tr class="';
    if($d %2 )
    {
      echo 'odd';
    } else {
      echo 'even';
    }
    echo '">';
    if($this->pop){
      echo '<td align="center" nowrap><input type="checkbox" /></td>';
      echo '<td align="center" nowrap '.$class.'><b>'.JText::_('DAY').$e.'</td><td align="center" '.$class2.'>'.$readingarray['reading_str'].'</b>';
    } else {
    echo '<td align="center" nowrap '.$class.'><b>'.JText::_('DAY').$e.'</td><td align="center" '.$class2.'>'.$readingarray['rlink'].'</b>';
    }
    if($bplan == 'bio') echo '</td><td align="center" nowrap '.$class2.'>'.$chplan[$d]['figure'];
    echo '</td></tr>';
    $class = "";
    $class2 = "";
  }
  echo '</tbody>';
  echo '</table></form>';
  if(!$this->pop){
    echo '<br /><div><span id="counter" style="padding:1px 75px 0px 10px;float:left;">'.$pageNav->getResultsCounter().'</span>';
		echo '<span class="pagelinks">'.$pageNav->getPagesLinks().'</span>';
    echo '<form method="post" action="'.$this->action.'" name="lboxlist" id="lboxlist">';
    echo '<span id="limit" style="float:right;padding-left:75px;padding-top:1px;white-space:nowrap;">'.JText::_('LW_DISPLAY_NUM').$pageNav->getLimitBox();
    echo '</span></form>';
    echo '</b></div>';
  }
  echo '<br /><br /><br />';
  if(!$this->pop){
    $livingword->writeLWFooter();
  }
?>