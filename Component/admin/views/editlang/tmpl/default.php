<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
		global $livingwordadmin;
  	$version = new JVersion();
  	JRequest::setVar( 'hidemainmenu', 1 );
    $edit = $this->edit;
  	$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
  	JToolBarHelper::title(   JText::_( 'Edit Language' ).': <small><small>[ ' . $text.' ]</small></small>' , 'langmanager' );
  		JToolBarHelper::save('livingword.saveLang', 'Save' );
  	if (!$edit)  {
  		JToolBarHelper::cancel('livingword.canceleditlang');
      JToolBarHelper::help( 'language.help.html', true);
  	} else {
  		JToolBarHelper::cancel( 'livingword.canceleditlang', 'Close' );
  	}
    if(empty($edit)) $edit = 0;
		if(!$this->file){
      $lffile = 'en-GB.com_livingword.ini';
      $lffolder = 'en-GB';
     } else {
      $d = "#[\\\/]#";
      $lf = preg_split($d,$this->file,-1,PREG_SPLIT_NO_EMPTY);
      $lffile = $lf[count($lf)-1];
      $lffolder = $lf[count($lf)-2];
    }
    ?>
		<script language="javascript" type="text/javascript">
  	function submitbutton(pressbutton) {
      var edit = <?php echo $edit;?>;
  		var form = document.adminForm;
  		if (pressbutton == 'canceleditlang') {
  			submitform( pressbutton );
  			return;
  		}
      if (edit > 0) {
        submitform(pressbutton);
        return;
      }
  		// do field validation
      var q = new RegExp('[a-z]+\-[A-Z]');
  		if (form.config_langfolder.value == "" || q.test(form.config_langfolder.value) != true || form.config_langfolder.value == 'en-GB'){
  			alert( "<?php echo JText::_( 'Please enter a valid language code. \n(Example: en-GB)', true ); ?>" );
  		} else {
  			submitform( pressbutton );
  		}
  	}
    </script>
  	<form enctype="multipart/form-data" action="index.php?com_livingword" method="post" name="adminForm" id="adminForm">
    <div class="col width-50">
  	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
		<table class="admintable">
    <?php
    if($this->file){
      ?>
  		<tr>
  			<td width="100" align="right" class="key">
  				<label for="title" style="white-space:nowrap;">
  					<?php echo JText::_( 'File Name' ); ?>:
  				</label>
  			</td>
        <td>
  			<input class="text_area" type="text" name="config_langfile" id="config_langfile" size="32" maxlength="250" value="<?php echo $lffile;?>" readonly="readonly" />
        </td>
        </tr>
      <?php  
    }
    ?>
		<tr>
			<td width="100" align="right" class="key">
				<label for="title" style="white-space:nowrap;">
					<?php 
            echo JText::_( 'Language Code:' );
          ?>
				</label>
			</td>
			<td style="white-space:nowrap;">
      <?php
      if(!$this->file){
        ?>
  			<input class="text_area" type="text" name="config_langfolder" id="config_langfolder" size="6" maxlength="250" value="" />
        <?php
          if(!$this->file){
            echo '(Example en-GB.  See Help for details)';
          }
      } else {
        ?>
  			<input class="text_area" type="text" name="config_langfolder" id="config_langfolder" size="6" maxlength="250" value="<?php echo $lffolder;?>" readonly="readonly" />
  			<?php
      }
      ?>
      </td>
		</tr>
	</table>
	</fieldset>
  </div>
  <div>
	<table style="text-align:left;width:100%;padding-left:6px;">
	<tr>
		<td style="text-align:center;"><br />
    <?php
    $filename = JPATH_ROOT.'/language/'.$lffolder.'/'.$lffile;
		$langcontents = fopen($filename,"rb");
		$initstring = fread($langcontents,filesize($filename));
		fclose($langcontents);
    echo $this->editor->display( 'config_lang',  $initstring , '90%', '250', '200', '15', false ) ;
    ?>
		<br /><br /></td>
	</tr>
	</table>
  </div>
  <div class="clr"></div>
	<input type="hidden" name="option" value="com_livingword" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="controller" value="livingword" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>
	<?php
	echo '<br />';
  $livingwordadmin->LWFooter();
?>