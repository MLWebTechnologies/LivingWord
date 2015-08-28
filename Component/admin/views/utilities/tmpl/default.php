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
  jimport('joomla.html.pane');
  jimport('joomla.filesystem.file');
  $livesite = JURI::base();
  $db	= JFactory::getDBO();
  $template	= JFactory::getApplication()->getTemplate();
  $imagedir = 'templates/'.$template.'/images/menu/';
  include_once('components/com_livingword/helpers/lw_version.php');
  $lwversion = LWVersion::getInstance();
//	$livingwordadmin->LWsideBar();
  ?>
	<div class="span6">
		<div class="well well-small" style="font-size:small;"><div class="module-title nav-header">Database Table Maintenance</div><div class="row-striped">
			<div class="row-fluid small">
				<div class="span3" style="white-space:nowrap;">
      		<div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_livingword&task=optimizeLWTables" onclick="javascript:if(confirm('Do you wish to perform an optimization of the LivingWord DB tables?')){return true;}else{return false;}"><i class="icon-cogs"></i> <span><?php echo JText::_('Optimize Tables'); ?></span></a>&nbsp;&nbsp;(Used periodically to defragment DB tables)</div></div>
      		<div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_livingword&task=checkLWTables" onclick="javascript:if(confirm('Do you wish to perform a check of the LivingWord DB tables?')){return true;}else{return false;}"><i class="icon-cogs"></i> <span><?php echo JText::_('Launch Health Check'); ?></span></a>&nbsp;&nbsp;(Checks DB tables for errors)</div></div>
      		<div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_livingword&task=repairLWTables" onclick="javascript:if(confirm('Do you wish to perform a repair of the LivingWord DB tables? It is recommended that you backup the LivingWord tables prior to running this utility.')){return true;}else{return false;}"><i class="icon-cogs"></i> <span><?php echo JText::_('Repair Tables'); ?></span></a>&nbsp;&nbsp;(Repairs possibly corrupt DB table entries)</div></div>
      		<div class="row-fluid"><div class="span12"><a href="/administrator/index.php?option=com_livingword&task=backupLWTables" onclick="javascript:if(confirm('Do you wish to perform a backup of the LivingWord DB tables?')){return true;}else{return false;}"><i class="icon-cogs"></i> <span><?php echo JText::_('Launch Backup'); ?></span></a>&nbsp;&nbsp;(Backup DB table entries to text file)</div></div>
         </div>
         </div>
       </div>
    </div>
  </div>
  <div class="span4">
    <div class="well well-small"><div class="module-title nav-header">Quick Links</div>	<div class="row-striped">
      <div class="row-fluid"><div class="span12"><a href="http://www.joomlacode.org/gf/project/livingword/tracker/"><i class="icon-support"></i> <span><?php echo JText::_('Support BugTracker'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="http://www.mlwebtechnologies.com/index.php?option=com_kunena"><i class="icon-comment"></i> <span><?php echo JText::_('Support Forum'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="mailto:web@mlwebtechnologies.com?subject=LivingWord%20Support%20Inquiry&body=<?php echo $supportinfo;?>"><i class="icon-mail"></i> <span><?php echo JText::_('Support Email'); ?></span></a></div></div>
      <div class="row-fluid"><div class="span12"><a href="http://www.mlwebtechnologies.com"><i class="icon-home"></i> <span><?php echo JText::_('Support Website'); ?></span></a></div></div>
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
</div>
</div>
<div class="clearfix"></div><br /><br />
  <?php
  $livingwordadmin->LWFooter();
?>