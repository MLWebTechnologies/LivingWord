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
  $lang = Jfactory::getLanguage();
  $lang->load( 'com_livingword', JPATH_SITE); 
	$version = new JVersion();
  $lang_path = JPATH_ROOT.'/components/com_livingword/assets/language/';
  jimport('joomla.filesystem.folder');
  $langfolderarray = JFolder::folders($lang_path, '.', false, false);
  $langarray = array();
  foreach($langfolderarray as $langfolder){
    $langfilesarray = JFolder::files($lang_path.$langfolder,'com_livingword_biblebooks.ini',false,true);
    $langarray = array_merge_recursive($langarray,$langfilesarray);
   }
  JHtml::_('bootstrap.tooltip');
  JHtml::_('behavior.multiselect');
  JHtml::_('formbehavior.chosen', 'select');
  ?>
  <script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
  {
		Joomla.submitform( task, document.getElementById('books-form') );
	}
  </script>
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span12">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div class="clearfix"> </div>
		<table class="table table-striped" id="lwbooksList">
  	<form action="index.php?option=com_livingword" method="post" name="adminForm" id="books-form">
		<tr>
			<th width="5">&nbsp;</th>
			<th class="title nowrap small hidden-phone" width="200"><?php echo JText::_( 'File');?></th>
			<th class="title nowrap small hidden-phone" width="100"><?php echo JText::_( 'Folder');?></th>
			<th class="title nowrap small hidden-phone" width="25%" class="title"><?php echo JText::_( 'Language' );?></th>
			<th class="title nowrap small hidden-phone" width="10%"><?php echo JText::_( 'Version' ); ?></th>
			<th class="title nowrap small hidden-phone" width="10%"><?php echo JText::_( 'Date' ); ?></th>
			<th class="title nowrap small hidden-phone" width="20%"><?php echo JText::_( 'Author' ); ?></th>
		</tr>
    <?php
    for($j=0;$j<count($langarray);$j++)
    {
      $d = "#[\\\/]#";
      $lf = preg_split($d,$langarray[$j],-1,PREG_SPLIT_NO_EMPTY);
      $lffile = count($lf)-1;
      $lffolder = $lffile-1;
      $content = file($lang_path.$lf[$lffolder].'/'.$lf[$lffile]);
  		if (strpos($content[0],'.ini')) {
  			$line = preg_replace('/^.*[.]ini[ ]+/','',$content[0]);
  			list( $file['version'], $file['date'], $file['time'], $file['owner'], $file['complete'] ) = explode( ' ', $line . '   ', 6 );
  			$file['headertype'] = 1;
  		}
  		$file['author'] 	= preg_replace('/^.*author[ ]+/i', '', trim($content[1],'; ') );
  		$file['language'] 	= preg_replace('/^.*language[ ]+/i', '', trim($content[2],'; ') );
      ?>
  		<tbody><tr class="row0">
      <td class="small hidden-phone"><input type="checkbox" id="cb<?php echo $j;?>" name="fid[]" value="<?php echo $lf[$lffolder].'/'.$lf[$lffile]; ?>" onclick="Joomla.isChecked(this.checked);" /></td>
			<td class="small hidden-phone" nowrap><span class="editbooktip hasTip" title="<?php echo JText::_( 'Edit Bible Book File' );?>::<?php echo $lf[$lffile]; ?>">
					<a href="#edit" onclick="return listItemTask('cb<?php echo $j; ?>','editbook')">
						<?php echo $lf[$lffile]; ?></a></span></td>
      <td class="small hidden-phone"><?php echo strtoupper($lf[$lffolder]); ?></td>
      <?php
      $livingwordadmin->LWgetPrefOptions();
      $keyarr = $livingwordadmin->lw_array_search_recursive(strtoupper($lf[$lffolder]), $bible_version);
      $key = $keyarr[0];
      if(strtoupper($lf[$lffolder]) == 'SK'){
        $book = htmlentities(ltrim($file['language'],'-'),ENT_COMPAT,'UTF-8');
      } else {
        !$livingwordadmin->checkutf8($bible_version[$key]['val']) ? $book = htmlentities(ltrim($file['language'],'-')) : $book = ltrim($file['language'],'-');
      }
  		?>
      <td class="small hidden-phone"><?php echo $book; ?></td>
			<td class="small hidden-phone"><?php echo $file['version']; ?></td>
			<td class="small hidden-phone" style="white-space:nowrap;"><?php echo $file['date'].' '.$file['time']; ?></td>
			<td class="small hidden-phone"><?php echo $file['author']; ?></td>
      </tr>
      <?php
    }
    ?>    
		<input type="hidden" name="boxchecked" value="0" />
 		<input type="hidden" name="task" value="" />
  	<?php echo JHTML::_( 'form.token' ); ?>
    </tbody></form></table>
  <br />
	<?php
  $livingwordadmin->LWfooter();
?></div>