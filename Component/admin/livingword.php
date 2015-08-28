<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
if (!JFactory::getUser()->authorise('core.manage', 'com_livingword'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
include( JPATH_ADMINISTRATOR.'/components/com_livingword/helpers/admin_lw_includes.php' );
JLoader::register('LivingWordHelper', dirname(__FILE__) . '/helpers/livingword.php');
$controller	= JControllerLegacy::getInstance('LivingWord');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();