<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
  global $db, $livingwordadmin;
  jimport('joomla.html.sliders');
  $db	= JFactory::getDBO();
	$version = new JVersion();
  $lang = Jfactory::getLanguage();
  $lang->load( 'com_livingword', JPATH_SITE); 
  include_once('components/com_livingword/helpers/lw_version.php');
  $lwversion = new LWVersion();
  $supportinfo = "";
  $supportinfo .= 'System Information%0D%0A%0D%0A';
  $supportinfo .= "LivingWord Version:%20".$lwversion->getLongVersion()."%0D%0A%0D%0A";
  $supportinfo .= 'Database Version:%20'.$db->getVersion().'%0D%0A';
  $supportinfo .= 'PHP Version:%20'.phpversion().'%0D%0A';
  $supportinfo .= 'Web Server:%20'.$livingwordadmin->lw_get_server_software().'%0D%0A';
  $supportinfo .= 'Joomla! Version:%20'.$version->getLongVersion().'%0D%0A%0D%0A';
  $supportinfo .= 'Relevant PHP Settings%0D%0A';
  $supportinfo .= 'Magic Quotes GPC:%20'.$livingwordadmin->lw_get_php_setting('magic_quotes_gpc').'%0D%0A';
  $supportinfo .= 'Short Open Tags:%20'.$livingwordadmin->lw_get_php_setting('short_open_tag').'%0D%0A';
  $supportinfo .= 'Disabled Functions:%20'.(($df=ini_get('disable_functions'))?$df:'none').'%0D%0A';
	?>
	<?php echo $this->sidebar; ?>
	<div id="j-main-container" class="span8">
		<div class="well well-small" style="color:#08c;font-size:small;"><div class="module-title nav-header">Component Information</div><div class="row-striped">
			<div class="row-fluid small">
				<div class="span6">
					<strong class="row-title" style="margin-left:20px;"><?php echo JText::_('Installed version');?></strong>
				</div>
				<div class="span3" style="white-space:nowrap;">
          <?php
          $url = "http://www.mlwebtechnologies.com/update/livingword-update.xml";
          $data = file_get_contents($url);
          $xmlObj = simplexml_load_string($data);
          $xmlObj->update->version;
          $upglink = $xmlObj->update->downloads->downloadurl;
          if(trim($lwversion->getShortVersion()) < trim($xmlObj->update->version)){
         		$image = JHTML::_('image', '/templates/'.$template.'/images/menu/icon-16-install.png', NULL, 'style=vertical-align:bottom;', true);
          	$attribs['rel']     = 'nofollow';
          	$attribs['class'] = 'upgrade';
          	?><style type="text/css">
            a:link.upgrade, a:visited.upgrade {
              display:inline;
              font-weight:bold;
              color:#FFFFFF;
              background-color:#98bf21;
              width:120px;
              text-align:center;
              padding:4px;
              text-decoration:none;
              font-size:x-small;
            }
            a:hover.upgrade,a:active.upgrade {
              background-color:#7A991A;
            }
            </style>
            <?php
         		echo $lwversion->getLongVersion().'&nbsp;&nbsp;'.JHTML::_('link', JRoute::_($upglink), JText::_($xmlObj->update->version.' Update Available'),$attribs);
          } else {
              echo $lwversion->getLongVersion().'&nbsp;<span style="color:green;font-size:x-small;">[Latest version installed]</span>';          
            }   
            ?>
				</div>
			</div>
			<div class="row-fluid small">
				<div class="span6">
					<strong class="row-title" style="margin-left:20px;"><?php echo JText::_('Copyright');?></strong>
				</div>
				<div class="span3" style="white-space:nowrap;">
          <?php echo $lwversion->getShortCopyright();?>
				</div>
			</div>
			<div class="row-fluid small">
				<div class="span6">
					<strong class="row-title" style="margin-left:20px;"><?php echo JText::_('License');?></strong>
				</div>
				<div class="span3" style="white-space:nowrap;">
            <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank"><img src="<?php echo JURI::base();?>components/com_livingword/assets/images/gplv3-88x31.png" border="0" title="<?php echo JText::_('GNU General Public License v3');?>" width="60px" /></a>&nbsp;<?php echo JText::_('GNU/GPL3');?>
				</div>
			</div>
      <div class="row-fluid small">
        <?php
    		$query = $db->getQuery(true);
    		$query->select('p.extension_id');
    		$query->from('#__extensions AS p');
    	  $query->where('p.element='.$db->Quote('livingword').' AND p.type='.$db->Quote('plugin'));
    	  $db->setQuery($query);
    		$plugid = $db->loadResult();
        if(JPluginHelper::isEnabled('system','livingword')){
          $plugenabled = 'Enabled';
          $plugstatus = 'green';
          $plugiconstatus = 'icon-publish';
          $plugstatustext = 'Edit Plugin';
        } else {
          $plugenabled = 'Disabled';
          $plugstatus = 'red';
          $plugiconstatus = 'icon-unpublish';
          $plugstatustext = 'Edit Plugin';
        }
        $pdir = JPATH_ROOT.'/plugins/system';
        if( (real)$version->RELEASE >= 1.6 ) $pdir .= '/livingword';
        $xmlfile = $pdir.'/livingword.xml';
        $xmldata = $livingwordadmin->LWparseXml($xmlfile);
        if($xmldata){
          $xmldataCD = $xmldata['creationDate'];
          ?>
            <div class="span12">
            <div class="span6"><strong class="row-title" style="margin-left:20px;"><?php echo JText::_('System Plugin Status');?></strong></span></div>
            <div class="span4 right nowrap"><span style="color:green;font-weight:bold;"><?php echo JText :: _('Installed ( v.'.$xmldata['version'].' - '.$xmldataCD.')');?></span></div>
            <div class="span2 center"><font color="<?php echo $plugstatus;?>"><?php echo JText::_($plugenabled);?></font>
            <a href="index.php?option=com_plugins&task=plugin.edit&extension_id=<?php echo $plugid;?>"><span title="<?php echo $plugstatustext;?>" style="float:right;"><i class="<?php echo $plugiconstatus;?>"></i></span></a>
          </div></div>
          <?php
          } else {
          ?>
    			<div class="span6">
              <strong class="row-title" style="margin-left:20px;"><?php echo JText::_('System Plugin');?></strong>
        	</div>
          <div class="span3" style="white-space:nowrap;">
              <font color="red"><?php echo JText :: _('Not Installed');?></font>
          </div>
          <?php
        }
        ?></div>
        <div class="row-fluid small">
        <?php
     		$query = $db->getQuery(true);
    		$query->select('m.published,m.id');
    		$query->from('#__modules AS m');
  		  $query->where('m.module='.$db->Quote('mod_livingword'));
  		  $db->setQuery($query);
  			$moduleenabled = $db->loadObject();
        if(!empty($moduleenabled)){
          $moduleenabled->published ? $modstatus = 'icon-publish' : $modstatus = 'icon-unpublish';
          $moduleenabled->published ? $modstatusstate = 'Enabled' : $modstatusstate = 'Disabled';
          $moduleenabled->published ? $modstatuscolor = 'green' : $modstatuscolor = 'red';
          $modstatustext = 'Edit Module';
        } else {
          $modstatus = "icon-upload";
          $modstatustext = "Install Module";
        }
        $moduledir = JPATH_ROOT.'/modules';
        $pdir = JPATH_ROOT.'/modules/mod_livingword';
        $xmlfile = $pdir.'/mod_livingword.xml';
        $xmldata = $livingwordadmin->LWparseXml($xmlfile);
        if($xmldata){
          $xmldataCD = $xmldata['creationDate'];
          ?>
        <div class="span12">
        <div class="span6"><strong class="row-title" style="margin-left:20px;"><?php echo JText::_('Daily Reading Module'); ?></strong></div>
        <div class="span4 right nowrap"><span style="color:green;font-weight:bold;"><?php echo JText :: _('Installed'); ?> ( v.<?php echo $xmldata['version']; ?> - <?php echo $xmldata['creationDate']; ?> )</span></div>
        <div class="span2 center"><font color="<?php echo $modstatuscolor;?>"><?php echo JText::_($modstatusstate);?></font>
          <a href="index.php?option=com_modules&task=module.edit&id=<?php echo $moduleenabled->id;?>"><span title="<?php echo $modstatustext;?>" style="float:right;"><i class="<?php echo $modstatus;?>"></i></span></a></div>
        </div>
          <?php
          } else {
          ?>
    			<div class="span6">
              <strong class="row-title" style="margin-left:20px;"><?php echo JText::_('Daily Reading Module');?></strong>
        	</div>
          <div class="span3" style="white-space:nowrap;">
              <font color="red"><?php echo JText :: _('Not Installed');?></font>
          </div>
          <?php
        }
        ?>
			</div>
			<div class="row-fluid small">
				<div class="span6">
					<strong class="row-title" style="margin-left:20px;"><?php echo JText::_('Donations');?></strong>
				</div>
				<div class="span3">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="web@mlwebtechnologies.com">
            <input type="hidden" name="item_name" value="MLWebTechnologies - LivingWord Donations">
            <input type="hidden" name="item_number" value="MSD1">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="return" value="">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="tax" value="0">
            <input type="hidden" name="bn" value="MLWebTechnologies">
            <input type="image" src="<?php echo JURI::base();?>components/com_livingword/assets/images/donate.gif" border="0" name="submit" title="Make donations with PayPal - it's fast, free and secure!" />
            </form>
				</div>
			</div>
		</div>
