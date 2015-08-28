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
  $livingword->LWgetAuth('tools');
  echo '<script language="JavaScript" type="text/javascript" src="components/com_livingword/assets/js/lw.js"></script>';
  ?>
  <script language="JavaScript" type="text/javascript">
        var selectcom = "<?php echo JText::_('SELECTCOM'); ?>";
        var letter="";
  </script>
  <?php
  $itemid = $livingword->LWgetItemid();
  if($this->config_use_gb){
    JHtml::_('behavior.modal');
    $linkattribs['class'] = 'modal';
    $linkattribs['rel'] = '{handler: \'iframe\', size: {x: 800, y: 500},onClose: function() {parent.location.reload(true); }}';
    } else {
    $linkattribs['onclick'] = "window.open(this.href,this.target,'width=800,height=500,scrollbars=1');return false;";
    }
  $livingword->writeLWHeader(JText::_('LWTOOLS'),JText::_('TOOLMSG'));
  echo '<table class="toollist">';
  echo '<thead><tr><td align="center"><b>'.JText::_('LWPASSDICTSEARCH').'</b></td></tr></thead>';
  echo '<td><div style="text-align:center;"><br />';
  $linkattribs['title'] = JText::_('LWSEARCH1ALT');
  echo JHTML::_('link', 'http://classic.biblegateway.com/passage/index.php?interface=print', JText::_('LWSEARCH1'), $linkattribs).'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
  $linkattribs['title'] = JText::_('LWSEARCH2ALT');
  echo JHTML::_('link', 'http://classic.biblegateway.com/keyword/index.php?interface=print', JText::_('LWSEARCH2'), $linkattribs).'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
  $linkattribs['title'] = JText::_('LWSEARCH3ALT');
  echo JHTML::_('link', 'http://classic.biblegateway.com/topical/index.php?interface=print', JText::_('LWSEARCH3'), $linkattribs).'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
  $linkattribs['title'] = JText::_('LWSEARCH4ALT');
  echo JHTML::_('link', 'http://classic.biblegateway.com/resources/dictionaries/index.php?interface=print', JText::_('LWSEARCH4'), $linkattribs);
  $linkattribs['title'] = '';
  echo '</div><br /></td><br />';
  echo '</tr></tbody></table>';
  echo '<br />';
  echo '<table class="toollist">';
  echo '<form method="post" action="index.php?option=com_livingword&task=tools" name="toolspagecom">';
  echo '<thead><tr><td align="center" colspan="7"><b>'.JText::_('LWBIBLECOM').'</b></td></tr></thead>';
  echo '<tbody><tr><td colspan="7">';
  $comlist = '<select class="" id="selectcomment" name="selectcomment" size="1">';
  $comlist .= '<option value="">'.JText::_('LWSELECTCOM').'</option>';
  foreach($this->commentators as $com)
  {
    $comlist .= '<option value="'.$com['val'].'"';
    $comlist .= '>'.$com['desc'].'</option>';
  }
  echo '</select>&nbsp;&nbsp;';
  echo $comlist;
  echo '</td></tr><tr class="row1"><td valign="top" nowrap><br /><ul class="mod">';
  $k=0;
  for($i=1;$i<74;$i++){
    $i < 10 ? $b = 'LWBIBLEBOOK0' : $b = 'LWBIBLEBOOK';
    if($i != 17 && $i != 18 && $i != 20 && $i != 21 && $i != 27 && $i != 28 && $i != 32){
      $k++;
      if($k == 17) {
      echo '<br /></ul><br /></td><td valign="top" nowrap><br /><ul class="mod">';
      $k=0;
    }
    preg_match('/(LWBIBLEBOOK\d+)/',$b.$i, $bookmatch);
    $bookmatch = ucwords(JText::_($bookmatch[1]));
    $book = preg_replace('/\b(LWBIBLEBOOK\d+)\b/', $bookmatch, $b.$i);
    $comlinkattribs['title'] = JText::_('LWCOMMENTALT').'&nbsp;'.$book;
    $comlinkattribs['id'] = strtolower(str_replace(' ','',$book));
    $comlinkattribs['onclick'] = 'javascript:showComLink(this,'.$this->config_use_gb.');return false;'; 
    echo '<li>'.JHTML::_('link', 'javascript:void(0);', $book, $comlinkattribs).'</li>';
    }
  }
  echo '</ul><br /></td></tr></tbody></table></form>';
  echo '<br />';
  echo '<table class="toollist">';
  echo '<thead><tr><td align="center"><b>'.JText::_('LWLEXICON').'</b></td></tr></thead>';
  echo '<tr class="row1">';
  echo '<td><div style="text-align:center;"><br />';
  $linkattribs['title'] = JText::_('LWLEXICON1ALT');
  echo JHTML::_('link', 'http://www.studylight.org/lex/grk/', JText::_('LWLEXICON1'), $linkattribs).'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
  $linkattribs['title'] = JText::_('LWLEXICON2ALT');
  echo JHTML::_('link', 'http://www.studylight.org/lex/heb/', JText::_('LWLEXICON2'), $linkattribs);
  echo '</div><br /></td>';
   echo '</tr></table><br /><br />';
  $livingword->writeLWFooter();
?>