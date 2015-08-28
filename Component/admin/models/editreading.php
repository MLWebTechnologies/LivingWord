<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_livingword
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class LivingWordModelEditReading extends JModelAdmin
{
	protected $text_prefix = 'COM_LIVINGWORD';
	protected function populateState()
	{
		parent::populateState();
		$input = JFactory::getApplication()->input;
		$user = JFactory::getUser();
		$this->setState('user.id', $user->get('id'));
		$edit = $input->getVar('edit');
		$this->setState('edit', $edit);
		$plan = $input->getVar('plan');
		$this->setState('plan', $plan);
		$name = $input->getVar('name');
		$this->setState('name', $name);
		$planid = $input->getVar('cid');
		$this->setState('id', $planid[0]);
	}
	public function getTable($type = 'LivingWordPlans', $prefix = 'LivingWordTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_livingword.editreading', 'reading', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	protected function loadFormData()
	{
    $id = $this->getState('id');
    $edit = $this->getState('edit');
  	$plan	= $this->getState('plan');
  	$name	= $this->getState('name');
    $db = JFactory::getDBO();
    if($edit){
    	$query = "SELECT a.*, b.plan, b.reading, b.audio, b.figure, b.descrip, b.id AS detailid"
    	. "\n FROM #__livingword_plans AS a"
    	. "\n LEFT JOIN #__livingword_plans_details AS b"
    	. "\n ON(a.name=b.plan)"
    	. "\n WHERE b.id=".$id.""
    	;
      $db->setQuery($query);
      $data = $db->loadObject();
    } else {
      $db->setQuery("SELECT id FROM #__livingword_plans WHERE name='".$plan."'");
      $trow = $db->loadObject();
      $data = new stdClass();
			$data->id = $trow->id;
			$data->plan = $plan;
      $data->name = $plan;
			$data->audio = "";
			$data->figure = "";
			$data->descrip = "";
			$data->published = 1;
			$data->ordering 	= 0;
    }
//		$data = JFactory::getApplication()->getUserState('com_livingword.edit.editplan.data', array());
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}
}