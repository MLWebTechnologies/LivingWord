<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
  global $livingwordadmin,$lwConfig;
  JRequest::setVar( 'hidemainmenu', 1 );
  $lang = JFactory::getLanguage();
  $lang->load( 'com_livingword', JPATH_SITE);
  $langfile = $livingwordadmin->LWgetLang($lwConfig['config_bible_version']);
  $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
  foreach($this->bookarray as $book){
    $book->text = ucwords(JText::_($book->text));
  }
  $app = JFactory::getApplication();
  $template	= $app->getTemplate();
  $addverseimage = JHTML::_('image', 'administrator/templates/'. $template .'/images/admin/icon-16-add.png', JText::_( 'Add Verse to Reading' ), 'style=""' ); 
  JHTML::_('behavior.tooltip');
  ?>
	<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
  {
		Joomla.submitform( task, document.getElementById('reading-form') );
	}
  function setVisibility(id, visibility) {
    document.getElementById(id).style.display = visibility;
  }
  function createAudio(num){
    var r =  'reading'+num;
    var rb =  'readingbook'+num;
    var a = 'audio'+num;
    var reading = document.getElementById(r).value;
    var book = document.getElementById(rb).options[document.getElementById(rb).selectedIndex].value;
    var bnum =  book.match(/LWBIBLEBOOK(\d+)?/i);
    var verse =  reading.match(/(\d+)[\-]?(\d+)?/i);
    var t = bnum[1]+','+verse[1]+','+verse[2];    
    document.getElementById(a).value=t; 
  }
  </script>
	<div class="span10 form-horizontal">
	<form action="index.php?option=com_livingword" method="post" name="adminForm" id="reading-form">
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'plan' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('plan'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo JText::_( 'Reading' ); ?> *</div>
      <?php
      echo '<div class="controls">';
      $addverseattribs['title'] = JText::_( 'Add Verse to Reading' ); 
    	if ($this->edit)  {
        preg_match_all('/(\w+)\s?([\d\.\:\-\,]+)?/i', $this->form->getValue('reading'), $matches);
        count($matches[0]) ? $count = count($matches[0]) : $count = 0;
        for($i=0,$j=1,$k=2;$i<$count;$i++){
          echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook'.$i, 'size="1" class="inputbox"', 'value', 'text', $matches[$j][$i] );
          ?>
          <input type="text" name="reading<?php echo $i;?>" value="<?php echo $matches[$k][$i]; ?>" />
          <?php
          preg_match('/LWBIBLEBOOK(\d+)?/i', $matches[$j][$i], $rbmatch);
          preg_match('/(\d+)[\-]?(\d+)?/i', $matches[$k][$i], $rmatch);
          if(empty($rmatch[2])) $rmatch[2] = $rmatch[1];
          ?>
          <input type="hidden" name="audio<?php echo $i;?>" value="<?php echo $rbmatch[1].','.$rmatch[1].','.$rmatch[2]; ?>" />
        <?php 
        }
          if($i<4){
            $i = $i++;
            $box = "'box".$i."'";
            $addverseattribs['onclick'] = "javascript:setVisibility($box, 'block');"; 
            $av_image = JHTML::_('link', "#", $addverseimage, $addverseattribs);
            echo $av_image.'</div>';
            for($j=$i;$j<4;$j++){
              $k = $j+1;
              $box = "'box".$k."'";
              $addverseattribs['onclick'] = "javascript:setVisibility($box, 'block');"; 
              $k < 4 ? $av_image = JHTML::_('link', "#", $addverseimage, $addverseattribs) : $av_image = "";
              echo '<div class="controls" id="box'.$j.'" style="display:none;">';
              echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook'.$j, 'size="1" class="inputbox"', 'value', 'text', '' );
              echo '<input type="text" id="reading'.$j.'" name="reading'.$j.'" value="" onblur="javascript:createAudio('.$i.');" />';
              echo '<input type="hidden" id="audio'.$j.'" name="audio'.$j.'" value="" />&nbsp;'.$av_image.'</div>';
            }
          }
      } else {
          echo '<div id="box1">';
          echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook0', 'size="1" class="inputbox"', 'value', 'text', '' );
          echo '<input type="text" id="reading0" name="reading0" value="" onblur="javascript:createAudio(0);" />';
          $addverseattribs['onclick'] = "javascript:setVisibility('box2', 'block');"; 
          $av2_image = JHTML::_('link', "#", $addverseimage, $addverseattribs);
          echo '<input type="hidden" id="audio0" name="audio0" value="" />&nbsp;'.$av2_image.'</div>';
          echo '<div id="box2" style="display:none;">';
          echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook1', 'size="1" class="inputbox"', 'value', 'text', '' );
          echo '<input type="text" id="reading1" name="reading1" value="" onblur="javascript:createAudio(1);" />';
          $addverseattribs['onclick'] = "javascript:setVisibility('box3', 'block');"; 
          $av3_image = JHTML::_('link', "#", $addverseimage, $addverseattribs);
          echo '<input type="hidden" id="audio1" name="audio1" value="" />&nbsp;'.$av3_image.'</div>';
          echo '<div id="box3" style="display:none;">';
          echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook2', 'size="1" class="inputbox"', 'value', 'text', '' );
          echo '<input type="text" id="reading2" name="reading2" value="" onblur="javascript:createAudio(2);" />';
          $addverseattribs['onclick'] = "javascript:setVisibility('box4', 'block');"; 
          $av4_image = JHTML::_('link', "#", $addverseimage, $addverseattribs);
          echo '<input type="hidden" id="audio2" name="audio2" value="" />&nbsp;'.$av4_image.'</div>';
          echo '<div id="box4" style="display:none;">';
          echo JHTML::_( 'select.genericlist', $this->bookarray, 'readingbook3', 'size="1" class="inputbox"', 'value', 'text', '' );
          echo '<input type="text" id="reading3" name="reading3" value="" onblur="javascript:createAudio(3);" />';
          echo '<input type="hidden" id="audio3" name="audio3" value="" /><br /></div></div>';
      }
        ?>
        </div>
            <?php
        if($this->form->getValue('plan') == 'bio'){
        ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'figure' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('figure'); ?></div>
				</div>
        <?php
        }
        if($this->form->getValue('plan') == 'chron'){
        ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'descrip' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('descrip'); ?></div>
				</div>
      <?php
      }
			?>
      </div>
    </div>
	<input type="hidden" name="option" value="com_livingword" />
 	<input type="hidden" name="id" value="<?php echo $this->form->getValue('detailid'); ?>" />
 	<input type="hidden" name="plan" value="<?php echo $this->form->getValue('plan'); ?>" />
 	<input type="hidden" name="planid" value="<?php echo $this->form->getValue('id'); ?>" />
 	<input type="hidden" name="edit" value="<?php echo $this->edit; ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="controller" value="livingword" />
	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<?php
	echo '<br /><br />';
  $livingwordadmin->LWfooter();
?>
   </div>