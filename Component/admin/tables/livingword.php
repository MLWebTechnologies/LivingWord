<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
defined( '_JEXEC' ) or die( 'Restricted Access' );
/**
* Provides access to the #__livingword table
*/
class TableLivingWord extends JTable {
	/** @var int Unique id*/
	var $id=null;
	/** @var int */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/**
	* @param database A database connector object
	*/
	function __construct( &$db ) {
		parent::__construct( '#__livingword', 'id', $db );
	}
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}
		return parent::bind($array, $ignore);
	}
	public function load($pk=null, $reset=true)
	{
		if (parent::load($pk, $reset)) {
			$params = new JRegistry();
			$params->loadJSON($this->params);
			$this->params = $params;
			return true;
		} else {
      return false;
    }
	}
	function check() {
		if( empty( $this->created ) ) {
			$this->created = date('Y-m-d H:i:s');
		}
		return true;
	}
}
?>