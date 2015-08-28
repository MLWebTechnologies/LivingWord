<?php
/* *************************************************************************************
Title          LivingWord Component for Joomla 
Author         Mike Leeper
License        This program is free software: you can redistribute it and/or modify
               it under the terms of the GNU General Public License as published by
               the Free Software Foundation, either version 3 of the License, or
               (at your option) any later version.
               This program is distributed in the hope that it will be useful,
               but WITHOUT ANY WARRANTY; without even the implied warranty of
               MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
               GNU General Public License for more details.
               You should have received a copy of the GNU General Public License
               along with this program.  If not, see <http://www.gnu.org/licenses/>.
Copyright      2008-2014 - Mike Leeper (MLWebTechnologies) 
****************************************************************************************
No direct access*/
defined( '_JEXEC' ) or die( 'Restricted access' );

class LivingWordController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false){
		parent::display();
  }
  function settings(){
		JRequest::setVar('view', 'showsettings' );
		parent::display();
  }
  function resources(){
		JRequest::setVar('view', 'showresources' );
		parent::display();
  }
  function view_plan(){
    global $lwConfig;
    $user = JFactory::getUser();
    $db	= JFactory::getDBO();
    $sql = $db->setQuery("SELECT planview FROM #__livingword WHERE userid='".(int)$user->id."'");
    $mysettings = $db->loadObject();
    $view = $this->getView('showplan', 'html');
    if(!empty($mysettings)) $planview = $mysettings->planview;
    if(isset($planview) && $planview == 2) {
  		$view->setLayout('calendar');
    } elseif(isset($planview) && $planview == 1) {
  		$view->setLayout('default');
    } else {
      $template = $lwConfig['config_plan_template'];
  		$view->setLayout($template);
    }
		$view->display();
  }
  function tools(){
		JRequest::setVar('view', 'showtools' );
		parent::display();
  }
  function createICS(){
    global $livingword;
    $app = JFactory::getApplication();
    $UserDataArray = $livingword->LWGetUserData();
    $curdate = $livingword->readingCurDate($UserDataArray['bplan']);
    $bplan = $UserDataArray['bplan'];
    $bversion = $UserDataArray['bversion'];
    $chplan = $livingword->LWGetPlanData($bplan);
    $title = JText::_('LWDBREADING');
    $date = date("z")+2;
    $output =  "BEGIN:VCALENDAR\n";
    $output .=  "VERSION:2.0\n";
    $output .=  "PRODID:PHP\n";
    $output .=  "METHOD:REQUEST\n";
    $output .=  "X-WR-CALNAME:".JText::_('LWDBREADING')."\n";
    for($d=$curdate;$d<count($chplan);$d++){
      $description = JText::_('LWTODAYSREADING').' {STRING}';
      $output .=  "BEGIN:VEVENT\n";
      $output .=  "DTSTART:".date("Ymd",mktime(0,0,0,1,$date,date('Y')))."T080000\n";
      $output .=  "DTEND:".date("Ymd",mktime(0,0,0,1,$date,date('Y')))."T081500\n";
      $output .=  "SUMMARY:".$title."\n";
      $output .=  "DESCRIPTION:";
      $readingarray = $livingword->LWGetReadingLink(false,$d);
      $description = str_replace('{STRING}', $readingarray['reading_str'], $description);
      $output .=  $description." (".$readingarray['rlink'].")\n";
      $output .=  "UID:".time().$d."\n";
      $output .=  "DTSTAMP:".date('Ymd').'T'.date('His')."Z\n";
      $output .=  "CATEGORIES:Personal\n";
      $output .=  "CLASS:PRIVATE\n";
      $output .=  "BEGIN:VALARM\n";
      $output .=  "TRIGGER:-PT15M\n";
      $output .=  "ACTION:DISPLAY\n";
      $output .=  "DESCRIPTION:Reminder\n";
      $output .=  "END:VALARM\n";
      $output .=  "END:VEVENT\n";
      $date++;
    }
    $output .=  "END:VCALENDAR\n";
		header('Content-Type: text/x-vCalendar');
    header('Content-Disposition: inline; filename=calendar.ics');
		header('Content-Length: '.strlen($output));
		header('Connection: close');
		header('Cache-Control: store, cache');
		header('Pragma: cache');
    print $output;
    $app->close();
  }
  function rss(){
  	global $livingword;
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    $UserDataArray = $livingword->LWGetUserData();
    $curdate = $livingword->readingCurDate($UserDataArray['bplan'])-1;
    $readingarray = $livingword->LWGetReadingLink();
    $livesite = JURI::base();
    $app = JFactory::getApplication();
    $sitename = $app->getCfg( 'sitename' );
    $itemid = $livingword->LWgetItemid();
  	while( @ob_end_clean() );
 		require_once('components/com_livingword/assets/rss/feedcreator.php');
  	$feed_type = 'RSS2.0';
  	$filename = 'lw_feed.xml';
    $cacheDir = JPATH_BASE.'/cache';
  	$cachefile = $cacheDir.'/'. $filename;
  	$rss 	= new UniversalFeedCreator();
  	$image 	= new FeedImage();
		$rss->useCached( $feed_type, $cachefile, 3600 );
  	$rss->title = htmlspecialchars(stripslashes($sitename)).' - '.JText::_('LWTITLE');
  	$rss->description = JText::_('LWRSSFEEDMSG').' '.$sitename;
  	$rss->link = htmlspecialchars( $livesite).'index.php?option=com_livingword&amp;Itemid='.$itemid;
  	$rss->syndicationURL = htmlspecialchars( $livesite).'index.php?option=com_livingword&amp;Itemid='.$itemid;
  	$rss->cssStyleSheet	= NULL;
    $rss->pubDate = time();
  	$feed_image	= $livesite.'components/com_livingword/assets/images/bible.jpg';
  	if ( $feed_image ) {
  		$image->url 		= $feed_image;
      $image->width   = 100;
      $image->height  = 150;
  		$image->link 		= $rss->link;
  		$image->title 		= JText::_('LWPOWERBY');
  		$image->description	= $rss->description;
  		$image->image 		= $image;
  	}
		$item = new FeedItem();
		$item->title = JText::_('LWDBREADING');
    $item->category = JText::_('LWRSSFEEDTOPIC');
		$item_description = '<br /><br />'.JText::_('LWTODAYSREADING').' {READINGLINK}';
    $item->link = $readingarray['rlink'];
    $item->description = str_replace('{READINGLINK}', $readingarray['rlink'], $item_description);
		$rss->addItem( $item );
  	$rss->saveFeed( $feed_type, $cachefile );
   }
}
?>