</div>
    <?php
    $cstring = "";
    $JVersion = new JVersion();
    $lwParams = JComponentHelper::getParams('com_livingword');
    $lwParamsArray = $lwParams->toArray();
    foreach($lwParamsArray['params'] as $name => $value){
      $lwConfig[(string)$name] = (string)$value;
    }
		foreach ($lwConfig as $name => $value) {
      $cstring .= $name.' = '.$value.'\n';
    }
		?>
		<input type="hidden" name="lwconfigstr" id="config_content" value="<?php echo str_replace('\n',"\n",$cstring);?>" />
    <script language="javascript">
    function printconfig()
    { 
      var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,"; 
          disp_setting += "scrollbars=yes,width=650, height=480, left=100, top=25"; 
      var content_vlue = document.getElementById("config_content").value.replace(/(\r\n|\n\r|\r|\n)/g,"<br>"); 
      var docprint=window.open("","",disp_setting); 
       docprint.document.open(); 
       docprint.document.write('<html><head><title>LivingWord Configuration File</title>'); 
       docprint.document.write('</head><body onLoad="self.print()"><center><table border=1><tr><td>');          
       docprint.document.write(content_vlue);          
       docprint.document.write('</td></tr></table><br /><a href="javascript:self.close();">Close Window</a>');          
       docprint.document.write('</center></body></html>'); 
       docprint.document.close(); 
       docprint.focus(); 
    }
    function saveLWConfig2file(fcontent) {
     var fcontent = document.getElementById("config_content").value.replace(/(\r\n|\n\r|\r|\n)/g,"\r\n"); 
     var w = window.frames.w;
     if( !w ) {
      w = document.createElement( 'iframe' );
      w.id = 'w';
      w.style.display = 'none';
      document.body.insertBefore( w, null );
      w = window.frames.w;
      if( !w ) {
       w = window.open( '', '_temp', 'width=100,height=100' );
       if( !w ) {
        window.alert( 'Sorry, the file could not be created.' ); return false;
       }
      }
     }
     var d = w.document, ext = 'utf-8', name = 'LWConfig.txt';
     d.open( 'x-application/text', 'replace' );
     d.charset = 'utf-8';
     d.write( fcontent );
     d.close();
     if( d.execCommand( 'SaveAs', null, name ) ){
      window.alert( 'The file has been saved.' );
     }
     w.close();
     return false;
    }
    </script>
  <input type="hidden" name="task" value="" />
	</div>	<div class="span3">
    <div class="well well-small"><div class="module-title nav-header">Quick Links</div>	<div class="row-striped">
      <div class="row-fluid"><div class="span12"><a href="http://www.joomlacode.org/gf/project/livingword/tracker/"><i class="icon-support"></i> <span><?php echo JText::_('Support BugTracker'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="http://www.mlwebtechnologies.com/index.php?option=com_kunena"><i class="icon-comment"></i> <span><?php echo JText::_('Support Forum'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="mailto:web@mlwebtechnologies.com?subject=LivingWord%20Support%20Inquiry&body=<?php echo $supportinfo;?>"><i class="icon-mail"></i> <span><?php echo JText::_('Support Email'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="http://www.mlwebtechnologies.com"><i class="icon-home"></i> <span><?php echo JText::_('Support Website'); ?></span></a></div></div>
  		<div class="row-fluid"><div class="span12"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=utilities"><i class="icon-tools"></i> <span><?php echo JText::_('Database Utilities'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="#" onclick="javascript:printconfig();"><i class="icon-print"></i> <span><?php echo JText::_('Print Configuration'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="#" onclick="saveLWConfig2file();"><i class="icon-file"></i> <span><?php echo JText::_('Save Configuration to File'); ?></span></a></div></div>
        <?php
        $url = "http://www.mlwebtechnologies.com/update/livingword-update.xml";
        $data = file_get_contents($url);
        $xmlObj = simplexml_load_string($data);
        $xmlObj->update->version;
        $upglink = $xmlObj->update->downloads->downloadurl;
        if(trim($lwversion->getShortVersion()) < trim($xmlObj->update->version)){
          $message = JText::_('Component Update ['.$xmlObj->update->version.' Available]');
        }else{
          $message = JText::_( 'Component Update [None Available]');
        }
        ?>
      <div class="row-fluid" id="plg_quickicon_extensionupdate"><div class="span12"><a href="index.php?option=com_installer&view=update"><i class="icon-asterisk"></i> <span><?php echo $message; ?></span></a></div></div>	
      <div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_admin&view=sysinfo"><i class="icon-question-sign"></i> <span><?php echo JText::_('System Information'); ?></span></a></div></div>	
    </div>
	</div>
</div><div class="clearfix"></div><br /><br />
<div>
  <?php
  $livingwordadmin->LWfooter();
  ?>
</div>