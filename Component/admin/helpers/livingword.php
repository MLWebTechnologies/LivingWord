  <?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_livingword
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
/**
 * Weblinks helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_livingword
 * @since       1.6
 */
class LivingWordHelper
{
	public static $extension = 'com_livingword';
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	The name of the active view.
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'livingword')
	{
		JSubMenuHelper::addEntry(
			JText::_('CPanel'),
			'index.php?option=com_livingword',
			$vName == 'livingword'
		);
		JSubMenuHelper::addEntry(
			JText::_('Plans'),
			'index.php?option=com_livingword&task=manage_plans',
			$vName == 'manageplans'
		);
		JSubMenuHelper::addEntry(
			JText::_('Books'),
			'index.php?option=com_livingword&task=manage_books',
			$vName == 'managebooks'
		);
		JSubMenuHelper::addEntry(
			JText::_('Subscribers'),
			'index.php?option=com_livingword&task=manage_sub',
			$vName == 'managesub'
		);
		JSubMenuHelper::addEntry(
			JText::_('CSS'),
			'index.php?option=com_livingword&task=manage_css',
			$vName == 'managecss'
		);
		JSubMenuHelper::addEntry(
			JText::_('Links'),
			'index.php?option=com_livingword&task=manage_link',
			$vName == 'managelink'
		);
		JSubMenuHelper::addEntry(
			JText::_('Languages'),
			'index.php?option=com_livingword&task=manage_lang',
			$vName == 'managelang'
		);
		JSubMenuHelper::addEntry(
			JText::_('Categories'),
			'index.php?option=com_categories&extension=com_livingword',
			$vName == 'categories'
		);
		if ($vName == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_livingword')),
				'livingword-categories');
		}
	}
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   integer  The category ID.
	 * @return  JObject
	 * @since   1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		if (empty($categoryId))
		{
			$assetName = 'com_livingword';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_livingword.category.'.(int) $categoryId;
			$level = 'category';
		}
		$actions = JAccess::getActions('com_livingword', $level);
		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}
		return $result;
	}
}