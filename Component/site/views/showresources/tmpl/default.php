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
  $livingword->LWgetAuth('link');
  echo '<script language="JavaScript" type="text/javascript" src="components/com_livingword/assets/js/lw.js"></script>';
  $itemid = $livingword->LWgetItemid();
  if($this->config_use_gb) {
    JHtml::_('behavior.modal');
    $linkattribs['class']='modal';
    $linkattribs['rel'] = "{handler: 'iframe', size: {x: 800, y: 500}}";
  } else {
    $linkattribs['onclick'] = "window.open(this.href,this.target,'width=800,height=500,scrollbars=1');return false;";
  }
  $livingword->writeLWHeader(JText::_('LWRESOURCES'),JText::_('RESMSG'));
	$weblinkimg =  JHTML::_('image', 'system/weblink.png', htmlentities(JText::_('USRLPCFEEDS')), 'style="border:0;"', true);
  echo '<br /><br /><table class="planlist">';
  echo '<thead><tr><td align="center" width="34%"><b>'.JText::_('LWBIBLESTUDY').'</b></td><td align="center" width="33%"><b>'.JText::_('LW4TEENS').'</b></td><td align="center" width="33%"><b>'.JText::_('LW4KIDS').'</b></td>';
  echo '</thead><tbody><tr><td valign="top"><br /><ul class="mod">';
	for ($i = 0; $i < count($this->alinksArray); $i++){
    $alinks = $this->alinksArray[$i];
    $linkattribs['target'] = $livingword->linkTarget($alinks->target);
    $linkattribs['title'] = stripslashes($alinks->name);
    echo '<li>'.$weblinkimg.'&nbsp;'.JHTML::_('link', $alinks->url, stripslashes($alinks->name), $linkattribs).'</li>';
    }
  echo '</ul><br /></td>';
  echo '<td valign="top"><br /><ul class="mod">';
	for ($i = 0; $i < count($this->tlinksArray); $i++){
    $tlinks = $this->tlinksArray[$i];
    $linkattribs['target'] = $livingword->linkTarget($tlinks->target);
    $linkattribs['title'] = stripslashes($tlinks->name);
    echo '<li>'.$weblinkimg.'&nbsp;'.JHTML::_('link', $tlinks->url, stripslashes($tlinks->name), $linkattribs).'</li>';
    }
  echo '</ul><br /></td>';
  echo '<td valign="top"><br /><ul class="mod">';
	for ($i = 0; $i < count($this->klinksArray); $i++){
    $klinks = $this->klinksArray[$i];
    $linkattribs['target'] = $livingword->linkTarget($klinks->target);
    $linkattribs['title'] = stripslashes($klinks->name);
    echo '<li>'.$weblinkimg.'&nbsp;'.JHTML::_('link', $klinks->url, stripslashes($klinks->name), $linkattribs).'</li>';
    }
  echo '</ul><br /></td>';
  echo '</tr></tbody></table><br />';
  $pdfimage =  JHTML::_('image', 'system/pdf_button.png', htmlentities(JText::_('USRLPCFEEDS')), 'style="border:0;"', true);
  echo '<table class="planlist">';
  echo '<thead><tr><td align="center" colspan="3"><b>'.JText::_('LWEBIBLES').'</b></td>';
  echo '</thead><tbody><tr><td valign="top" width="34%"><br /><ul class="mod">';
  $k = 0;
  for($i=1;$i<count($this->ebibleArray)+1;$i++){
    $k++;
    if($k > ceil(count($this->ebibleArray)/3)) {
      echo '<br /></ul><br /></td><td valign="top" width="33%"><br /><ul class="mod">';
      $k = 1;
    }
    $linkattribs['target'] = '_blank';
    $linkattribs['title'] = htmlentities($this->ebibleArray[$i]['desc']);
    echo '<li>'.$pdfimage.'&nbsp;'.JHTML::_('link', 'http://www.biblica.com/bibles/'.$this->ebibleArray[$i]['val'].'/', htmlentities($this->ebibleArray[$i]['desc']), $linkattribs).'</li>';
  }
  echo '</ul><br /></td></tr></tbody></table><br />';
  echo '<table class="planlist">';
  echo '<thead><tr><td align="center" colspan="3"><b>'.JText::_('LWSPECIALRESOURCES').'</b></td>';
  echo '</thead><tbody><tr><td valign="top" width="34%"><br /><ul class="mod">';
//  $k = 0;
//  for($i=1;$i<count($this->snbibleArray)+1;$i++){
//    $k++;
//    if($k > ceil(count($this->snbibleArray)/3)) {
//      echo '<br /></ul><br /></td><td valign="top" width="33%"><br /><ul class="mod">';
//      $k = 1;
//    }
    $linkattribs['target'] = '_blank';
    $linkattribs['title'] = 'Large Print Bible (KJV)';//htmlentities($this->snbibleArray[$i]['desc']);
//    echo '<li>'.JHTML::_('link', 'http://www.biblica.com/bibles/'.$this->snbibleArray[$i]['val'].'/', $weblinkimg.'&nbsp;'.htmlentities($this->ebibleArray[$i]['desc']), $linkattribs).'</li>';
    echo '<li>'.$weblinkimg.'&nbsp;'.JHTML::_('link', 'http://www.largeprintbible.com/', htmlentities('Large Print Bible (KJV)'), $linkattribs).'</li>';
//  }
  echo '</ul><br /></td></tr></tbody></table><br />';
  $livingword->writeLWFooter();
?>