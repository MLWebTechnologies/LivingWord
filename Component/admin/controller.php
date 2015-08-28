<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
/**
 * LivingWord Component Controller
 *
 */
class LivingwordController extends JControllerLegacy
{
	protected $default_view = 'livingword';
	public function display($cachable = false, $urlparams = false)
    {
  //    $this->checkLWDB();
  		$view   = $this->input->get('view', 'livingword');
  		$layout = $this->input->get('layout', 'default');
      if($view == 'plans') JRequest::setVar('view', 'manageplans' );
      if($view == 'links') JRequest::setVar('view', 'managelinks' );
  		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'livingword'));
  		parent::display();
    }
  function checkLWDB( $option='com_livingword' ){
    global $db;
    $db	=& JFactory::getDBO();
    $db->setQuery("SHOW COLUMNS FROM #__livingword LIKE 'startdate'");
    $lwtable_nm =  $db->loadObjectList();
    if($lwtable_nm[0]->Type != 'date'){
      $db->setQuery( "ALTER TABLE #__livingword MODIFY startdate date DEFAULT '0000-00-00' NOT NULL");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
  		}
     }
    $db->setQuery("SHOW COLUMNS FROM #__livingword LIKE 'emailsent'");
    $lwtable_nm1 =  $db->loadObjectList();
    if(count($lwtable_nm1) >0){
      $db->setQuery( "ALTER TABLE #__livingword CHANGE emailsent planview INTEGER");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
      }
		}
  }
  function manage_books( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'managebooks' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'managebooks'));
  	parent::display();
  }
  function manage_lang( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'managelang' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'managelang'));
  	parent::display();
  }
  function manage_link( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'managelink' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'managelink'));
  	parent::display();
  }
  function manage_sub( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'managesub' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'managesub'));
  	parent::display();
  }
  function manage_css( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'managecss' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'managecss'));
  	parent::display();
  }
  function manage_plans( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'manageplans' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'manageplans'));
  	parent::display();
  }
  function manage_plan( $option='com_livingword' )
  {
  	JRequest::setVar('view', 'manageplan' );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'manageplan'));
  	parent::display();
  }
  function addplan() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editplan' );
		JRequest::setVar( 'edit', false );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editplan'));
  	parent::display();
  }
  function editplan() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editplan' );
		JRequest::setVar( 'edit', true );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editplan'));
  	parent::display();
  }
  function addreading() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editreading' );
		JRequest::setVar( 'edit', false );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editreading'));
  	parent::display();
  }
  function editreading() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editreading' );
		JRequest::setVar( 'edit', true );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editreading'));
  	parent::display();
  }
  function addlink() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editlink' );
		JRequest::setVar( 'edit', false );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editlink'));
  	parent::display();
  }
  function editlink() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editlink' );
		JRequest::setVar( 'edit', true );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editlink'));
  	parent::display();
  }
  function addlang() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editlang' );
		JRequest::setVar( 'edit', false );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editlang'));
  	parent::display();
  }
  function editlang() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editlang' );
		JRequest::setVar( 'edit', true );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editlang'));
  	parent::display();
  }
  function editbook() {
		JRequest::setVar( 'hidemainmenu', 1 );
  	JRequest::setVar('view', 'editbook' );
		JRequest::setVar( 'edit', true );
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'editbook'));
  	parent::display();
  }
  function utilities($option='com_livingword') {
    JRequest::setVar('view', 'utilities');
		LivingWordHelper::addSubmenu(JRequest::getCmd('view', 'utilities'));
    parent::display();
  }
  function optimizeLWTables( $option='com_livingword' ){
    global $db,$livingwordadmin;
    $db	=& JFactory::getDBO();
    $dbcmds = array($db->name.'_data_seek',$db->name.'_num_rows',$db->name.'_fetch_assoc');
    $sql = "OPTIMIZE TABLE #__livingword, #__livingword_links, #__livingword_plans, #__livingword_plans_details";
    $db->setQuery($sql);
		if (!$db->query()) {
		 return JError::raiseWarning( 500, $db->stderr() );
		}
    $rs_status = $db->query();
    $dbcmds[0]($rs_status, $dbcmds[1]($rs_status)-1);
    $row_status = $dbcmds[2]($rs_status);
    $livingwordadmin->LWRedirect("index.php?option=$option&task=utilities", "LivingWord database tables have been optimized.  (".ucfirst($row_status['Msg_type']).': '.$row_status['Msg_text'].')' );
    }
  function checkLWTables( $option='com_livingword' ){
    global $db,$livingwordadmin;
    $db	=& JFactory::getDBO();
    $dbcmds = array($db->name.'_data_seek',$db->name.'_num_rows',$db->name.'_fetch_assoc');
    $app =& JFactory::getApplication();
    $sql = "CHECK TABLE #__livingword, #__livingword_links, #__livingword_plans, #__livingword_plans_details MEDIUM";
    $db->setQuery($sql);
		if (!$db->query()) {
		 return JError::raiseWarning( 500, $db->stderr() );
		}
    $rs_status = $db->query();
    $dbcmds[0]($rs_status, $dbcmds[1]($rs_status)-1);
    $row_status = $dbcmds[2]($rs_status);
    $app->redirect("index.php?option=$option&task=utilities", "LivingWord database tables have been checked.  (".ucfirst($row_status['Msg_type']).': '.$row_status['Msg_text'].')' );
    }
  function repairLWTables( $option='com_livingword' ){
    global $db,$livingwordadmin;
    $db	=& JFactory::getDBO();
    $dbcmds = array($db->name.'_data_seek',$db->name.'_num_rows',$db->name.'_fetch_assoc');
    $sql = "REPAIR TABLE #__livingword, #__livingword_links, #__livingword_plans, #__livingword_plans_details";
    $db->setQuery($sql);
		if (!$db->query()) {
		 return JError::raiseWarning( 500, $db->stderr() );
		}
    $rs_status = $db->query();
    $dbcmds[0]($rs_status, $dbcmds[1]($rs_status)-1);
    $row_status = $dbcmds[2]($rs_status);
    $livingwordadmin->LWRedirect("index.php?option=$option&task=utilities", "LivingWord database tables have been repaired.  (".ucfirst($row_status['Msg_type']).': '.$row_status['Msg_text'].')' );
    }
  function backupLWTables( $option='com_livingword', $locks=true, $compress=false, $drop_tables=true, $download=true ){
    global $db,$livingwordadmin;
    $db	=& JFactory::getDBO();
    $dbcmds = array($db->name.'_data_seek',$db->name.'_num_rows',$db->name.'_fetch_assoc',$db->name.'_fetch_row');
    $app =& JFactory::getApplication('site');
    $fpath = 'components'.DS.'com_livingword'.DS;
    $filename = ($compress ? 'livingword.sql.gz' : 'livingword.sql');
    $fname = $fpath.$filename;
    $value = "";
    $tablestr = 'livingword,livingword_links,livingword_plans,livingword_plans_details';
    $tables = preg_split('/[,]/',$tablestr, -1, PREG_SPLIT_NO_EMPTY);
    $null_values = array( '0000-00-00', '00:00:00', '0000-00-00 00:00:00');
		$compress ? $fp = gzopen($fname, 'w9') : $fp = fopen($fname, 'w');   
		$sql = "LOCK TABLES #__livingword WRITE, #__livingword_links WRITE, #__livingword_plans WRITE, #__livingword_plans_details WRITE";
    $db->setQuery($sql);
		if (!$db->query()) {
		 return JError::raiseWarning( 500, $db->stderr() );
		}
		$value .= '# '."\n";
		$value .= '# LivingWord Database Table Dump'."\n";
		$value .= '# Host: ' . $app->getCfg( 'sitename' ) . "\n";
		$value .= '# Generated: ' . date('M j, Y') . ' at ' . date('H:i:s') . "\n";
		$value .= '# MySQL version: ' . $db->getVersion() . "\n";
		$value .= '# PHP version: ' . phpversion() . "\n";
		$value .= '# ' . "\n";
		$value .= '# Database: `' . $app->getCfg( 'db' ) . '`' . "\n";
		$value .= '# Tables: `' . $tablestr . '`' . "\n";
		$value .= '# ' . "\n\n\n";
    foreach($tables as $table){
  		if ($drop_tables) {
  			$value .= 'DROP TABLE IF EXISTS `#__'.$table.'`;' . "\n";
  		}
      $sql = "SHOW CREATE TABLE #__".$table;
      $db->setQuery($sql);
  		if (!($result = $db->query())) {
  		 return JError::raiseWarning( 500, $db->stderr() );
  		}
  		$row = $dbcmds[2]($result);
  		$value .= $row['Create Table'].';';
      $value .= "\n\n";
      $sql = "SELECT * FROM #__".$table;
      $db->setQuery($sql);
  		if (!($result = $db->query())) {
  		 return JError::raiseWarning( 500, $db->stderr() );
  		}
  	  $num_rows = $dbcmds[1]($result);
    	if ($num_rows > 0) {
    		if ($locks) {
    			$value .= 'LOCK TABLES #__'.$table.' WRITE;'."\n";
    		}
     		$value .= 'INSERT INTO #__'.$table;
    		$row = $dbcmds[2]($result);
    		$value .= ' (`' . implode('`,`', array_keys($row)) . '`)';
    		$value .= ' VALUES ';
    		$fields = count($row);
    		$dbcmds[0]($result, 0);
    		$value .= "\n";
    		if ($fp) {
    			$compress ? gzwrite($fp, $value) : fwrite ($fp, $value);
    		}
     		$j=0;
    		$size = 0;
    		while ($row = $dbcmds[3]($result))
    		{
    			if ($fp)
    			{
    				$i = 0;
    				$compress ? $size += gzwrite($fp, '(') : $size += fwrite ($fp, '(');
    				for($x =0; $x < $fields; $x++)
    				{
    					if (!isset($row[$x]) || in_array($row[$x], $null_values)) {
    						$row[$x] = 'NULL';
    					} else {
    						$row[$x] = '\'' . str_replace("\n","\\n",addslashes($row[$x])) . '\'';
    					}
    					if ($i > 0)
    					{
    						$compress ? $size += gzwrite($fp, ',') : $size += fwrite ($fp, ",");
    					}
    					$compress ? $size += gzwrite($fp, $row[$x]) : $size += fwrite ($fp,  $row[$x]);
    					$i++;
    				}
    				$compress ? $size += gzwrite($fp, ')') : $size += fwrite ($fp, ')');
    				if ($j+1 < $num_rows && $size < 900000 )
    				{
    					$compress ? $size += gzwrite($fp, ",\n") : $size += fwrite ($fp, ",\n");
    				}	else {
    					$size = 0;
    					$compress ? gzwrite($fp, ';' . "\n\n\n") : fwrite ($fp, ';' . "\n\n\n");
    					if ($j+1 < $num_rows)
    					{
    						$compress ? gzwrite($fp, $insert) : fwrite ($fp, $insert);
    					} elseif($locks) {
    						$compress ? gzwrite($fp, 'UNLOCK TABLES;' . "\n") : fwrite ($fp, 'UNLOCK TABLES;' . "\n");
    					}
    				}
           $j++;
          }
         }
        $value = "";
      }
    }
		$sql = "UNLOCK TABLES";
    $db->setQuery($sql);
		if (!$db->query()) {
		 return JError::raiseWarning( 500, $db->stderr() );
		}
		$compress ? gzclose($fp) : fclose($fp);
		$fp = fopen($fname, 'rb');
		if ($fp && $download) {
   			$session =& JFactory::getSession();
        if(count($app->getMessageQueue())) $session->set('application.queue', array()); 
        $app->enqueueMessage("LivingWord database tables have been backed up to location provided.", 'message');
    		if(count($app->getMessageQueue()))
    		{
    			$session->set('application.queue', $app->getMessageQueue());
    		}
        if(preg_match("/MSIE/",$_SERVER['HTTP_USER_AGENT'])){
          header("Content-type: application/octet-stream;");
      		header('Content-disposition: attachment; filename='.$filename.';');
      		header('Pragma: no-cache;');
      		header('Expires: 0;');
//          header("Location:index.php?option=com_livingword&task=utilities");
        } else { 
          header("Refresh:0; URL=index.php?option=com_livingword&task=utilities");
          header("Content-type: application/octet-stream;");
      		header('Content-disposition: attachment; filename='.$filename.';');
      		header('Pragma: no-cache;');
      		header('Expires: 0;');
        } 
  		while ($value = fread($fp,8192))
  		{
  			echo $value;
  			unset ($value);
  		}
  		$compress ? gzclose($fp) : fclose($fp);
  		@unlink ($fname);
    }
  }
}
?>