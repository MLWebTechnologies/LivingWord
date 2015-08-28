<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
	global $livingwordadmin, $bible_version;
	JRequest::setVar( 'hidemainmenu', 1 );
  $d = "#[\\\/]#";
  $lf = preg_split($d,$this->file,-1,PREG_SPLIT_NO_EMPTY);
  $lffile = $lf[count($lf)-1];
  $lffolder = $lf[count($lf)-2];
  $lang_path = JPATH_ROOT.'/components/com_livingword/assets/language/';
  $content = file($lang_path.$lffolder.'/'.$lffile);
	$filelanguage 	= preg_replace('/^.*language[ ]+/i', '', trim($content[2],'; ') );
  ?>
	<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
  {
		Joomla.submitform( task, document.getElementById('book-form') );
	}
  </script>
	<div class="span10 form-horizontal">
  	<form action="index.php?option=com_livingword" method="post" name="adminForm" id="book-form">
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label"><?php echo JText::_( 'Language:' ); ?></div>
    			<?php
          $livingwordadmin->LWgetPrefOptions();
          $keyarr = $livingwordadmin->lw_array_search_recursive(strtoupper($lffolder), $bible_version);
          $key = $keyarr[0];
          if(strtoupper($lffolder) == 'SK'){
            $booklang = htmlentities(ltrim($filelanguage,'-'),ENT_COMPAT,'UTF-8');
          } else {
            !$livingwordadmin->checkutf8($bible_version[$key]['val']) ? $booklang = htmlentities(ltrim($filelanguage,'-')) : $booklang = ltrim($filelanguage,'-');
          }
          ?>
					<div class="controls"><?php echo $booklang; ?></div>
				</div>
      <?php
      if($this->file){
      ?>
				<div class="control-group">
					<div class="control-label"><?php echo JText::_( 'File Name' ); ?></div>
					<div class="controls"><?php echo $lffile; ?></div>
				</div>
      <?php  
      }
      ?>
			<div class="control-group">
      <br />
      <?php
      $filename = JPATH_ROOT.'/components/com_livingword/assets/language/'.$lffolder.'/'.$lffile;
  		$langcontents = fopen($filename,"rb");
      if(strtoupper($lffolder) == 'SK'){
        $initstring = htmlentities(fread($langcontents,filesize($filename)),ENT_COMPAT,'UTF-8');
      } else {
    		!$livingwordadmin->checkutf8($bible_version[$key]['val']) ? $initstring = htmlentities(fread($langcontents,filesize($filename))) : $initstring = fread($langcontents,filesize($filename));
      }
  		fclose($langcontents);
			?><div class="controls"><?php
        echo $this->editor->display( 'lang_book',  $initstring , '90%', '250', '200', '15', false );
      ?>
			<br /><br /></div>
		</div>
		</div>
  </div>
  <div class="clr"></div>
	<input type="hidden" name="option" value="com_livingword" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="controller" value="livingword" />
  <input type="hidden" name="config_langbookfile" value="<?php echo $lffile;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	 </form>
	<?php
	echo '<br />';
  $livingwordadmin->LWFooter();
?></div>