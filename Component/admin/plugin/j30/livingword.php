<?php
/***********************************************************************************
 Title          LivingWord - Plugin for Joomla 
 Author         Mike Leeper
 Copyright      © MLWebTechnologies
 URL            http://www.mlwebtechnologies.com
 License        This is free software and you may redistribute it under the GPL.
                LivingWord comes with absolutely no warranty. For details, see the 
                license at http://www.gnu.org/licenses/gpl.txt
                YOU ARE NOT REQUIRED TO KEEP COPYRIGHT NOTICES IN
                THE HTML OUTPUT OF THIS SCRIPT. YOU ARE NOT ALLOWED
                TO REMOVE COPYRIGHT NOTICES FROM THE SOURCE CODE.
*************************************************************************************/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
class  plgSystemLivingWord extends JPlugin
{
	public function plgSystemLivingWord(& $subject, $config)
	{
		parent::__construct($subject, $config);
  }
	public function onAfterRoute()
  {
    $app = JFactory::getApplication();
    if ( $app->isAdmin()) {
    		return true;
    	}
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    jimport('joomla.filesystem.folder');
    if(file_exists(JPATH_ROOT."/administrator/components/com_livingword/config.xml")){
      require_once( JPATH_ROOT."/components/com_livingword/helpers/lw_includes.php" );
      require_once( JPATH_ROOT."/components/com_livingword/helpers/lw_class.php" );
    } else { return false;}
    JPlugin::loadLanguage('com_livingword');
//    global $lwConfig;
    $livingwordplg = new livingword();
    $config_allow_email = $lwConfig['config_enable_email'];
    $config_default_bv = $lwConfig['config_bible_version'];
    $config_enable_twitter = $lwConfig['config_enable_twitter'];
    $config_twitter_ck = $lwConfig['config_twitter_ck'];
    $config_twitter_cs = $lwConfig['config_twitter_cs'];
    $config_twitter_at = $lwConfig['config_twitter_at'];
    $config_twitter_as = $lwConfig['config_twitter_as'];
    $config_global_emailsend = $lwConfig['config_global_emailsend'];
    if(!preg_match('/^[0-9]{2}:[0-9]{2}/', $config_global_emailsend)) $config_global_emailsend = '';
    $twarray = explode(",",$config_twitter_ck.','.$config_twitter_cs.','.$config_twitter_at.','.$config_twitter_as);
    $app = JFactory::getApplication();
    $plugin = JPluginHelper::getPlugin('system', 'livingword');
    $config_previous = '86400';
    $config_replyto_name = $app->getCfg('mailfrom');
  	$email_subject = JText::_('LWEMAILSUBJECT');
  	$email_message = JText::_('LWEMAILMSG');
    $sender_name = JText::_('LWTITLE');
  	$mediaPath = JPATH_ROOT.'/media';
  	$checkfileName='plg_livingword_checkfile_';
  	$today = date("Y-m-d");
  	$dateCheckFile = $checkfileName.$today;	
  	$okToContinue = true;
    $filearray = JFolder::files($mediaPath, $checkfileName.'*.*');
    foreach($filearray as $matchfile){
      if((time() - filemtime($mediaPath.'/'.$matchfile)) > $config_previous) {
        @unlink($mediaPath.'/'.$matchfile);
        }
      }
    if (is_writable($mediaPath) )
  		{
  		if (is_file($mediaPath.'/'.$dateCheckFile) ) 
  			{
          $okToContinue = false;
        }
    		elseif ((!empty($config_global_emailsend)) && ((date("H:i",time()) < $config_global_emailsend) || (date("H:i",time()) > date('H:i',strtotime($config_global_emailsend.' + 30 minutes',$config_global_emailsend))))) 
			  {
          $okToContinue = false;
  			}
    		elseif (!touch($mediaPath.'/'.$dateCheckFile)) 
  			{
          $okToContinue = false;
  			}
  		}
  	else
  	  {
        $okToContinue = false;
      }
  	if ($okToContinue){
      $mysettings = $livingwordplg->LWGetUserData(true);
      if(count($mysettings) < 1) {
      } else {
        foreach($mysettings as $mine){
          $bplan = $mine->bibleplan;
          $bibleversion = $mine->bibleversion;
          $langfile = strtolower($livingwordplg->LWgetLang($bibleversion));
          $lang =& JFactory::getLanguage();
          $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
          $audio_version = $livingwordplg->LWgetAudio($bibleversion);
          $reading_array = $livingwordplg->LWGetReadingLink(true);
          if($audio_version){
            $message = str_replace('%link%',$reading_array['audlink'],$email_message);
            $message = str_replace('%name%',$mine->name,$message);
          } else {
            $message = str_replace('%link%',$reading_array['rlink'].' or listen to the '.$reading_array['audlink'],$email_message);
            $message = str_replace('%name%',$mine->name,$message);
          }
          if($config_allow_email && $mine->email){
            $this->LWemail_notification($mine->emailaddr,$config_replyto_name,$sender_name,$email_subject,$message);
          }
        }
        if($config_enable_twitter && !empty($config_twitter_ck) && !empty($config_twitter_cs) && !empty($config_twitter_at) && !empty($config_twitter_as) && $curdate > 0){
          $this->LWpostToTwitter($twarray,JText::_('LWEMAILSUBJECT'),$rlink,$reading_str);
        }
      }
   }
  }
  function LWemail_notification($config_email_list,$config_email_replyto_name,$config_email_sender_name,$config_email_subject,$config_email_message)
  {
    $app =& JFactory::getApplication();
    $livesite = JURI::base();
    $sitename = $app->getCfg( 'sitename' );
    $mailfrom = $app->getCfg('mailfrom');
		$body = $config_email_message;
    $body = str_replace("\n","<br />",$body);
		$body = str_replace("%sitelink%", '<a href="'.$livesite.'index.php?option=com_livingword&task=settings" target="_blank">'.$livesite.'index.php?option=com_livingword&task=settings</a>', $body);
		$body = str_replace("%title%", $sitename, $body);
  	$mailer =& JFactory::getMailer();
  	$mailer->setSender(array($mailfrom, $config_email_sender_name));
  	$mailer->setSubject($config_email_subject);
  	$mailer->setBody($body);
  	$mailer->IsHTML(true);
  	if ( is_array($config_email_list)) {
  		foreach ($config_email_list as $email) {
   			$mailer->addRecipient($email);
   		}
      $count = count($config_email_list);
  	} else {
  		$mailer->addRecipient($config_email_list);
      $count = 1;
  	}
  	$rs	= $mailer->Send();
  }
  function LWpostToTwitter($twarray,$subject,$rlink,$reading_str){
    $app =& JFactory::getApplication();
    $livesite = JURI::base();
    $sitename = $app->getCfg( 'sitename' );
  	$consumerKey = trim($twarray[0]);
  	$consumerSecret = trim($twarray[1]);
  	$oAuthToken = trim($twarray[2]);
  	$oAuthSecret = trim($twarray[3]);
    require_once(JPATH_ROOT.'/components/com_livingword/helpers/twitteroauth.php');   
    preg_match("#http(.*?)\"#",$rlink,$matches);
    $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);   
    $tweet->post('statuses/update', array('status' => stripslashes(urldecode($subject.' '.$reading_str)).' '.$this->LWgetShortURL($matches[0],$lwConfig['config_twitter_shorturl']).' via '.$livesite)); 
  }
  function LWgetShortURL($longurl,$service=1){
    if($service == 1){
      $shorturl =  file_get_contents("http://is.gd/api.php?longurl=".$longurl);
    } elseif($service == 2){
      $shorturl =  file_get_contents("http://u.nu/unu-api-simple?url=".$longurl);
    } else {
      $shorturl =  file_get_contents("http://tinyurl.com/api-create.php?url=".$longurl);
    }
    return $shorturl;
  }
}
?>