<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
defined('_JEXEC') or die( 'Restricted access' );
//jimport('joomla.application.component.controller');
class LivingWordControllerLivingWord extends JControllerLegacy
{
	function __construct( $default = array() )
	{
		parent::__construct( $default );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'applylink', 'savelink' );
		$this->registerTask( 'unpublishlink',	'publishlink' );
		$this->registerTask( 'unpublishplan',	'publishplan' );
		$this->registerTask( 'unapprovesub',	'approvesub' );
	}
  function manageplan($option='com_livingword'){
    global $livingwordadmin;
    $livingwordadmin->LWRedirect('index.php?option='.$option.'&task=manageplan');
  }
  function cancelSettings( $option='com_livingword'){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option );
  }
  function cancel(){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php' );
  }
  function canceleditbook( $option='com_livingword'){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_books' );
  }
  function canceleditlang( $option='com_livingword'){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_lang' );
  }
  function canceleditplan( $option='com_livingword'){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_plans' );
  }
  function canceleditreading( $option='com_livingword'){
    global $livingwordadmin;
    $cid = JRequest::getVar( 'planid', '', 'post', 'int' );
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_plan&cid='.$cid );
  }
  function saveCss( $option='com_livingword' ) {
    global $livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
  	$config_css = JRequest::getVar( 'config_css', null, 'post', 'string' );
  		$configcss = str_replace("[CR][NL]","\n",$config_css);
  		$configcss = str_replace("[ES][SQ]","'",$configcss);
  		$configcss = nl2br($configcss);
  		$configcss = str_replace("<br />"," ",$configcss);
  		$filename = JPATH_ROOT.'/components/com_livingword/assets/css/livingword.css';
      file_put_contents($filename, $configcss);
    $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_css", "Changes in CSS have been saved." );
  }
  function saveLang( $option='com_livingword' ) {
    global $livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
    $foldername = JRequest::getVar( 'config_langfolder', null, 'post', 'string' );
    $filename = JRequest::getVar( 'config_langfile', null, 'post', 'string' );
  	$config_lang = JRequest::getVar( 'config_lang', null, 'post', 'string' );
  		$configlang = str_replace("[CR][NL]","\n",$config_lang);
  		$configlang = str_replace("[ES][SQ]","'",$configlang);
  		$configlang = nl2br($configlang);
  		$configlang = str_replace("<br />"," ",$configlang);
  		$langfilepath = JPATH_ROOT.'/language/'.$foldername;
      if(!is_dir($langfilepath) || !file_exists($langfilepath.'/'.$foldername.'.xml')) $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Please install the corresponding Joomla language extension for ".$foldername.".com_livingword.ini" );
 			$ldata = JApplicationHelper::parseXMLLangMetaFile($langfilepath.'/'.$foldername.'.xml');
  			if (!is_array($ldata)) {
  				$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Please install the valid Joomla language extension for ".$foldername.".com_livingword.ini" );
  			}
      $langfilename = $langfilepath.'/'.$foldername.".com_livingword.ini";
  		file_put_contents($langfilename, $configlang);
    $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Changes in the language file have been saved." );
  }
  function saveBook( $option='com_livingword' ) {
    global $livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
    $filename = JRequest::getVar( 'config_langbookfile', null, 'post', 'string' );
    $lf = preg_split("#[\.]#",$filename,-1,PREG_SPLIT_NO_EMPTY);
    $lffolder = $lf[0];
    $langfilename = JPATH_ROOT.'/components/com_livingword/assets/language/'.$lffolder.'/'.$filename;
  	$lang_book = JRequest::getVar( 'lang_book', null, 'post', 'string' );
  		$lang_book = str_replace("[CR][NL]","\n",$lang_book);
  		$lang_book = str_replace("[ES][SQ]","'",$lang_book);
  		$lang_book = nl2br($lang_book);
  		$lang_book = str_replace("<br />"," ",$lang_book);
 		file_put_contents($langfilename, $lang_book);
    $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_books", "Changes in the Bible book language file have been saved." );
  }
  function resetCss( $option='com_livingword' ) {
    global $livingwordadmin;
  		$savfilename = JPATH_ROOT.'/components/com_livingword/assets/css/livingword.sav';
  		$savfilecontent = file_get_contents($savfilename);
  		$replacecss = str_replace("[CR][NL]","\n",$savfilecontent);
  		$replacecss = str_replace("[ES][SQ]","'",$replacecss);
  		$replacecss = nl2br($replacecss);
  		$replacecss = str_replace("<br />"," ",$replacecss);
  		$filename = JPATH_ROOT.'/components/com_prayercenter/assets/css/livingword.css';
  		file_put_contents($filename, $replacecss);
    $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_css", "CSS has been reset to default settings." );
  }
  function resetLang( $option='com_livingword' ) {
    global $livingwordadmin;
   	$savfilename = JPATH_ROOT.'/administrator/components/com_livingword/langsource/j25/en-GB.com_prayercenter.ini';
		$savfilecontent = file_get_contents($savfilename);
		$replacelang = str_replace("[CR][NL]","\n",$savfilecontent);
		$replacelang = str_replace("[ES][SQ]","'",$replacelang);
		$replacelang = nl2br($replacelang);
		$replacelang = str_replace("<br />"," ",$replacelang);
		$filename = JPATH_ROOT.'/language/en-GB/en-GB.com_livingword.ini';
		file_put_contents($filename, $replacelang);
    $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "The LivingWord English language file has been reset to default settings." );
  }
  function remove_link( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
  	$db		=& JFactory::getDBO();
  	if (count( $cid )) {
  		$cids = implode( ',', $cid );
  		$db->setQuery( "DELETE FROM #__livingword_links WHERE id IN ($cids)" );
  		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  		}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_link" );
  }
  function remove_plan( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		$cid	= JRequest::getVar( 'cid', array(0), '', 'array' );
  	$db		=& JFactory::getDBO();
  	if (count( $cid )) {
  		$cids = implode( ',', $cid );
  		$sql = "DELETE FROM #__livingword_plans, #__livingword_plans_details "
      . "\nUSING #__livingword_plans INNER JOIN #__livingword_plans_details "
      . "\nWHERE #__livingword_plans.id IN ($cids) AND #__livingword_plans_details.plan=#__livingword_plans.name";
  		$db->setQuery( $sql );
  		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  		}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_plans" );
  }
  function remove_reading( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		$cid	= JRequest::getVar( 'cid', array(0), '', 'array' );
  	$db		=& JFactory::getDBO();
  	if (count( $cid )) {
  		$cids = implode( ',', $cid );
  		$db->setQuery( "DELETE FROM #__livingword_plans_details WHERE id IN ($cids)" );
  		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  		}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_plan" );
  }
  function remove_sub( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
  	$db		=& JFactory::getDBO();
  	if (count( $cid )) {
  		$cids = implode( ',', $cid );
  		$db->setQuery( "DELETE FROM #__livingword WHERE id IN ($cids)" );
  		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  		}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_sub" );
  }
  function canceleditlink( $option='com_livingword'){
    global $livingwordadmin;
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_link' );
  }
  function publishlink( $option='com_livingword' ) {
    global $db,$livingwordadmin;
 		$db	= & JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
 		preg_match('/\.(\w+)$/',JRequest::getVar( 'task', null, 'method' ),$action);
    if($action[1] == 'publishlink'){
      $publish = true;
      } else {
      $publish = false;
      }
    $count = count($cid);
  	if (!is_array( $cid ) || $count < 1 || $cid[0] == 0) {
    	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_link", 'Select an item to '.$action );
  	}
    for ($i = 0; $i < $count; $i++) {
    	$db->setQuery( "UPDATE #__livingword_links SET published='".(int)$publish."'"
    	. "\nWHERE id='".(int)$cid[$i]."'" );
    	if (!$db->query()) {
  			return JError::raiseWarning( 500, $row->getError() );
    	}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_link" );
  	}
  function publishplan( $option='com_livingword' ) {
    global $db,$livingwordadmin;
 		$db	= & JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
 		preg_match('/\.(\w+)$/',JRequest::getVar( 'task', null, 'method' ),$action);
    if($action[1] == 'publishplan'){
      $publish = true;
      } else {
      $publish = false;
      }
    $count = count($cid);
  	if (!is_array( $cid ) || $count < 1 || $cid[0] == 0) {
    	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_plans", 'Select an item to '.$action );
  	}
    for ($i = 0; $i < $count; $i++) {
    	$db->setQuery( "UPDATE #__livingword_plans SET published='".(int)$publish."'"
    	. "\nWHERE id='".(int)$cid[$i]."'" );
    	if (!$db->query()) {
  			return JError::raiseWarning( 500, $row->getError() );
    	}
  	}
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_plans" );
 	}
  function approvesub( $option='com_livingword' ) {
    global $db, $livingwordadmin;
    $db	=& JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
 		preg_match('/\.(\w+)$/',JRequest::getVar( 'task', null, 'method' ),$action);
    if($action[1] == 'approvesub'){
      $approve = true;
      } else {
      $approve = false;
      }
    $count = count($cid);
  	if (!is_array( $cid ) || $count < 1 || $cid[0] == 0) {
    	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_sub", 'Select an item to '.$action[1] );
  	}
    for ($i = 0; $i < $count; $i++) {
    	$db->setQuery( "UPDATE #__livingword SET email='".(int)$approve."'"
    	. "\nWHERE id=$cid[$i]" );
    	if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
    	}
    }
  	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_sub" );
  }
  function savelink( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
  	$db = JFactory::getDBO();
		$postarray	= JRequest::get('post');
    $post = $postarray['jform'];
		$id	= JRequest::getVar( 'cid', null, 'post', 'array' );
    if($id[0] > 0){
     	$save = "UPDATE #__livingword_links SET name=".$db->quote(addslashes($post['name']),false).", url=".$db->quote($post['url'],false).", catid='".(int)$post['catid']."', published='".(int)$post['published']."', ordering='".(int)$post['ordering']."', target='".(int)$post['target']."' WHERE id='".(int)$id[0]."'";
    } else {
      $save = "INSERT INTO #__livingword_links (id,name,url,catid,published,target,checked_out,checked_out_time,ordering) VALUES ('',".$db->quote(addslashes($post['name']),false).",".$db->quote($post['url'],false).",'".(int)$post['catid']."','".(int)$post['published']."','".(int)$post['target']."','','','".(int)$post['ordering']."')";
    }
    $db->setQuery($save);
  	if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  	}
		$task = JRequest::getCmd( 'task' );
		switch ($task)
		{
			case 'applylink':
      	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=editlink&eid=".$id[0] );
				break;
			case 'savelink':
			default:
      	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_link" );
				break;
		}
  }
  function savereading( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
  	$db =& JFactory::getDBO();
		$edit	= JRequest::getVar( 'edit', true, 'post', 'int' );
    $descrip = JRequest::getVar('descrip',null,'post','string',JREQUEST_ALLOWHTML);
    $descrip = addslashes($descrip);
		$postarray	= JRequest::get('post');
    $post = $postarray['jform'];
		$reading = $post['readingbook0'].' '.$post['reading0'];
    if(!empty($post['readingbook1'])) $reading .= ';'.$post['readingbook1'].' '.$post['reading1'];
    if(!empty($post['readingbook2'])) $reading .= ';'.$post['readingbook2'].' '.$post['reading2'];
    if(!empty($post['readingbook3'])) $reading .= ';'.$post['readingbook3'].' '.$post['reading3'];
		if(isset($post['audio0'])) $audio = $post['audio0'];
    if(!empty($post['audio1'])) $audio .= ','.$post['audio1'];
    if(!empty($post['audio2'])) $audio .= ','.$post['audio2'];
    if(!empty($post['audio3'])) $audio .= ','.$post['audio3'];
		if(!isset($post['audio0'])) $audio = '';
    if(!isset($post['figure'])) $post['figure'] = '';
    if(!isset($descrip)) $descrip = '';
    if($edit){
   	  $save = "UPDATE #__livingword_plans_details SET reading=".$db->quote($reading,false).", audio=".$db->quote($audio,false).", figure=".$db->quote($post['figure'],false).", descrip=".$db->quote($descrip,false)." WHERE id='".(int)$post['id']."'";
    } else {
      $save = "INSERT INTO #__livingword_plans_details (id,plan,reading,audio,figure,descrip) VALUES ('',".$db->quote($post['plan'],false).",".$db->quote($reading,false).",".$db->quote($audio,false).",".$db->quote($post['figure'],false).",".$db->quote($descrip,false).")";
    }
    $db->setQuery($save);
  	if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  	}
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_plan&cid='.$post['planid'] );
  }
  function saveplan( $option='com_livingword' ) {
    global $db,$livingwordadmin;
		JRequest::checkToken() or jexit( 'Invalid Token' );
  	$db =& JFactory::getDBO();
		$edit	= JRequest::getVar( 'edit', true, 'post', 'int' );
    $message = JRequest::getVar('message',null,'post','string',JREQUEST_ALLOWHTML);
		$post	= JRequest::get('post');
    $post = $postarray['jform'];
    if($edit){
   	  $save = "UPDATE #__livingword_plans SET name=".$db->quote($post['name'],false).", description=".$db->quote(addslashes($post['description']),false).", message=".$db->quote(addslashes($message),false).", audio='".(int)$post['audio']."', newtest='".(int)$post['newtest']."', published='".(int)$post['published']."', ordering='".(int)$post['ordering']."' WHERE id='".(int)$post['id']."'";
    } else {
      $save = "INSERT INTO #__livingword_plans (id,name,description,message,audio,newtest,published) VALUES ('',".$db->quote($post['name'],false).",".$db->quote(addslashes($post['description']),false).",".$db->quote(addslashes($message),false).",'".(int)$post['audio']."','".(int)$post['newtest']."','".(int)$post['published']."')";
    }
    $db->setQuery($save);
  	if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
  	}
  	$row->checkin( $post['id'] );
  	$livingwordadmin->LWRedirect( 'index.php?option='.$option.'&task=manage_plans' );
  }
  function uploadLangfile( $option='com_livingword' ) {
    global $livingwordadmin;
    if((!empty($_FILES['uploadedlangfile'])) && ($_FILES['uploadedlangfile']['error'] == 0)) {
      $filename = basename($_FILES['uploadedlangfile']['name']);
      $foldername = substr($filename,0,-19);
      $ext = substr($filename, strrpos($filename, '.') + 1);
      if (($ext == "ini") && ($_FILES['uploadedlangfile']['size'] < 350000)) {
        $newname = JPATH_ROOT.'/language/'.$foldername.'/'.$filename;
        if (!file_exists($newname)) {
          if ((move_uploaded_file($_FILES['uploadedlangfile']['tmp_name'],$newname))) {
          	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "The file has been saved as: ".$newname );
          } else {
           	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Error: A problem occurred during file upload!" );
          }
        } else {
        	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Error: File ".$_FILES['uploadedlangfile']['name']." already exists" );
        }
      } else {
         $livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang","Error: Only .ini files under 350Kb are accepted for upload");
      }
    } else {
    	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "Error: No file uploaded" );
    }
  }
  function deleteLangfile( $option='com_livingword' )
  {
    global $livingwordadmin;
    $fileArray = JRequest::getVar( 'fid', null, 'method', 'array' );
    $file = $fileArray[0];
    $lang_path = JPATH_ROOT.'/language/';
    	if (count( $file )) {
    		unlink($lang_path.$file);
    	}
    	$livingwordadmin->LWRedirect( "index.php?option=".$option."&task=manage_lang", "File has been deleted." );
  }
}
?>