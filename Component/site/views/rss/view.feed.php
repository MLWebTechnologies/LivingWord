<?php
/**
 * @package     Joomla.Legacy
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Base feed View class for a category
 *
 * @package     Joomla.Legacy
 * @subpackage  View
 * @since       3.2
 */
class LivingWordViewRss extends JViewCategoryfeed
{

   public function display($tpl = null)
   {
  	global $lwConfig, $livingword;
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    $db = JFactory::getDBO();
    $bplan = $lwConfig['config_bible_plan'];
    $audioversion = $lwConfig['config_audio_version'];
    $bversion = $lwConfig['config_bible_version'];
    $bplansql = $bplan;
    $db->setQuery("SELECT * FROM #__livingword_plans_details WHERE plan='".$bplansql."' ORDER BY ordering");
    $chplan = $db->loadObjectList();
    $livesite = JURI::base();
    $app = JFactory::getApplication();
    $document = new JDocument();
    $feed = $document->getInstance('feed');
    $sitename = $app->getCfg( 'sitename' );
    $itemid = $livingword->LWgetItemid();
    $windowopen = "window.open(this.href,this.target,'width=800,height=500,scrollbars=1');return false;";
    $awindowopen = "window.open(this.href,this.target,'width=400,height=200');return false;";
    $langfile = $livingword->LWgetLang($bversion);
    $lang = JFactory::getLanguage();
    $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
  	while( @ob_end_clean() );
// 		require_once('components/com_livingword/assets/rss/feedcreator.php');
//  	$feed_type = 'ATOM';
//  	$filename = 'lw_feed.xml';
//    $cacheDir = JPATH_BASE.'/cache';
//  	$cachefile = $cacheDir.'/'. $filename;
//  	$rss 	= new UniversalFeedCreator();
//  	$image 	= new JFeedImage();
//		$rss->useCached( $feed_type, $cachefile, 3600 );
  	$feed->title = stripslashes(htmlspecialchars($sitename)).' - '.JText::_('LWTITLE');
  	$feed->description = JText::_('LWRSSFEEDMSG').' '.$sitename;
  	$feed->link = htmlspecialchars( $livesite).'index.php?option=com_livingword&amp;Itemid='.$itemid;
  	$feed->syndicationURL = htmlspecialchars( $livesite).'index.php?option=com_livingword&amp;Itemid='.$itemid;
  	$feed->cssStyleSheet	= NULL;
    $feed->pubDate = time();
  	$feed_image	= $livesite.'components/com_livingword/assets/images/bible.jpg';
  	$image 	= new JFeedImage();
  	if ( $feed_image ) {
  		$image->url 		= $feed_image;
      $image->width   = 100;
      $image->height  = 150;
  		$image->link 		= $feed->link;
  		$image->title 		= JText::_('LWPOWERBY');
  		$image->description	= $feed->description;
  		$image->image 		= $image;
  	}
		$item = new JFeedItem();
		$item->title = JText::_('LWDBREADING');
    $item->category = JText::_('LWRSSFEEDTOPIC');
		$item_description = '<br /><br />'.JText::_('LWTODAYSREADING').' {READINGLINK}';
    $audio_version = $livingword->LWgetAudio($bversion);
    if($audio_version){
      $curdate = $livingword->readingCurDate($bplan)-1;
      $aversion = explode(",",$audioversion);
      $source = $aversion[0];
      $aid = $aversion[1];
      $alink = explode(",",$chplan[$curdate]->audio);
      if($bplan != 'newtest') $astr = explode(";",$chplan[358]->reading);
      $astrg = explode(";",$chplan[$curdate]->reading);
      $audio_link = "";
      $player = 'flash_play.php';
      $audio_link = ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'{QUERY}" target="_blank" onclick="'.$awindowopen.'">{STRING}</a>';
      if($curdate == 358){
        $audio_link = "";
        $audio_link = ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2].'" target="_blank" onclick="'.$awindowopen.'">'.$astr[0].'</a> & ';
        $audio_link .= ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5].'" target="_blank" onclick="'.$awindowopen.'">'.$astr[1].'</a> & ';
        $audio_link .= ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8].'" target="_blank" onclick="'.$awindowopen.'">'.$astr[2].'</a>';
      }
      if($bplan == 'ontp'){
        $audio_link = ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[0].'</a>';
        if($curdate != 40 && $curdate != 222){
        $audio_link .= ' & <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[1].'</a>';
        }
        if($curdate == 170 || $curdate == 353){
        $audio_link .= ' & <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[2].'</a>';
        }
      }
      if($bplan == 'chron'){
        $audio_link = ' <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[0].'</a>';
        if($curdate == 192 || $curdate == 196 || $curdate == 268 || $curdate == 329 || $curdate == 335 || $curdate == 353 || $curdate == 360){
        $audio_link .= ' & <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[1].'</a>';
        }
        if($curdate == 360){
        $audio_link .= ' & <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[2].'</a>';
        $audio_link .= ' & <a href="http://classic.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[9].'&chapter='.$alink[10].'&end_chapter='.$alink[11].'" target="_blank" onclick="'.$awindowopen.'">'.$astrg[3].'</a>';
        }
      }
      $audio_str = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-\;]+)/', array( &$livingword, 'matchBookName'), trim($chplan[$curdate]->reading) );
      $audio_link = str_replace('{QUERY}', '&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2], $audio_link);
      $audio_link = str_replace('{STRING}', htmlentities(str_replace(";"," & ",$audio_str)), $audio_link);
      $item->link = $audio_link;
      $item->description = str_replace('{READINGLINK}', $audio_link, $item_description);
    } else {
      $curdate = $livingword->readingCurDate($bplan);
      $reading_link = '<a href="http://classic.biblegateway.com/passage/?search={QUERY};&version='.$bversion.'&interface=print" target="_blank" onclick="'.$windowopen.'">{STRING}</a>';
      $item_link = 'http://bible.gospelcom.net/passage/?search={QUERY};&version='.$bversion;
      $reading_str = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-]+)/', array( &$livingword, 'matchBookName'), trim($chplan[$curdate]->reading) );
      $reading_link = str_replace('{STRING}', str_replace(";"," & ",$reading_str), $reading_link);
      $reading_link = str_replace('{QUERY}', $reading_str, $reading_link);
      $item_link = 'http://classic.biblegateway.com/passage/?search={QUERY};&version='.$bversion.'&interface=print';
      $item_str = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-]+)/', array( &$livingword, 'matchBookName'), trim($chplan[$curdate]->reading) );
      $item_link = str_replace('{QUERY}', urlencode($item_str), $item_link);
      $item->link = $item_link;
      $item->description = str_replace('{READINGLINK}', $reading_link, $item_description);
    }
		$feed->addItem( $item );
		header('Content-Type: application/atom+xml');
//		header('Content-Length: '.strlen($feed));
		header('Connection: close');
		header('Cache-Control: store, cache');
		header('Pragma: cache');
echo $feed->render(false);
    $app->close();
   }
}