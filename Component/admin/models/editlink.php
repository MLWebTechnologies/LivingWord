<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_livingword
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class LivingWordModelEditLink extends JModelAdmin
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
		$planid = $input->getVar('cid');
		$this->setState('id', $planid[0]);
	}
	public function getTable($type = 'LivingWordLinks', $prefix = 'LivingWordTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_livingword.editlink', 'lwlink', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	protected function loadFormData()
	{
    $id = $this->getState('id');
    $edit = $this->getState('edit');
    $db = JFactory::getDBO();
    if($edit){
    	$query = "SELECT * FROM #__livingword_links"
    	. "\n WHERE id=".$id.""
    	;
      $db->setQuery($query);
      $data = $db->loadObject();
    } else {
			$data = new stdClass();
      $data->id = 0;
			$data->name = "";
			$data->description = "";
			$data->message = "";
			$data->audio = 0;
      $data->newtest = 0;
			$data->published = 1;
      $data->catid = "";
			$data->ordering 	= 0;
    }
//		$data = JFactory::getApplication()->getUserState('com_livingword.edit.editplan.data', array());
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);
		if (empty($table->alias)) {
			$table->alias = JApplication::stringURLSafe($table->title);
		}
		if (empty($table->id))
		{
			// Set the values
			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__livingword_links');
				$max = $db->loadResult();
				$table->ordering = $max + 1;
			}
			else
			{
				// Set the values
				$table->modified	= $date->toSql();
				$table->modified_by	= $user->get('id');
			}
			// Increment the content version number.
			$table->version++;
		}
	}
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'catid = '.(int) $table->catid;
		return $condition;
	}
}