<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
class LivingWordModelManagePlans extends JModelList
{
	/**
	 * @var int
	 */
	var $_id = null;
	/**
	 * @var array
	 */
	var $_data = null;
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
//		parent::__construct();
		$array = JRequest::getVar('cid', array(0), '', 'array');
		$edit	= JRequest::getVar('edit',true);
		if($edit)
			$this->setId((int)$array[0]);
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name', 'a.name',
        'audio', 'a.audio',
        'description', 'a.description',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'ordering', 'a.ordering',
				'published', 'a.published',
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
  	$row =& JTable::getInstance('LivingWordPlans', 'Table');
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
	function saveorderplans($cid = array(), $order)
	{
   	$row =& JTable::getInstance('LivingWordPlans', 'Table');
    $this->_db->setQuery("SELECT * FROM #__livingword_plans");
    $results = $this->_db->loadObjectList();
    if(!empty($cid)){
		for( $i=0; $i < count($cid); $i++ )
		{
      if($results[$i]->ordering != $order[$i])
			{
       	$save = "UPDATE #__livingword_plans SET ordering='".$order[$i]."' WHERE id='".$cid[$i]."'";
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
		$app = JFactory::getApplication('administrator');
  	$search = $this->getUserStateFromRequest( $this->context.'.filter.search', 'filter_search' );
  	$this->setState('filter.search', $search);
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
		// List state information.
		parent::populateState('a.name', 'asc');
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
				'a.id, a.name, a.description, a.message, a.checked_out, a.checked_out_time' .
				', a.published, a.ordering, a.audio, a.newtest'
			)
		);
		$query->from('#__livingword_plans AS a');
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
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			elseif (stripos($search, 'name:') === 0) {
				$search = $db->Quote('%'.$db->escape(substr($search, 7), true).'%');
				$query->where('(uc.name LIKE '.$search.' OR uc.username LIKE '.$search.')');
			}
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.name LIKE '.$search.')');
			}
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
}