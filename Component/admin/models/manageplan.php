<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
class LivingWordModelManagePlan extends JModelList
{
	/**
	 * @var int
	 */
	var $_id = null;
	/**
	 * @var array
	 */
	var $_data = null;
  var $lfarray = null;
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct($config=array())
	{
//		parent::__construct();
		$array = JRequest::getVar('cid', array(0), '', 'array');
		$edit	= JRequest::getVar('edit',true);
		if($edit)
			$this->setId((int)$array[0]);
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'plan', 'a.plan',
        'audio', 'a.audio',
        'reading', 'a.reading',
        'figure', 'a.figure',
        'descrip', 'a.descrip',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'ordering', 'a.ordering'
			);
		}
		parent::__construct($config);
	}
	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}
	function move($direction)
	{
  	$row =& JTable::getInstance('LivingWordPlanDetails', 'Table');
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->move( $direction, ' published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	function saveorderplan($cid = array(), $order)
	{
   	$row =& JTable::getInstance('LivingWordPlanDetails', 'Table');
    $this->_db->setQuery("SELECT * FROM #__livingword_plan_details");
    $results = $this->_db->loadObjectList();
    if(!empty($cid)){
		for( $i=0; $i < count($cid); $i++ )
		{
      if($results[$i]->ordering != $order[$i])
			{
       	$save = "UPDATE #__livingword_plan_details SET ordering='".$order[$i]."' WHERE id='".$cid[$i]."'";
        $this->_db->setQuery($save);
      	if (!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
	     }
  		}
    }
		$row->reorder();
		return true;
	}
	protected function populateState($ordering = null, $direction = null)
	{
  	$search = $this->getUserStateFromRequest( $this->context.'.filter.search', 'filter_search' );
  	$this->setState('filter.search', $search);
    global $livingwordadmin,$lwConfig;
    $langfile = $livingwordadmin->LWgetLang($lwConfig['config_bible_version']);
    $lfarray = $this->parse(JPATH_ROOT.'/components/com_livingword/assets/language/en/'.$langfile.'.com_livingword_biblebooks.ini');
    $this->lfarray = $lfarray;
		// List state information.
		parent::populateState('a.ordering', 'asc');
		$input = JFactory::getApplication()->input;
		$planid = $input->getVar('cid');
		$this->setState('filter.planid', $planid[0]);
	}
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.plan, a.reading, a.audio, a.checked_out, a.checked_out_time' .
				', a.descrip, a.ordering, a.figure'
			)
		);
		$query->from('#__livingword_plans_details AS a');
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		// Join over the asset groups.
//		$query->select('ag.title AS access_level');
//		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
//			$query->where('a.access = ' . (int) $access);
		}
		// Implement View Level Access
		if (!$user->authorise('core.admin'))
		{
			$groups	= implode(',', $user->getAuthorisedViewLevels());
//			$query->where('a.access IN ('.$groups.')');
		}
		// Filter by search in name.
		$search = $this->getState('filter.search');
    $searchkey = array_search($search,$this->lfarray);
    $id = $this->getState('filter.planid');
    if(!$id) $id	= JRequest::getVar( 'planid', null, '', 'int' );
		if (!empty($search)) {
  		$query->where('(plan=(SELECT name FROM #__livingword_plans WHERE id='.$id.') AND figure LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')');
  		$query->where('(plan=(SELECT name FROM #__livingword_plans WHERE id='.$id.') AND descrip LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')');
      if($searchkey) $search = $searchkey;
  		$query->where('(plan=(SELECT name FROM #__livingword_plans WHERE id='.$id.') AND reading LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')');
		} else {
  		$query->where('plan=(SELECT name FROM #__livingword_plans WHERE id='.$id.')');
		}
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering') {
			$orderCol = 'a.id '.$orderDirn.', a.ordering';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
	protected function parse($filename)
	{
		$version = phpversion();
		$php_errormsg	= null;
		$track_errors	= ini_get('track_errors');
		ini_set('track_errors', true);
		if ($version >= '5.3.1') {
			$contents = file_get_contents($filename);
			$contents = str_replace('_QQ_','"\""',$contents);
			$strings = @parse_ini_string($contents);
		}	else {
			$strings = @parse_ini_file($filename);
			if ($version == '5.3.0' && is_array($strings)) {
				foreach($strings as $key => $string)
				{
					$strings[$key]=str_replace('_QQ_','"',$string);
				}
			}
		}
		ini_set('track_errors',$track_errors);
		if (!is_array($strings)) {
			$strings = array();
		}
		return $strings;
	}
}