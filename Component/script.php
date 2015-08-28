<?php
/**
* @version $Id: script.php,v 3.0x
* @package LivingWord
*/
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
class com_livingwordInstallerScript
{
  private $release = '3.0.0';
  private $params;
  function install($parent)
  {
    $this->params = $this->getParams();
  }
  function uninstall($parent)
  {
  }
  function update($parent)
  {
    $this->params = $this->getParams();
//    $parent->getParent()->setRedirectURL('index.php?option=com_livingword');
  }
  function preflight($type,$parent)
  {
    $JVersion = new JVersion();
    if(version_compare($JVersion->getShortVersion(), '3.0', 'lt')){
      JError::raiseWarning(null, 'Cannot install com_livingword in a Joomla release prior to 3.0');
      return false;
    }
    if($type == 'update'){
      include_once('components/com_livingword/helpers/lw_version.php');
      $lwversion = & LWVersion::getInstance();
      $oldrelease = $lwversion->getShortVersion();
      $rel = $oldrelease.' to '.$this->release;
      if(version_compare($this->release, $oldrelease, 'le')){
        JError::raiseWarning(null, 'Incorrect version sequence.  Cannot upgrade '.$rel);
        return false;
      } else {
        $rel = $this->release;
      }
    }
  }
  function getParams(){
    $xml = JFactory::getXML(JPATH_ROOT.'/administrator/components/com_livingword/config.xml');
    $ini = array();
    $fieldsets = $xml->fields->fieldset;
    $fieldscount = count($fieldsets);
    for($i=0;$i<$fieldscount;$i++){
    	if( ! count($fieldsets[$i]->children())) {
    		return null;
    	}
    	foreach ($fieldsets[$i] as $field)
    	{
				if (($name = $field->attributes()->name) === null) {
					continue;
				}
				if (($value = $field->attributes()->default) === null) {
					continue;
				}
    		if ($name != '@spacer') {
      		$ini[(string) $name] = (string) $value;
    		}
      }
    }
    return $ini;
  }
  function setParams($param_array){
    if(count($param_array) > 0){
      $db = JFactory::getDbo();
      foreach($param_array as $name => $value){
        $params['params'][(string)$name] = (string)$value;
      }
      $paramString = json_encode($params);
      $db->setQuery('UPDATE #__extensions SET params='.$db->quote($paramString).' WHERE element="com_livingword"');
      $db->query();
    }
  }
  function setRules($param_array){
    if(count($param_array) > 0){
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('a.rules');
      $query->from('#__assets AS a');
      $query->group('a.id, a.rules, a.lft');
      $query->where('(a.name = ' . $db->quote('com_livingword')  . ')');
      $db->setQuery($query);
      $result = $db->loadColumn();
      if($result[0] == '{}'){
        $rules = json_encode(array('livingword.home'=>array(1=>1),'livingword.settings'=>array(2=>1,8=>1),'livingword.links'=>array(1=>1),'livingword.tools'=>array(1=>1)));
        $db->setQuery("UPDATE #__assets SET rules=".$db->quote($rules)." WHERE name='com_livingword'");
        $db->query();
      }
    }
  }
  function addLWCategory(){
    // Create categories for our component
    $basePath = JPATH_ADMINISTRATOR . '/components/com_categories';
    require_once $basePath . '/models/category.php';
    $config = array( 'table_path' => $basePath . '/tables');
    $catmodel = new CategoriesModelCategory( $config);
    $catData = array( 'id' => 0, 'parent_id' => 0, 'level' => 1, 'path' => 'uncategorized', 'extension' => 'com_livingword'
    , 'title' => 'Uncategorized', 'alias' => 'uncategorized', 'description' => '<p>This is the default LivingWord link category</p>', 'published' => 1, 'language' => '*');
    $catData1 = array( 'id' => 0, 'parent_id' => 0, 'level' => 1, 'path' => 'Just For Kids', 'extension' => 'com_livingword'
    , 'title' => 'Just For Kids', 'alias' => 'Just For Kids', 'description' => '<p>This is the LivingWord Just For Kids link category</p>', 'published' => 1, 'language' => '*');
    $catData2 = array( 'id' => 0, 'parent_id' => 0, 'level' => 1, 'path' => 'Bible Study', 'extension' => 'com_livingword'
    , 'title' => 'Bible Study', 'alias' => 'Bible Study', 'description' => '<p>This is the LivingWord Bible Study link category</p>', 'published' => 1, 'language' => '*');
    $catData3 = array( 'id' => 0, 'parent_id' => 0, 'level' => 1, 'path' => 'For Teens', 'extension' => 'com_livingword'
    , 'title' => 'For Teens', 'alias' => 'For Teens', 'description' => '<p>This is the LivingWord For Teens link category</p>', 'published' => 1, 'language' => '*');
    $status = $catmodel->save( $catData);
    $status = $catmodel->save( $catData1);
    $id1 = $catmodel->getItem()->id;
    $status = $catmodel->save( $catData2);
    $id2 = $catmodel->getItem()->id;
    $status = $catmodel->save( $catData3);
    $id3 = $catmodel->getItem()->id;
    if(!$status) 
     {
      JError::raiseWarning(500, JText::_('Unable to create LivingWord categories!'));
     }
    $db = JFactory::getDbo();
    $db->setQuery("SHOW COLUMNS FROM #__livingword_links LIKE 'category'");
    $lwtable_nm1 =  $db->loadObjectList();
    if(count($lwtable_nm1) >0){
      $db->setQuery( "UPDATE #__livingword_links SET category=".(int)$id1." WHERE category='Just For Kids'");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
      }
      $db->setQuery( "UPDATE #__livingword_links SET category=".(int)$id2." WHERE category='Bible Study'");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
      }
      $db->setQuery( "UPDATE #__livingword_links SET category=".(int)$id3." WHERE category='For Teens'");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
      }
      $db->setQuery( "ALTER TABLE #__livingword_links CHANGE category catid INTEGER");
  		if (!$db->query()) {
  			return JError::raiseWarning( 500, $db->stderr() );
      }
		}
  }
	function activatePlugin() {
		$db = JFactory::getDBO();
		$sql = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND folder='system' AND element='livingword'";
		$db->setQuery($sql);
		if(!$db->query()) {
			JError::raiseWarning(66508, JText::_('Could not publish LivingWord plugin'));
		}
	}
	function installModule() {
		$folder = JPATH_ADMINISTRATOR.'/components/com_livingword/module/j30/';
    $installedfolder = JPATH_ROOT.'/modules/mod_livingword/';
    $filearray = JFolder::files($folder);
		$status = true;
    $installed = JFolder::exists($installedfolder); 
		if(count($filearray)>0) {
			$installer = new JInstaller();
			if($installed) {
        if(!$installer->update($folder)) {
				  $status = false;
			 }
      } else {
        if(!$installer->install($folder)) {
  				$status = false;
        }
      }
		}
	 return $status;
	}
	function installPlugin() {
		$folder = JPATH_ADMINISTRATOR.'/components/com_livingword/plugin/j30/';
    $installedfolder = JPATH_ROOT.'/plugins/system/livingword/';
    $filearray = JFolder::files($folder);
		$status = true;
    $installed = JFolder::exists($installedfolder); 
		if(count($filearray)>0) {
			$installer = new JInstaller();
			if($installed) {
        if(!$installer->update($folder)) {
				  $status = false;
			 }
      } else {
        if(!$installer->install($folder)) {
  				$status = false;
        }
      }
		}
	 return $status;
	}
	function updatePlans() {
		$db = JFactory::getDBO();
    $db->setQuery("SELECT * FROM #__livingword_plans WHERE name='comp'");
    $sqlchk = $db->loadObjectList();
    if($sqlchk[0]->description != 'COMPPLAN'){
      $sql1 = "UPDATE #__livingword_plans SET description='NEWTESTPLAN', message='NEWTESTMSG' WHERE name='newtest'";
      $sql2 = "UPDATE #__livingword_plans SET description='COMPPLAN', message='COMPMSG' WHERE name='comp'";
      $sql3 = "UPDATE #__livingword_plans SET description='THRUPLAN', message='THRUMSG' WHERE name='ttb'";
      $sql4 = "UPDATE #__livingword_plans SET description='BIOPLAN', message='BIOMSG' WHERE name='bio'";
      $sql5 = "UPDATE #__livingword_plans SET description='SURVPLAN', message='SURVMSG' WHERE name='surv'";
      $sql6 = "UPDATE #__livingword_plans SET description='CHRONPLAN', message='CHRONMSG' WHERE name='chron'";
      $sql7 = "UPDATE #__livingword_plans SET description='ONTPPLAN', message='ONTPMSG' WHERE name='ontp'";
      $sql8 = "UPDATE #__livingword_plans SET description='OLDTESTPLAN', message='OLDTESTMSG' WHERE name='oldtest'";
      $sqlarray = array($sql1,$sql2,$sql3,$sql4,$sql5,$sql6,$sql7,$sql8,);
      foreach($sqlarray as $sql){
        $db->setQuery($sql);
    		if(!$db->query()) {
    			JError::raiseWarning(66508, JText::_('Could not update LivingWord Plans'));
    		}
      }
	  }
  }
  function updateLWDB( $option='com_livingword' ){
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
  function postflight($type,$parent)
  {
    $JVersion = new JVersion();
    $this->updatePlans();
		$installPlugin = $this->installPlugin();
 		if(!$installPlugin) {
 			JError::raiseWarning(66508, JText::_('Could not install LivingWord plugin. Uninstall any previous versions and install manually.'));
 		} else {
      $this->activatePlugin();
    }
		$installModule = $this->installModule();
 		if(!$installModule) {
 			JError::raiseWarning(66508, JText::_('Could not install LivingWord module. Uninstall any previous versions and install manually.'));
 		}
    if($type == 'update'){
      $this->setRules($this->params);
      $this->updateLWDB();
      $parent->getParent()->setRedirectURL('index.php?option=com_installer');
    } elseif($type == 'install'){
      $this->setParams($this->params);
      $this->setRules($this->params);
      $this->updateLWDB();
      $this->addLWCategory();
      $parent->getParent()->setRedirectURL('index.php?option=com_livingword');
    }
  }
}
?>