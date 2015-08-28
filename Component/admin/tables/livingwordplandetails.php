<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
defined( '_JEXEC' ) or die( 'Restricted Access' );
/**
* Provides access to the #__livingword_plans_details table
*/
class TableLivingWordPlanDetails extends JTable {
	/** @var int Unique id*/
	var $id=null;
	/** @var int */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/** @var int */
	var $ordering=null;
	/**
	* @param database A database connector object
	*/
	function __construct( &$db ) {
		parent::__construct( '#__livingword_plans_details', 'id', $db );
	}
	function check() {
		if( empty( $this->created ) ) {
			$this->created = date('Y-m-d H:i:s');
		}
		return true;
	}
}
?>