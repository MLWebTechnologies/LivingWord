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
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
  	$version = new JVersion();
    include_once('components/com_livingword/helpers/lw_version.php');
    $lwversion = new LWVersion();
    $livesite = JURI::base();
    $lang_path = JPATH_ROOT.'/language/';
    jimport('joomla.filesystem.folder');
    $langfolderarray = JFolder::folders($lang_path, '.', false, false, array('pdf_fonts'));
    $langarray = array();
    foreach($langfolderarray as $langfolder){
      $langfilesarray = JFolder::files($lang_path.$langfolder,'com_livingword.ini',false,true);
      $langarray = array_merge_recursive($langarray,$langfilesarray);
     }
    $lfsubmit = "";
    $lfsubmit .= 'LivingWord Language File Submission%0D%0A%0D%0A';
    $lfsubmit .= "LivingWord Version:%20".$lwversion->getLongVersion()."%0D%0A%0D%0A";
    $lfsubmit .= 'Joomla! Version:%20'.$version->getLongVersion().'%0D%0A%0D%0A%0D%0A%0D%0A';
    $lfsubmit .= 'Do you wish to have your name and/or email address listed as the author of this language file?%0D%0A%0D%0A';
    $lfsubmit .= 'Would you agree to be contacted when language file changes are made in future version of LivingWord?%0D%0A%0D%0A%0D%0A%0D%0A';
    $lfsubmit .= 'Please attach the language file to this message. It will then be made available for others to download.%0D%0A%0D%0A';
    $client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
    $params = JComponentHelper::getParams('com_languages');
    $defaultlang = $params->get($client->name, 'en-GB');
    if (!empty( $this->sidebar)) : ?>
  	<div id="j-sidebar-container" class="span2">
  		<?php echo $this->sidebar; ?>
  	</div>
  	<div id="j-main-container" class="span12">
    <?php else : ?>
    	<div id="j-main-container">
    <?php endif;?>
    <div class="well well-small" style="color:#08c;font-size:small;"><div class="module-title nav-header">Installed Language Files</div>
  	<form action="index.php?option=com_livingword&task=manage_lang" method="post" name="adminForm" id="adminForm">
		<table class="table table-striped" id="lwlangList">
  	<thead>
    	<tr>
			<th width="5%"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
			<th width="15%" class="title nowrap small hidden-phone"><?php echo JText::_( 'Joomla Default' );?></th>
			<th class="title nowrap small hidden-phone" width="5%"><?php echo JText::_( 'Tag');?></th>
			<th class="title nowrap small hidden-phone" width="15%" class="title"><?php echo JText::_( 'File');?></th>
			<th class="title nowrap small hidden-phone" width="15%" class="title"><?php echo JText::_( 'Name' );?></th>
			<th class="title nowrap small hidden-phone" width="5%"><?php echo JText::_( 'Version' ); ?></th>
			<th class="title nowrap small hidden-phone" width="10%"><?php echo JText::_( 'Date' ); ?></th>
			<th class="title nowrap small hidden-phone" width="15%"><?php echo JText::_( 'Author' ); ?></th>
			<th class="title nowrap small hidden-phone" width="15%"><?php echo JText::_( 'Author Email' ); ?></th>
		</tr></thead><tbody>
    <?php
    for($j=0;$j<count($langarray);$j++)
    {
      $d = "#[\\\/]#";
      $lf = preg_split($d,$langarray[$j],-1,PREG_SPLIT_NO_EMPTY);
      $lffile = count($lf)-1;
      $lffolder = $lffile-1;
			$ldata = JApplicationHelper::parseXMLLangMetaFile($lang_path.$lf[$lffolder].'/'.$lf[$lffolder].'.xml');
			$row = new StdClass();
			$row->id = $j;
			$row->language = substr($lf[$lffolder].'.xml',0,-4);
			if (!is_array($ldata)) {
				continue;
			}
			foreach($ldata as $key => $value) {
				$row->$key = $value;
			}
    $content = file($lang_path.$lf[$lffolder].'/'.$lf[$lffile]);
		if (strpos($content[0],'.ini')) {
			$line = preg_replace('/^.*[.]ini[ ]+/','',$content[0]);
			list( $file['version'], $file['date'], $file['time'], $file['owner'], $file['complete'] ) = explode( ' ', $line . '   ', 6 );
			$file['headertype'] = 1;
		}
		$file['author'] 	= preg_replace('/^.*author[ ]+/i', '', trim($content[1],'# ') );
		$file['author email'] 	= preg_replace('/^.*author email[ ]+/i', '', trim($content[2],'# ') );
		$file['language'] 	= preg_replace('/^.*language[ ]+/i', '', trim($content[5],'# ') );
    ?>
		<tr style="color:#555;">
      <td align="center" width="5"><input type="checkbox" id="cb<?php echo $j;?>" name="fid[]" value="<?php echo $lf[$lffolder].'/'.$lf[$lffile]; ?>" onClick="isChecked(this.checked);"></td>
      <td class="center hidden-phone small">
				<?php echo JHtml::_('jgrid.isdefault', $defaultlang == $lf[$lffolder], $j, JText::_( 'Default Bible Plan' ), $defaultlang != $lf[$lffolder]);?>
        &nbsp;<?php echo $row->name;?>
      </td>
       <td class="small hidden-phone nowrap"><?php echo $lf[$lffolder]; ?>
      			<?php if(file_exists(JPATH_ROOT.'/media/mod_languages/images/'.preg_replace('/(\-\w+)/','',$lf[$lffolder]).'.gif') ) echo '&nbsp;'.JHtml::_('image', 'mod_languages/'.preg_replace('/(\-\w+)/','',$lf[$lffolder]).'.gif', $row->name, array('title'=>$row->name), true);?>
      </td>
			<td class="small hidden-phone nowrap"><span class="editlangtip hasTip" title="<?php echo JText::_( 'Edit Language File' );?>::<?php echo $lf[$lffile]; ?>">
				<a href="#edit" onclick="return listItemTask('cb<?php echo $j; ?>','editlang')">
				<?php echo $lf[$lffile]; ?></a></span></td>
			<td class="small hidden-phone">
   			<?php
					echo $file['language'];
				?>
      </td>
			<td class="small hidden-phone"><?php echo $file['version']; ?></td>
			<td class="small hidden-phone"><?php echo $file['date']; ?></td>
			<td class="small hidden-phone"><?php echo $file['author']; ?></td>
			<td class="small hidden-phone"><?php echo $file['author email']; ?></td>
    </tr>
    <?php
    }
    ?>    
		<input type="hidden" name="boxchecked" value="0" />
 		<input type="hidden" name="task" value="manage_lang" />
    </tbody></table></form></div>
		<div class="well well-small">
  	<table class="table table-striped">
    <form enctype="multipart/form-data" action="index.php?option=com_livingword&task=manage_lang" method="POST" name="LangFileUp">
    <tr><td class="small hidden-phone center" colspan="9"><br />
    <input type="hidden" name="MAX_FILE_SIZE" value="100000" /><b>
    Choose a file to upload:&nbsp;</b><input name="uploadedlangfile" type="file" size="40" style="height:24px;font-size:small;" /> 
    <input type="submit" value="Upload File" style="height:24px;font-size:small;" /> 
    <input type="hidden" name="task" value="uploadLangfile" />
    </td></tr></form></table>
    </div>
    <div class="well well-small"><div class="module-title nav-header">Quick Links</div>	<div class="row-striped">
      <div class="row-fluid"><div class="span12"><a href="http://www.joomlacode.org/gf/project/livingword/frs/"><i class="icon-download"></i> <span><?php echo JText::_('Download available language files'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_languages"><i class="icon-flag"></i> <span><?php echo JText::_('Joomla Language Manager'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="mailto:web@mlwebtechnologies.com?subject=LivingWord%20Language%20File%20Submission&body=<?php echo $lfsubmit; ?>"><i class="icon-envelope"></i> <span><?php echo JText::_('Submit a language file'); ?></span></a></div></div>
     </div>
	  </div>
  <div class="clearfix"></div><br /><br />
	<?php
  $livingwordadmin->LWfooter();
?>