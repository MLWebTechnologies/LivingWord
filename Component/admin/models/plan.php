<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.model');
class LivingWordModelPlan extends JModel
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
		parent::__construct();
		$array = JRequest::getVar('cid', array(0), '', 'array');
		$edit	= JRequest::getVar('edit',true);
		if($edit)
			$this->setId((int)$array[0]);
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
		if (!$row->move( $direction )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	function saveorderplan($cid = array(), $order, $plan)
	{
   	$row =& JTable::getInstance('LivingWordPlanDetails', 'Table');
    $this->_db->setQuery("SELECT * FROM #__livingword_plans_details WHERE plan='".$plan."'");
    $results = $this->_db->loadObjectList();
    if(!empty($cid)){
  		for( $i=0; $i < count($cid); $i++ )
  		{
        if($results[$i]->ordering != $order[$i])
  			{
         	$save = "UPDATE #__livingword_plans_details SET ordering='".(int)$order[$i]."' WHERE id='".(int)$cid[$i]."'";
          $this->_db->setQuery($save);
        	if (!$this->_db->query()) {
  					$this->setError($this->_db->getErrorMsg());
  					return false;
  				}
  	    }
  		}
    }
		$row->reorder("plan='".$plan."'");
		return true;
	}
}