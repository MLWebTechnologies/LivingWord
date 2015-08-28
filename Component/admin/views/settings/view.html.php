<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class LivingWordViewSettings extends JView
{
	function display( $tpl = null)
	{
		global $mainframe, $lwConfig, $bible_version, $bible_plan;
    $popup = JRequest::getVar('pop',null,'get','int');
		// Set pathway information
		$this->assignRef('config_global_startdate', $lwConfig['config_global_startdate']);
		$this->assignRef('config_bible_version', $lwConfig['config_bible_version']);
		$this->assignRef('config_audio_version', $lwConfig['config_audio_version']);
		$this->assignRef('config_show_audio', $lwConfig['config_show_audio']);
		$this->assignRef('config_altaudio_version', $lwConfig['config_altaudio_version']);
		$this->assignRef('config_bible_plan', $lwConfig['config_bible_plan']);
		$this->assignRef('config_plan_template', $lwConfig['config_plan_template']);
		$this->assignRef('config_enable_email', $lwConfig['config_enable_email']);
		$this->assignRef('config_enable_twitter', $lwConfig['config_enable_twitter']);
		$this->assignRef('config_twitter_ck', $lwConfig['config_twitter_ck']);
		$this->assignRef('config_twitter_cs', $lwConfig['config_twitter_cs']);
		$this->assignRef('config_twitter_at', $lwConfig['config_twitter_at']);
		$this->assignRef('config_twitter_as', $lwConfig['config_twitter_as']);
		$this->assignRef('config_show_print', $lwConfig['config_show_print']);
		$this->assignRef('config_show_ical', $lwConfig['config_show_ical']);
		$this->assignRef('config_show_bookmarks',	$lwConfig['config_show_bookmarks']);
		$this->assignRef('config_show_credit', $lwConfig['config_show_credit']);
		$this->assignRef('config_use_gb', $lwConfig['config_use_gb']);
		$this->assignRef('config_show_rss', $lwConfig['config_show_rss']);
		$this->assignRef('config_show_menu', $lwConfig['config_show_menu']);
		$this->assignRef('config_user_view_lwhome', $lwConfig['config_user_view_lwhome']);
		$this->assignRef('config_user_view_userpref', $lwConfig['config_user_view_userpref']);
		$this->assignRef('config_user_view_stools', $lwConfig['config_user_view_stools']);
		$this->assignRef('config_user_view_bresource', $lwConfig['config_user_view_bresource']);
		$this->assignRef('config_moduleclass_sfx', $lwConfig['config_moduleclass_sfx']);
		$this->assignRef('popup', $popup);
		$this->assignRef('bible_version', $bible_version);
		$this->assignRef('bible_plan', $bible_plan);
		parent::display($tpl);
	}
}
?>