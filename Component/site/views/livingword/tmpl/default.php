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
               Bookmarks by AddThis
****************************************************************************************
No direct access*/
defined('_JEXEC') or die('Restricted access');
  global $livingword;
  $livingword->LWgetAuth('home');
  echo '<style type="text/css">ul.reading li {list-style-type:none;display:inline;}</style>';
  $livingword->writeLWHeader($this->title,$this->intro);
  $readingarray = $livingword->LWGetReadingLink();
  $curdate = $livingword->readingCurDate($this->bplan);
  if($curdate >= 0) {
    echo '<center><div class="reading"><br /><center><b>'.JText::_('LWTODAYSREADING').':</b><ul class="reading"><li>'.$readingarray['rlink'].'</li></ul>';
  } else {
    echo '<center><div class="reading"><br /><center><b>'.JText::_('LWPLANNOTBEGIN').'</b><br /><br />';
  }
  echo '<a href="'.JRoute::_("index.php?option=com_livingword&task=view_plan").'">'.JText::_('LWVIEWFULLPLAN').'</a><br /><br /></center></div></center>';
  echo '<br /><br />';
  $livingword->writeLWFooter();
?>