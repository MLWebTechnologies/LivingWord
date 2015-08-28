<?php
/*************************************************************************************
 Title          LivingWord Bible Reading Plan Component for Joomla
 Author         Mike Leeper
 Copyright      © by Mike Leeper
 License        This is free software and you may redistribute it under the GPL.
                LivingWord Bible Reading Plan comes with absolutely no warranty. 
                For details, see the license at http://www.gnu.org/licenses/gpl.txt
                YOU ARE NOT REQUIRED TO KEEP COPYRIGHT NOTICES IN
                THE HTML OUTPUT OF THIS SCRIPT. YOU ARE NOT ALLOWED
                TO REMOVE COPYRIGHT NOTICES FROM THE SOURCE CODE.
Copyright      2008-2014 - Mike Leeper (MLWebTechnologies) 
               Bookmarks by AddThis
***************************************************************************************/
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport('joomla.environment.browser');
class livingword {
  var $lw_rights = null;
  function intializeLWRights(){
    $lw_rights = new JObject();
    $user = JFactory::getUser();
    if(JAccess::check($user->get('id'), 'livingword.home', 'com_livingword')) $lw_rights->set('lw.home',	true);
    if(JAccess::check($user->get('id'), 'livingword.links', 'com_livingword')) $lw_rights->set('lw.link',	true);
    if(JAccess::check($user->get('id'), 'livingword.settings', 'com_livingword')) $lw_rights->set('lw.settings',	true);
    if(JAccess::check($user->get('id'), 'livingword.tools', 'com_livingword')) $lw_rights->set('lw.tools',	true);
    $this->lw_rights = $lw_rights;
    return $lw_rights;
  }
  function LWgetAuth($page=null,$edit_own=null){
    global $lwConfig;
    $itemid = $this->LWgetItemid();
    $user = JFactory::getUser();
    $returnmsg = JRequest::getVar( 'return_msg', null, 'get', 'string' );
    $user_allow_anonymous = false;
    if($page != null){
      $page = 'lw.'.$page;
      if (!$this->lw_rights->get($page) && !$edit_own) {
        if(empty($returnmsg)){
        	$returnurl = JRoute::_('index.php?option=com_livingword&Itemid='.$itemid);
        	$this->LWRedirect( $returnurl, JText::_('ALERTNOTAUTH') );
        } else {
        	$returnurl = JRoute::_('index.php?option=com_livingword&Itemid='.$itemid.'&return_msg='.$returnmsg);
          $this->LWRedirect($returnurl);
        }
     }
    }
   return true;
  }
  function LWRedirect($str,$msg=null) {
		$app = JFactory::getApplication();
		$app->redirect($str,$msg);
  }
  function LWgetPrefOptions(){
    global $bible_version, $bible_plan, $dictionaries, $matchcriteria, $commentators;
    $bible_version = array(
          1 => array ('val' => 'TR1550', 'altval' => '69', 'aval' => '0', 'desc' => '1550 Stephanus New Testament (NT)', 'nt' => '1', 'lv' => 'GRC', 'audio' => '0'),
          2 => array ('val' => 'GNV', 'altval' => 'GNV', 'aval' => '0', 'desc' => '1599 Geneva Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          3 => array ('val' => 'WHNU', 'altval' => '68', 'aval' => '0', 'desc' => '1881 Westcott-Hort New Testament (NT)', 'nt' => '1', 'lv' => 'GRC', 'audio' => '0'),
          4 => array ('val' => 'TR1894', 'altval' => '70', 'aval' => '0', 'desc' => '1894 Scrivener New Testament (NT)', 'nt' => '1', 'lv' => 'GRC', 'audio' => '0'),
          5 => array ('val' => 'VIET', 'altval' => '19', 'aval' => '0', 'desc' => '1934 Vietnamese Bible', 'nt' => '0', 'lv' => 'VI', 'audio' => '0'),
          6 => array ('val' => 'BG1940', 'altval' => '82', 'aval' => '0', 'desc' => '1940 Bulgarian Bible', 'nt' => '0', 'lv' => 'BG', 'audio' => '0'),
          7 => array ('val' => 'SLO1979', 'altval' => 'tlm-hodul', 'aval' => '5,29', 'desc' => '1979 Slovak Bible (NT) - Audio - by Joseph Hodul', 'nt' => '1', 'lv' => 'BG', 'audio' => '1', 'tv' => ''),
          8 => array ('val' => 'KJ21', 'altval' => '48', 'aval' => '0', 'desc' => '21st Century King James Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          9 => array ('val' => 'ALB', 'altval' => '1', 'aval' => '0', 'desc' => 'Albanian Bible', 'nt' => '0', 'lv' => 'SQ', 'audio' => '0'),
          10 => array ('val' => 'ASV', 'altval' => '8', 'aval' => '0', 'desc' => 'American Standard Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          11 => array ('val' => 'AMP', 'altval' => '45', 'aval' => '0', 'desc' => 'Amplified Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          12 => array ('val' => 'AMU', 'altval' => '94', 'aval' => '0', 'desc' => 'Amuzgo De Guerrero (NT)', 'nt' => '1', 'lv' => 'AMU', 'audio' => '0'),
          13 => array ('val' => 'APSD-CEB', 'altval' => 'APSD-CEB', 'aval' => '0', 'desc' => 'Ang Pulong Sa Dios (NT)', 'nt' => '1', 'lv' => 'TL', 'audio' => '0'),
          14 => array ('val' => 'HLGN', 'altval' => 'HLGN', 'aval' => '0', 'desc' => 'Ang Pulong Sang Dios', 'nt' => '1', 'lv' => 'HIL', 'audio' => '0'),
          15 => array ('val' => 'SND', 'altval' => '43', 'aval' => '0', 'desc' => 'Ang Salita ng Diyos (NT)', 'nt' => '1', 'lv' => 'TL', 'audio' => '0'),
          16 => array ('val' => 'ERV-AR', 'altval' => 'ERV-AR', 'aval' => '0', 'desc' => 'Arabic Bible Easy-to-Read Version', 'nt' => '0', 'lv' => 'AR', 'audio' => '0'),
          17 => array ('val' => 'ALAB', 'altval' => '28', 'aval' => '0', 'desc' => 'Arabic Life Application Bible (NT)', 'nt' => '1', 'lv' => 'AR', 'audio' => '0'),
          18 => array ('val' => 'AKJV', 'altval' => 'AKJV', 'aval' => '0', 'desc' => 'Authorized King James Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          19 => array ('val' => 'ERV-AWA', 'altval' => 'ERV-AWA', 'aval' => '0', 'desc' => 'Awadhi Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'AWA', 'audio' => '0'),
          20 => array ('val' => 'BD2011', 'altval' => 'BD2011', 'aval' => '0', 'desc' => 'B?n D?ch 2011', 'nt' => '0', 'lv' => 'VI', 'audio' => '0'),
          21 => array ('val' => 'B21', 'altval' => 'B21', 'aval' => '0', 'desc' => 'Bible 21', 'nt' => '0', 'lv' => 'CS', 'audio' => '0'),
          22 => array ('val' => 'BK', 'altval' => 'bk-hodul', 'aval' => '19,44', 'desc' => 'Bible Kralická (NT) - Audio - by Joseph Hodul', 'nt' => '1', 'lv' => 'CS', 'audio' => '1', 'tv' => ''),
          23 => array ('val' => 'BPH', 'altval' => 'BPH', 'aval' => '0', 'desc' => 'Bibelen på hverdagsdansk', 'nt' => '0', 'lv' => 'DA', 'audio' => '0'),
          24 => array ('val' => 'VULGATE', 'altval' => '4', 'aval' => '0', 'desc' => 'Biblia Sacra Vulgata (with Apocrypha)', 'nt' => '0', 'lv' => 'LA', 'audio' => '0'),
          25 => array ('val' => 'BULG', 'altval' => '21', 'aval' => '0', 'desc' => 'Bulgarian Bible', 'nt' => '0', 'lv' => 'BG', 'audio' => '0'),
          26 => array ('val' => 'ERV-BG', 'altval' => 'ERV-BG', 'aval' => '0', 'desc' => 'Bulgarian New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'BG', 'audio' => '0'),
          27 => array ('val' => 'BPB', 'altval' => 'BPB', 'aval' => '0', 'desc' => 'Bulgarian Protestant Bible', 'nt' => '0', 'lv' => 'BG', 'audio' => '0'),
          28 => array ('val' => 'CKW', 'altval' => '98', 'aval' => '0', 'desc' => 'Cakchiquel Occidental (NT)', 'nt' => '1', 'lv' => 'CKW', 'audio' => '0'),
          29 => array ('val' => 'CHR', 'altval' => 'CHR', 'aval' => '0', 'desc' => 'Cherokee New Testament (NT)', 'nt' => '1', 'lv' => 'CHR', 'audio' => '0'),
          30 => array ('val' => 'CCO', 'altval' => '90', 'aval' => '0', 'desc' => 'Chinanteco de Comaltepec (NT)', 'nt' => '1', 'lv' => 'CCO', 'audio' => '0'),
          31 => array ('val' => 'CCB', 'altval' => 'CCB', 'aval' => '0', 'desc' => 'Chinese Comtemporary Bible', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          32 => array ('val' => 'CCB-A', 'altval' => 'ccb-biblica', 'aval' => '?', 'desc' => 'Chinese Comtemporary Bible - Audio - Read by Biblica', 'nt' => '0', 'lv' => 'ZH', 'audio' => '1', 'tv' => 'CCB'),
          33 => array ('val' => 'ERV-ZH', 'altval' => 'ERV-ZH', 'aval' => '0', 'desc' => 'Chinese New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'ZH', 'audio' => '0'),
          34 => array ('val' => 'CNVT', 'altval' => 'CNVT', 'aval' => '0', 'desc' => 'Chinese New Version (Traditional)', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          35 => array ('val' => 'CSBS', 'altval' => 'CSBS', 'aval' => '0', 'desc' => 'Chinese Standard Version (Simplified) (NT)', 'nt' => '1', 'lv' => 'ZH', 'audio' => '0'),
          36 => array ('val' => 'CSBS-A', 'altval' => 'csb-hao', 'aval' => '18,42', 'desc' => 'Chinese Standard Version (Simplified) - Audio - Read by Ran Hao', 'nt' => '1', 'lv' => 'ZH', 'audio' => '1', 'tv' => 'CSBS'),
          37 => array ('val' => 'CSBT', 'altval' => 'CSBT', 'aval' => '0', 'desc' => 'Chinese Standard Version (Traditional) (NT)', 'nt' => '1', 'lv' => 'ZH', 'audio' => '0'),
          38 => array ('val' => 'CSBT-A', 'altval' => 'csb-hao', 'aval' => '18,42', 'desc' => 'Chinese Standard Version (Traditional) - Audio - Read by Ran Hao', 'nt' => '1', 'lv' => 'ZH', 'audio' => '1', 'tv' => 'CSBT'),
          39 => array ('val' => 'CUVS', 'altval' => '80', 'aval' => '0', 'desc' => 'Chinese Union Version (Simplified)', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          40 => array ('val' => 'CUV', 'altval' => '22', 'aval' => '0', 'desc' => 'Chinese Union Version (Traditional)', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          41 => array ('val' => 'CUVMPS', 'altval' => 'CUVMPS', 'aval' => '0', 'desc' => 'Chinese Union Version Modern Punctuation (Simplified)', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          42 => array ('val' => 'CUVMPT', 'altval' => 'CUVMPT', 'aval' => '0', 'desc' => 'Chinese Union Version Modern Punctuation (Traditional)', 'nt' => '0', 'lv' => 'ZH', 'audio' => '0'),
          43 => array ('val' => 'CEB', 'altval' => 'CEB', 'aval' => '0', 'desc' => 'Common English Version (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          44 => array ('val' => 'CJB', 'altval' => 'CJB', 'aval' => '0', 'desc' => 'Complete Jewish Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          45 => array ('val' => 'CEI', 'altval' => '3', 'aval' => '0', 'desc' => 'Conferenza Episcopale Italiana (with Apocrypha)', 'nt' => '0', 'lv' => 'IT', 'audio' => '0'),
          46 => array ('val' => 'CEV', 'altval' => '46', 'aval' => '0', 'desc' => 'Contemporary English Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          47 => array ('val' => 'RMNN', 'altval' => 'RMNN', 'aval' => '0', 'desc' => 'Cornilescu', 'nt' => '0', 'lv' => 'RO', 'audio' => '0'),
          48 => array ('val' => 'DARBY', 'altval' => '16', 'aval' => '0', 'desc' => 'Darby Translation', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          49 => array ('val' => 'DNB1930', 'altval' => '5', 'aval' => '0', 'desc' => 'Det Norsk Bibelselskap 1930', 'nt' => '0', 'lv' => 'NO', 'audio' => '0'),
          50 => array ('val' => 'DN1933', 'altval' => '11', 'aval' => '0', 'desc' => 'Dette er Biblen på dansk', 'nt' => '0', 'lv' => 'DA', 'audio' => '0'),
          51 => array ('val' => 'DHH', 'altval' => '58', 'aval' => '0', 'desc' => 'Dios Habla Hoy (with Apocrypha)', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          52 => array ('val' => 'DRA', 'altval' => '63', 'aval' => '0', 'desc' => 'Douay-Rheims 1899 American Edition (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          53 => array ('val' => 'ERV', 'altval' => 'ERV', 'aval' => '0', 'desc' => 'Easy-to-Read Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          54 => array ('val' => 'LB', 'altval' => 'LB', 'aval' => '0', 'desc' => 'En Levende Bok (NT)', 'nt' => '1', 'lv' => 'NO', 'audio' => '0'),
          55 => array ('val' => 'ESV', 'altval' => '47', 'aval' => '0', 'desc' => 'English Standard Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          56 => array ('val' => 'ESV-AML', 'altval' => 'esv-laughlin', 'aval' => '8,32', 'desc' => 'English Standard Version - Audio - Read by Marquis Laughlin', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'ESV'),
          57 => array ('val' => 'ESV-AMM', 'altval' => 'esv-mclean', 'aval' => '8,21', 'desc' => 'English Standard Version - Audio - Read by Max McLean', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'ESV'),
          58 => array ('val' => 'ESVUK', 'altval' => 'ESVUK', 'aval' => '0', 'desc' => 'English Standard Version Anglicised', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          59 => array ('val' => 'EXB', 'altval' => 'EXB', 'aval' => '0', 'desc' => 'Expanded Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          60 => array ('val' => 'FARSI-A', 'altval' => 'tpv-as', 'aval' => '4,28', 'desc' => 'Farsi New Testament Version - Audio - Read by Audio Scriptures', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => ''),
          61 => array ('val' => 'GW', 'altval' => 'GW', 'aval' => '0', 'desc' => 'God\'s Word Translation', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          62 => array ('val' => 'GNT', 'altval' => 'GNT', 'aval' => '0', 'desc' => 'Good News Translation (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          63 => array ('val' => 'HHH', 'altval' => 'HHH', 'aval' => '0', 'desc' => 'Habrit Hakhadasha/Haderekh (NT)', 'nt' => '1', 'lv' => 'HE', 'audio' => '0'),
          64 => array ('val' => 'HCV', 'altval' => '23', 'aval' => '0', 'desc' => 'Haitian Creole Version', 'nt' => '0', 'lv' => 'HT', 'audio' => '0'),
          65 => array ('val' => 'HWP', 'altval' => 'HWP', 'aval' => '0', 'desc' => 'Hawai‘i Pidgin (NT)', 'nt' => '1', 'lv' => 'HU', 'audio' => '0'),
          66 => array ('val' => 'HTB', 'altval' => '30', 'aval' => '0', 'desc' => 'Het Boek', 'nt' => '0', 'lv' => 'NL', 'audio' => '0'),
          67 => array ('val' => 'ERV-HI', 'altval' => 'ERV-HI', 'aval' => '0', 'desc' => 'Hindi Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'HI', 'audio' => '0'),
          68 => array ('val' => 'HOF', 'altval' => '33', 'aval' => '0', 'desc' => 'Hoffnung für Alle (NT)', 'nt' => '1', 'lv' => 'DE', 'audio' => '0'),
          69 => array ('val' => 'HCSB', 'altval' => '77', 'aval' => '0', 'desc' => 'Holman Christian Standard Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          70 => array ('val' => 'HCSB-ADM', 'altval' => 'hcsb-mcconachie', 'aval' => '17,41', 'desc' => 'Holman Christian Standard Bible - Audio - Read by Dale McConachie', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'HCSB'),
          71 => array ('val' => 'KAR', 'altval' => '17', 'aval' => '0', 'desc' => 'Hungarian Károli', 'nt' => '0', 'lv' => 'HU', 'audio' => '0'),
          72 => array ('val' => 'ERV-HU', 'altval' => 'ERV-HU', 'aval' => '0', 'desc' => 'Hungarian Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'HU', 'audio' => '0'),
          73 => array ('val' => 'NT-HU', 'altval' => 'NT-HU', 'aval' => '0', 'desc' => 'Hungarian New Translation', 'nt' => '0', 'lv' => 'HU', 'audio' => '0'),
          74 => array ('val' => 'ICELAND', 'altval' => '18', 'aval' => '0', 'desc' => 'Icelandic Bible', 'nt' => '0', 'lv' => 'IS', 'audio' => '0'),
          75 => array ('val' => 'JAC', 'altval' => '103', 'aval' => '0', 'desc' => 'Jacalteco, Oriental (NT)', 'nt' => '1', 'lv' => 'JAC', 'audio' => '0'),
          76 => array ('val' => 'JLB', 'altval' => 'jlb-biblica', 'aval' => '24,50', 'desc' => 'Japanese Living Bible (NT) - Audio - Read by Biblica', 'nt' => '1', 'lv' => 'JA', 'audio' => '1', 'tv' => ''),
          77 => array ('val' => 'PHILLIPS', 'altval' => 'PHILLIPS', 'aval' => '0', 'desc' => 'J.B. Phillips New Testament (NT)', 'nt' => '1', 'lv' => 'EN', 'audio' => '0'),
          78 => array ('val' => 'AA', 'altval' => '25', 'aval' => '0', 'desc' => 'João Ferreira de Almeida Atualizada', 'nt' => '0', 'lv' => 'PT', 'audio' => '0'),
          79 => array ('val' => 'JUB', 'altval' => 'JUB', 'aval' => '0', 'desc' => 'Jubilee Bible 2000', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          80 => array ('val' => 'JBS', 'altval' => 'JBS', 'aval' => '0', 'desc' => 'Jubilee Bible 2000 (Spanish)', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          81 => array ('val' => 'CRO', 'altval' => 'CRO', 'aval' => '0', 'desc' => 'Knijga O Kristu (NT)', 'nt' => '1', 'lv' => 'HR', 'audio' => '0'),
          82 => array ('val' => 'KEK', 'altval' => '104', 'aval' => '0', 'desc' => 'Kekchi (NT)', 'nt' => '1', 'lv' => 'KEK', 'audio' => '0'),
          83 => array ('val' => 'KJV', 'altval' => '9', 'aval' => '0', 'desc' => 'King James Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          84 => array ('val' => 'KJV-AMM', 'altval' => 'kjv-mclean', 'aval' => '1,25', 'desc' => 'King James Version - Audio - Read by Max McLean', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'KJV'),
          85 => array ('val' => 'KJV-AD', 'altval' => 'kjv-dramatized', 'aval' => '1,37', 'desc' => 'King James Version - Audio - Read by Dramatized', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'KJV'),
          86 => array ('val' => 'KJV-APM', 'altval' => 'kjv-mims', 'aval' => '1,27', 'desc' => 'King James Version - Audio - Read by Paul Mims', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'KJV'),
          87 => array ('val' => 'BDG', 'altval' => 'BDG', 'aval' => '0', 'desc' => 'La Bibbia della Gioia (NT)', 'nt' => '1', 'lv' => 'IT', 'audio' => '0'),
          88 => array ('val' => 'BDS', 'altval' => '32', 'aval' => '0', 'desc' => 'La Bible du Semeur', 'nt' => '0', 'lv' => 'FR', 'audio' => '0'),
          89 => array ('val' => 'LBLA', 'altval' => '59', 'aval' => '0', 'desc' => 'La Biblia de las Américas', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          90 => array ('val' => 'LBLA-ASM', 'altval' => 'lbla-montoya', 'aval' => '6,30', 'desc' => 'La Biblia de las Americas (NT) - Audio - Read by Samuel Montoya H', 'nt' => '1', 'lv' => 'ES', 'audio' => '1', 'tv' => 'LBLA'),
          91 => array ('val' => 'LND', 'altval' => '55', 'aval' => '0', 'desc' => 'La Nuova Diodati', 'nt' => '0', 'lv' => 'IT', 'audio' => '0'),
          92 => array ('val' => 'BLP', 'altval' => 'BLP', 'aval' => '0', 'desc' => 'La Palabra (España)', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          93 => array ('val' => 'BLPH', 'altval' => 'BLPH', 'aval' => '0', 'desc' => 'La Palabra (Hispanoamérica)', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          94 => array ('val' => 'LEB', 'altval' => 'LEB', 'aval' => '0', 'desc' => 'Lexham English Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          95 => array ('val' => 'LEB-AL', 'altval' => 'leb-logos', 'aval' => '26,52', 'desc' => 'Lexham English Bible (NT) - Audio - Read by Logos', 'nt' => '1', 'lv' => 'EN', 'audio' => '1', 'tv' => 'LEB'),
          96 => array ('val' => 'TLB', 'altval' => 'TLB', 'aval' => '0', 'desc' => 'Living Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          97 => array ('val' => 'LSG', 'altval' => '2', 'aval' => '0', 'desc' => 'Louis Segond', 'nt' => '0', 'lv' => 'FR', 'audio' => '0'),
          98 => array ('val' => 'LUTH1545', 'altval' => '10', 'aval' => '0', 'desc' => 'Luther Bibel 1545', 'nt' => '0', 'lv' => 'DE', 'audio' => '0'),
          99 => array ('val' => 'MNT', 'altval' => '122', 'aval' => '0', 'desc' => 'Macedonian New Testament (NT)', 'nt' => '1', 'lv' => 'MK', 'audio' => '0'),
          100 => array ('val' => 'MVC', 'altval' => '88', 'aval' => '0', 'desc' => 'Mam, Central (NT)', 'nt' => '1', 'lv' => 'MVC', 'audio' => '0'),
          101 => array ('val' => 'MVJ', 'altval' => '107', 'aval' => '0', 'desc' => 'Mam de Todos Santos Chuchumatán (NT)', 'nt' => '1', 'lv' => 'MVJ', 'audio' => '0'),
          102 => array ('val' => 'MAORI', 'altval' => '24', 'aval' => '0', 'desc' => 'Maori Bible', 'nt' => '0', 'lv' => 'MI', 'audio' => '0'),
          103 => array ('val' => 'MOUNCE', 'altval' => 'MOUNCE', 'aval' => '0', 'desc' => 'Mounce Reverse-Interlinear New Testament (NT)', 'nt' => '1', 'lv' => 'EN', 'audio' => '0'),
          104 => array ('val' => 'ERV-MR', 'altval' => 'ERV-MR', 'aval' => '0', 'desc' => 'Marathi Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'MR', 'audio' => '0'),
          105 => array ('val' => 'MTDS', 'altval' => 'MTDS', 'aval' => '0', 'desc' => 'Mushuj Testamento Diospaj Shimi (NT)', 'nt' => '1', 'lv' => 'QU', 'audio' => '0'),
          106 => array ('val' => 'NPK', 'altval' => '40', 'aval' => '0', 'desc' => 'Nádej pre kazdého (NT)', 'nt' => '1', 'lv' => 'SK', 'audio' => '0'),
          107 => array ('val' => 'NGU', 'altval' => '109', 'aval' => '0', 'desc' => 'Náhuatl de Guerrero (NT)', 'nt' => '1', 'lv' => 'NGU', 'audio' => '0'),
          108 => array ('val' => 'NOG', 'altval' => 'NOG', 'aval' => '0', 'desc' => 'Names of God Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          109 => array ('val' => 'NBTN', 'altval' => 'NBTN', 'aval' => '0', 'desc' => 'Ne Bibliaj Tik Nawat (NT)', 'nt' => '1', 'lv' => 'PPL', 'audio' => '0'),
          110 => array ('val' => 'ERV-NE', 'altval' => 'ERV-NE', 'aval' => '0', 'desc' => 'Nepali Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'NE', 'audio' => '0'),
          111 => array ('val' => 'SNT', 'altval' => 'SNT', 'aval' => '0', 'desc' => 'Neno: Bibilia Takatifu (NT)', 'nt' => '1', 'lv' => 'SW', 'audio' => '0'),
          112 => array ('val' => 'SNT-AB', 'altval' => 'snt-biblica', 'aval' => '23,49', 'desc' => 'Neno: Bibilia Takatifu (NT) - Audio - Read by Biblica', 'nt' => '1', 'lv' => 'SW', 'audio' => '1', 'tv' => 'SNT'),
          113 => array ('val' => 'NGU-DE', 'altval' => 'NGU-DE', 'aval' => '0', 'desc' => 'Neue Genfer Übersetzung (NT)', 'nt' => '1', 'lv' => 'DE', 'audio' => '0'),
          114 => array ('val' => 'NASB', 'altval' => '49', 'aval' => '0', 'desc' => 'New American Standard Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          115 => array ('val' => 'NASB-ADM', 'altval' => 'nasb-mcconachie', 'aval' => '2,26', 'desc' => 'New American Standard - Audio - Read by Dale McConachie', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'NASB'),
          116 => array ('val' => 'NCV', 'altval' => 'NCV', 'aval' => '0', 'desc' => 'New Century Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          117 => array ('val' => 'NIRV', 'altval' => '76', 'aval' => '0', 'desc' => 'New International Reader\'s Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          118 => array ('val' => 'NIV', 'altval' => '31', 'aval' => '0', 'desc' => 'New International Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          119 => array ('val' => 'NIVUK', 'altval' => '64', 'aval' => '0', 'desc' => 'New International Version - UK', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          120 => array ('val' => 'NIV-AMM', 'altval' => 'niv-mcclean', 'aval' => '3,4', 'desc' => 'New International Version - Audio - Read by Max McLean', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'NIV'),
          121 => array ('val' => 'NIV-AGS', 'altval' => 'niv-purevoice', 'aval' => '3,39', 'desc' => 'New International Version - Audio - Read by George W. Sarris', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'NIV'),
          122 => array ('val' => 'NIV-AD', 'altval' => 'niv-dramatized', 'aval' => '3,38', 'desc' => 'New International Version - Audio - Read by Dramatized', 'nt' => '0', 'lv' => 'EN', 'audio' => '1', 'tv' => 'NIV'),
          123 => array ('val' => 'NIV1984', 'altval' => 'NIV1984', 'aval' => '0', 'desc' => 'New International Version 1984', 'nt' => '0', 'lv' => 'EN', 'audio' => '0', 'tv' => 'NIV'),
          124 => array ('val' => 'NKJV', 'altval' => '50', 'aval' => '0', 'desc' => 'New King James Version', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          125 => array ('val' => 'NLT', 'altval' => '51', 'aval' => '0', 'desc' => 'New Living Translation', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          126 => array ('val' => 'NRSV', 'altval' => 'NRSV', 'aval' => '0', 'desc' => 'New Revised Standard Version (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          127 => array ('val' => 'NRSVA', 'altval' => 'NRSVA', 'aval' => '0', 'desc' => 'New Revised Standard Version, Anglicised (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          128 => array ('val' => 'NRSVACE', 'altval' => 'NRSVACE', 'aval' => '0', 'desc' => 'New Revised Standard Version, Anglicised Catholic Edition', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          129 => array ('val' => 'NRSVCE', 'altval' => 'NRSVCE', 'aval' => '0', 'desc' => 'New Revised Standard Version Catholic Edition', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          130 => array ('val' => 'NA-TWI', 'altval' => 'NA-TWI', 'aval' => '0', 'desc' => 'Nkwa Asem (NT)', 'nt' => '1', 'lv' => 'TWI', 'audio' => '0'),
          131 => array ('val' => 'NTLR', 'altval' => 'NTLR', 'aval' => '0', 'desc' => 'Noua Traducere În Limba Româna', 'nt' => '0', 'lv' => 'RO', 'audio' => '0'),
          132 => array ('val' => 'NEG1979', 'altval' => 'NEG1979', 'aval' => '0', 'desc' => 'Nouvelle Edition de Genève', 'nt' => '0', 'lv' => 'FR', 'audio' => '0'),
          133 => array ('val' => 'NVI-PT', 'altval' => 'NVI-PT', 'aval' => '0', 'desc' => 'Nova Versão Internacional', 'nt' => '0', 'lv' => 'PT', 'audio' => '0'),
          134 => array ('val' => 'NP', 'altval' => 'NP', 'aval' => '0', 'desc' => 'Nowe Przymierze (NT)', 'nt' => '1', 'lv' => 'PL', 'audio' => '0'),
          135 => array ('val' => 'NBLH', 'altval' => 'NBLH', 'aval' => '0', 'desc' => 'Nueva Biblia Latinoamericana de Hoy', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          136 => array ('val' => 'NTV', 'altval' => 'NTV', 'aval' => '0', 'desc' => 'Nueva Traducción Viviente', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          137 => array ('val' => 'NVI', 'altval' => '42', 'aval' => '0', 'desc' => 'Nueva Versión Internacional', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          138 => array ('val' => 'NVI-ARC', 'altval' => 'nvi-single', 'aval' => '16,40', 'desc' => 'Nueva Versión Internacional - Audio - Read by Rafael Cruz', 'nt' => '0', 'lv' => 'ES', 'audio' => '1', 'tv' => 'NVI'),
          139 => array ('val' => 'CST', 'altval' => 'CST', 'aval' => '0', 'desc' => 'Nueva Versión Internacional (Castilian)', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          140 => array ('val' => 'NR1994', 'altval' => 'NR1994', 'aval' => '0', 'desc' => 'Nuova Riveduta 1994', 'nt' => '0', 'lv' => 'IT', 'audio' => '0'),
          141 => array ('val' => 'NR2006', 'altval' => 'NR2006', 'aval' => '0', 'desc' => 'Nuova Riveduta 2006', 'nt' => '0', 'lv' => 'IT', 'audio' => '0'),
          142 => array ('val' => 'SVL', 'altval' => '44', 'aval' => '0', 'desc' => 'Nya Levande Bibeln', 'nt' => '0', 'lv' => 'SV', 'audio' => '0'),
          143 => array ('val' => 'OL', 'altval' => '37', 'aval' => '0', 'desc' => 'O Livro', 'nt' => '0', 'lv' => 'PT', 'audio' => '0'),
          144 => array ('val' => 'ERV-OR', 'altval' => 'ERV-OR', 'aval' => '0', 'desc' => 'Oriya Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'OR', 'audio' => '0'),
          145 => array ('val' => 'OJB', 'altval' => 'OJB', 'aval' => '0', 'desc' => 'Orthodox Jewish Bible', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          146 => array ('val' => 'PDT', 'altval' => 'PDT', 'aval' => '0', 'desc' => 'Palabra de Dios para Todos', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          147 => array ('val' => 'VFL', 'altval' => 'VFL', 'aval' => '0', 'desc' => 'Portuguese New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'PT', 'audio' => '0'),
          148 => array ('val' => 'ERV-PA', 'altval' => 'ERV-PA', 'aval' => '0', 'desc' => 'Punjabi Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'PA', 'audio' => '0'),
          149 => array ('val' => 'QUT', 'altval' => '111', 'aval' => '0', 'desc' => 'Quiché, Centro Occidental (NT)', 'nt' => '1', 'lv' => 'QUT', 'audio' => '0'),
          150 => array ('val' => 'R1933', 'altval' => 'R1933', 'aval' => '0', 'desc' => 'Raamattu 1933/38', 'nt' => '0', 'lv' => 'FI', 'audio' => '0'),
          151 => array ('val' => 'REIMER', 'altval' => '56', 'aval' => '0', 'desc' => 'Reimer 2001', 'nt' => '1', 'lv' => 'NDS', 'audio' => '0'),
          152 => array ('val' => 'REIMER-AER', 'altval' => 'reimer-reimer', 'aval' => '9,33', 'desc' => 'Reimer 2001 (NT) - Audio - Read by Elmer Reimer', 'nt' => '1', 'lv' => 'NDS', 'audio' => '1', 'tv' => 'NDS'),
          153 => array ('val' => 'RVC', 'altval' => 'RVC', 'aval' => '0', 'desc' => 'Reina Valera Contemporánea', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          154 => array ('val' => 'RVR1960', 'altval' => '60', 'aval' => '0', 'desc' => 'Reina-Valera 1960', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          155 => array ('val' => 'RVR1977', 'altval' => 'RVR1977', 'aval' => '0', 'desc' => 'Reina-Valera 1977', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          156 => array ('val' => 'RVR1995', 'altval' => '61', 'aval' => '0', 'desc' => 'Reina-Valera 1995', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          157 => array ('val' => 'RVA', 'altval' => '6', 'aval' => '0', 'desc' => 'Reina-Valera Antigua', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          158 => array ('val' => 'RSV', 'altval' => 'RSV', 'aval' => '0', 'desc' => 'Revised Standard Version (with Apocrypha)', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          159 => array ('val' => 'RSVCE', 'altval' => 'RSVCE', 'aval' => '0', 'desc' => 'Revised Standard Version Catholic Edition', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          160 => array ('val' => 'ERV-RU', 'altval' => 'ERV-RU', 'aval' => '0', 'desc' => 'Russian New Testament: Easy-to-Read Version (NT)', 'nt' => '0', 'lv' => 'RU', 'audio' => '0'),
          161 => array ('val' => 'RUSV', 'altval' => '13', 'aval' => '0', 'desc' => 'Russian Synodal Version', 'nt' => '0', 'lv' => 'RU', 'audio' => '0'),
          162 => array ('val' => 'SBLGNT', 'altval' => 'SBLGNT', 'aval' => '0', 'desc' => 'SBL Greek New Testament (NT)', 'nt' => '1', 'lv' => 'GRC', 'audio' => '0'),
          163 => array ('val' => 'SCH1951', 'altval' => 'SCH1951', 'aval' => '0', 'desc' => 'Schlachter 1951', 'nt' => '0', 'lv' => 'DE', 'audio' => '0'),
          164 => array ('val' => 'SCH2000', 'altval' => 'SCH2000', 'aval' => '0', 'desc' => 'Schlachter 2000', 'nt' => '0', 'lv' => 'DE', 'audio' => '0'),
          165 => array ('val' => 'SG21', 'altval' => 'SG21', 'aval' => '0', 'desc' => 'Segond 21', 'nt' => '0', 'lv' => 'FR', 'audio' => '0'),
          166 => array ('val' => 'ERV-SR', 'altval' => 'ERV-SR', 'aval' => '0', 'desc' => 'Serbian New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'SR', 'audio' => '0'),
          167 => array ('val' => 'SNC', 'altval' => '29', 'aval' => '0', 'desc' => 'Slovo na cestu (NT)', 'nt' => '1', 'lv' => 'CS', 'audio' => '0'),
          168 => array ('val' => 'SZ', 'altval' => '39', 'aval' => '0', 'desc' => 'Slovo Zhizny', 'nt' => '0', 'lv' => 'RU', 'audio' => '0'),
          169 => array ('val' => 'SZ-PL', 'altval' => 'SZ-PL', 'aval' => '0', 'desc' => 'Slowo Zycia (NT)', 'nt' => '1', 'lv' => 'PL', 'audio' => '0'),
          170 => array ('val' => 'SOM', 'altval' => 'SOM', 'aval' => '0', 'desc' => 'Somali Bible', 'nt' => '0', 'lv' => 'SO', 'audio' => '0'),
          171 => array ('val' => 'SV1917', 'altval' => '7', 'aval' => '0', 'desc' => 'Svenska 1917', 'nt' => '0', 'lv' => 'SV', 'audio' => '0'),
          172 => array ('val' => 'SFB', 'altval' => 'SFB', 'aval' => '0', 'desc' => 'Svenska Folkbibeln', 'nt' => '0', 'lv' => 'SV', 'audio' => '0'),
          173 => array ('val' => 'ERV-TA', 'altval' => 'ERV-TA', 'aval' => '0', 'desc' => 'Tamil Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'TA', 'audio' => '0'),
          174 => array ('val' => 'TNCV', 'altval' => 'TNCV', 'aval' => '0', 'desc' => 'Thai New Contemporary Bible', 'nt' => '0', 'lv' => 'TH', 'audio' => '0'),
          175 => array ('val' => 'ERV-TH', 'altval' => 'ERV-TH', 'aval' => '0', 'desc' => 'Thai New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'TH', 'audio' => '0'),
          176 => array ('val' => 'MSG', 'altval' => '65', 'aval' => '0', 'desc' => 'The Message', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),  
          177 => array ('val' => 'VOICE', 'altval' => 'VOICE', 'aval' => '0', 'desc' => 'The Voice', 'nt' => '0', 'lv' => 'EN', 'audio' => '0'),
          178 => array ('val' => 'WLC', 'altval' => '81', 'aval' => '0', 'desc' => 'The Westminster Leningrad Codex (OT)', 'nt' => '2', 'lv' => 'HE', 'audio' => '0'),
          179 => array ('val' => 'TLA', 'altval' => 'TLA', 'aval' => '0', 'desc' => 'Traducción en lenguaje actual', 'nt' => '0', 'lv' => 'ES', 'audio' => '0'),
          180 => array ('val' => 'UKR', 'altval' => '27', 'aval' => '0', 'desc' => 'Ukrainian Bible', 'nt' => '0', 'lv' => 'UK', 'audio' => '0'),
          181 => array ('val' => 'ERV-UK', 'altval' => 'ERV-UK', 'aval' => '0', 'desc' => 'Ukrainian New Testament: Easy-to-Read Version (NT)', 'nt' => '1', 'lv' => 'UK', 'audio' => '0'),
          182 => array ('val' => 'ESV-UR', 'altval' => 'ERV-UR', 'aval' => '0', 'desc' => 'Urdu Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'UR', 'audio' => '0'),
          183 => array ('val' => 'USP', 'altval' => '113', 'aval' => '0', 'desc' => 'Uspanteco Bible (NT)', 'nt' => '1', 'lv' => 'USP', 'audio' => '0'),
          184 => array ('val' => 'BPT', 'altval' => 'BPT', 'aval' => '0', 'desc' => 'Vietnamese Bible: Easy-to-Read Version', 'nt' => '0', 'lv' => 'VI', 'audio' => '0'),
          185 => array ('val' => 'WE', 'altval' => '73', 'aval' => '0', 'desc' => 'Worldwide English (NT)', 'nt' => '1', 'lv' => 'EN', 'audio' => '0'),
          186 => array ('val' => 'WYC', 'altval' => '53', 'aval' => '0', 'desc' => 'Wycliffe Bible (NT)', 'nt' => '1', 'lv' => 'EN', 'audio' => '0'),
          187 => array ('val' => 'YLT', 'altval' => '15', 'aval' => '0', 'desc' => 'Young\'s Literal Translation', 'nt' => '0', 'lv' => 'EN', 'audio' => '0')
          );
    $dictionaries = array (
          1 => array ('val' => '1', 'desc' => ''.JText::_('LWSELECTDICT1').''),
          2 => array ('val' => '2', 'desc' => ''.JText::_('LWSELECTDICT2').''),
          3 => array ('val' => '3', 'desc' => ''.JText::_('LWSELECTDICT3').'')
          );
    $matchcriteria = array (
          1 => array ('val' => 'all', 'desc' => ''.JText::_('LWSELECTCRIT1').''),
          2 => array ('val' => 'any', 'desc' => ''.JText::_('LWSELECTCRIT2').''),
          3 => array ('val' => 'exact', 'desc' => ''.JText::_('LWSELECTCRIT3').'')
          );
    $commentators = array (
          1 => array ('val' => 'calvin', 'desc' => 'John Calvin'),
          2 => array ('val' => 'darby', 'desc' => 'John Darby'),
          3 => array ('val' => 'geneva', 'desc' => 'Geneva Study Bible'),
          4 => array ('val' => 'gill', 'desc' => 'John Gill'),
          5 => array ('val' => 'jfb', 'desc' => 'Jamieson, Faussett, and Brown'),
          6 => array ('val' => 'mh', 'desc' => 'Matthew Henry'),
          7 => array ('val' => 'mhc', 'desc' => 'Matthew Henry Concise'),
          8 => array ('val' => 'wesley', 'desc' => 'John Wesley')
          );
    $db = JFactory::getDBO();
    $db->setQuery("SELECT * FROM #__livingword_plans WHERE published=1 ORDER BY id");
    $bible_plan = $db->loadObjectList();    
  }
  function LWgetItemid() {
    $component	= JComponentHelper::getComponent('com_livingword');
 		$app = JFactory::getApplication();
 		$menus = $app->getMenu();
 		$menu = $menus->getActive();
   	$itemid = $menu->id;
    return $itemid;
  }
  function LWgetLang($bv){
    global $bible_version;
    $this->LWgetPrefOptions();
    $keyarr = $this->lw_array_search_recursive($bv, $bible_version);
    $key = $keyarr[0];
    $langfile = $bible_version[$key]['lv'];
    return strtolower($langfile);
  }
  function LWgetNT($bv){
    global $bible_version;
    $this->LWgetPrefOptions();
    $keyarr = $this->lw_array_search_recursive($bv, $bible_version);
    $key = $keyarr[0];
    $nt = $bible_version[$key]['nt'];
    return $nt;
  }
  function LWgetAudio($bv){
    global $bible_version;
    $this->LWgetPrefOptions();
    $keyarr = $this->lw_array_search_recursive($bv, $bible_version);
    $key = $keyarr[0];
    $audio = $bible_version[$key]['aval'];
    return $audio;
  }
  function LWgetAudioTV($bv){
    global $bible_version;
    $this->LWgetPrefOptions();
    $keyarr = $this->lw_array_search_recursive($bv, $bible_version);
    $key = $keyarr[0];
    $tv = "";
    if(isset($bible_version[$key]['tv'])) $tv = $bible_version[$key]['tv'];
    return $tv;
  }
  function LWgetLangAudio($avstr){
     $lwalangarray = array (
          1 => array('booknum' => '1','lang' => 'EN'),
          2 => array('booknum' => '2','lang' => 'EN'),
          3 => array('booknum' => '3','lang' => 'EN'),
          4 => array('booknum' => '6','lang' => 'ES'),
          5 => array('booknum' => '7','lang' => 'EN'),
          6 => array('booknum' => '8','lang' => 'EN'),
          7 => array('booknum' => '15','lang' => 'EN'));
    $av = preg_split('/,/', $avstr, -1, PREG_SPLIT_NO_EMPTY);
    $keyarr = $this->lw_array_search_recursive($av[0], $lwalangarray);
    $key = $keyarr[0];
    $langfile = $lwalangarray[$key]['lang'];
    return $langfile;
  }
  function lw_array_search_recursive( $needle, $haystack )
  {
     $path = NULL;
     $keys = array_keys($haystack);
     while (!$path && (list($toss,$k ) = each($keys))) {
        $v = $haystack[$k];
        if (is_scalar($v)) {
           if (strtolower($v) === strtolower($needle)) {
              $path = array($k);
           }
        } elseif (is_array($v)) {
           if ($path = $this->lw_array_search_recursive( $needle, $v )) {
              array_unshift($path,$k);
           }
        }
     }
     return $path;
  }
  function writeLWHeader($pagetitle,$pagemsg) {
    global $lwConfig;
    $config_show_menu = $lwConfig['config_show_menu'];
    echo '<div class="componentheading"><h2>'.JText::_('LWTITLE').' - '.$pagetitle.'</h2></div>';
    if($config_show_menu){
    $this->buildLWMenu();
    }
    $this->writeLWImageDIV();
    echo '<div class="msg">'.html_entity_decode($pagemsg).'</div><br />';
    echo '<br />';
  }
  function writeLWFooter(){
    global $lwConfig;
    $JVersion = new JVersion();
    $config_show_credit = $lwConfig['config_show_credit'];
		$config_show_rss = $lwConfig['config_show_rss'];
    if($config_show_credit){
      echo '<br /><div style="text-align:center;"><small>';
      echo JText::_('LWBROUGHTBYML');
      echo '<a href="http://www.mlwebtechnologies.com/" target="_blank" title="MLWebTechnologies">MLWebTechnologies</a><br />';
      echo JText::_('LWBROUGHTBYBG'); 
      echo '<a href="http://www.biblegateway.com/" target="_blank" title="BibleGateway">BibleGateway</a>,&nbsp;';
      echo '<a href="http://www.ewordtoday.com/" target="_blank" title="EWordToday">EWordToday</a>,&nbsp;&nbsp;';
      echo '<a href="http://www.biblica.com/" target="_blank" title="Biblica">Biblica</a>,&nbsp;&&nbsp;';
      echo '<a href="http://www.studylight.org/" target="_blank" title="StudyLight">StudyLight</a></small></div>';
    }
    if($config_show_rss){
   		$rss_img =  JHTML::_('image', JURI::base().'media/system/images/livemarks.png', htmlentities(JText::_('USRLLWFEEDS')), 'style="border:0;margin-right:2px;"');
    	$rss_link = JRoute::_('index.php?option=com_livingword&amp;task=rss');
      ?><br />
    	<div style="text-align:right;"><a href="<?php echo  $rss_link ; ?>" target="_blank" title="<?php echo htmlentities(JText::_('USRLLWFEEDS'));?>">
    	<?php echo $rss_img; ?></a></div><br /><br />
    	<?php
    }
  }
  function buildLWMenu(){
    global $lwConfig;
    $itemid = $this->LWgetItemid();
    $reslink = JRoute::_( "index.php?option=com_livingword&task=resources&Itemid=".$itemid);
    $settingslink = JRoute::_( "index.php?option=com_livingword&task=settings&Itemid=".$itemid);
    $toolslink = JRoute::_( "index.php?option=com_livingword&task=tools&Itemid=".$itemid);
    $homelink = JRoute::_( "index.php?option=com_livingword&Itemid=".$itemid);
    $resalt = JText::_('LWRESOURCES');
    $setalt = JText::_('LWPSET');
    $homealt = JText::_('LWHOMEM');
    $toolsalt = JText::_('LWTOOLS');
    $moduleclass_sfx = $lwConfig['config_moduleclass_sfx'];
    echo '<br /><div id="lw-menu" class="">';
      if($this->lw_rights->get('lw.home')){
        echo '<div align="left">
            <a class="mainlevel'.$moduleclass_sfx.'" href="'.$homelink.'" >'.$homealt.'</a></div>';
      }
      if($this->lw_rights->get('lw.link')){
        echo '<div align="left">
            <a class="mainlevel'.$moduleclass_sfx.'" href="'.$reslink.'" >'.$resalt.'</a></div>';
      }
      if($this->lw_rights->get('lw.settings')){
        echo '<div align="left">
            <a class="mainlevel'.$moduleclass_sfx.'" href="'.$settingslink.'" >'.$setalt.'</a></div>';
      }
      if($this->lw_rights->get('lw.tools')){
        echo '<div align="left">
            <a class="mainlevel'.$moduleclass_sfx.'" href="'.$toolslink.'" >'.$toolsalt.'</a></div>';
      }
    echo '</div>';
  }
  function readingCurDate($bplan,$startdate='0000-00-00',$offset=0,$plugin=false){
    global $lwConfig;
    if($startdate == 'raw'){
      $raw = true;
    } else {
      $raw = false;
    }
   	$db	= JFactory::getDBO();
    if(!$plugin){
      $user = JFactory::getUser();
      $db->setQuery("SELECT startdate,dateoffset FROM #__livingword WHERE userid='".(int)$user->id."'");
      $result = $db->loadObjectList();
      if(count($result)){
        $offset = $result[0]->dateoffset;
        $startdate = $result[0]->startdate;
      } else {
        $startdate = $lwConfig['config_global_startdate'];
      }
      if($raw == true){
        return $startdate;
      }
    }
    $now = date("m-d-Y");
    $today = date("z");
    $db->setQuery("SELECT COUNT(*) FROM #__livingword_plans_details WHERE plan='".$bplan."'");
    $d = $db->loadResult();
    if(!$offset && $startdate == '0000-00-00' && $d == 365) {
      return date("z");
    } elseif(!$offset && $startdate == '0000-00-00') {
      if((date("z")) < $d) {
        return date("z");
      } else {
        $e = floor((date("z"))/$d);
        return (date("z"))-($d*$e);
        }
      }
    if($startdate != '0000-00-00') {
     $mystartdiff = $this->dateDiff("-",$now,date("m-d-Y",strtotime($startdate)));
     while ($mystartdiff > $d){
       $mystartdiff = $mystartdiff - $d;
     }
     $mystartdate = 0;
     return $mystartdate + $mystartdiff + $offset;
    }
  }
  function dateDiff($dformat, $endDate, $beginDate){
    $date_parts1 = explode($dformat, $beginDate);
    $date_parts2 = explode($dformat, $endDate);
    $start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
    $end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
    $finaldate = $end_date - $start_date;
    return $finaldate;
  }
  function writeLWImageDIV(){
    echo '<div class="lwimage">
            <img src="components/com_livingword/assets/images/bible.jpg" />
        </div>';
  }
  function linkTarget($linkarray){
    $windowopen = "window.open(this.href,this.target,'toolbar=no,location=no,status=no,scrollbars=1,resizable=1,left=110,top=100,width=800,height=500'); return false";
		switch ($linkarray)
		{
			case 1:
				// open in a new window
				$linktarget = 'target="_blank"';
				break;
			case 2:
				// open in a popup window
				$linktarget = 'onclick="'.$windowopen.'"';
				break;
			default:
				// open in parent window
				$linktarget = 'target="_self"';
				break;
		}
    return $linktarget;
  }
	function LWcalendar($value, $name, $id, $filter)
  {
//		$config = JFactory::getConfig();
//		$user = JFactory::getUser();
    $format = '%Y-%m-%d';
//    $useroffset = timezone_offset_get( new DateTimeZone( $user->getParam('timezone') ), new DateTime() );
//    $offset = abs( $useroffset / 3600 );
		$attribs['size'] = '10';
		$attribs['onchange'] = 'var selObj=document.getElementById(\'altselectoffset\');selObj.selectedIndex=0;document.settingspage.selectoffset.value=0;this.hide();';
/*		if(!isset($value)){
      if($filter && !is_null($user->getParam('timezone'))){
    		$date = JFactory::getDate($value, 'UTC');
    		$date->setTimezone(new DateTimeZone($user->getParam('timezone', $offset)));
    		$value = $date->format('Y-m-d', true, false);
  		} else {
  			$date = JFactory::getDate($value, 'UTC');
  			$date->setTimezone(new DateTimeZone($config->get('offset')));
  			$value = $date->format('Y-m-d', true, false);
  		}
    }*/
    // Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);
    return JHtml::_('calendar', $value, $name, $id, $format, $attribs);
  }
	function getEBibles(){
       $lwebiblearray = array (
          1 => array('desc' => 'Amharic Bible','val' => 'amharic'),
          2 => array('desc' => 'Arabic Bible: Book of Life','val' => 'arabic'),
          3 => array('desc' => 'Cebuano Bible','val' => 'cebuano'),
          4 => array('desc' => 'Chinese Contemporary Bible (2010)','val' => 'ccb'),
          5 => array('desc' => 'Chinese Union Bible (1919)','val' => 'chinese'),
          6 => array('desc' => 'Czech: Slovo na cestu','val' => 'czech'),
          7 => array('desc' => 'Ewé','val' => 'ewe'),
          8 => array('desc' => 'French Bible: La Bible du Semeur','val' => 'french'),
          9 => array('desc' => 'German: Hoffnung für Alle','val' => 'german'),
          10 => array('desc' => 'Hiligaynon Bible','val' => 'hiligaynon'),
          11 => array('desc' => 'Italian Bible: La Parola è Vita','val' => 'italian'),
          12 => array('desc' => 'Japanese Living Bible','val' => 'japanese'),
          13 => array('desc' => 'Kiswahili - Swahili Bible','val' => 'swahili'),
          14 => array('desc' => 'Korean Living Bible','val' => 'korean'),
          15 => array('desc' => 'Kurdish Bible','val' => 'kurdish'),
          16 => array('desc' => 'Luo Bible ','val' => 'luo'),
          17 => array('desc' => 'Malayalam Bible','val' => 'malayalam'),
          18 => array('desc' => 'Ndebele Bible','val' => 'ndebele'),
          19 => array('desc' => 'Nepali Bible','val' => 'nepali'),
          20 => array('desc' => 'New Urdu Bible Version (NUBV)','val' => 'urdu'),
          21 => array('desc' => 'Norwegian: Levande Bibeln','val' => 'norwegian'),
          22 => array('desc' => 'Oromo Bible','val' => 'oromo'),
          23 => array('desc' => 'Persian / Farsi Bible','val' => 'farsi'),
          24 => array('desc' => 'Portuguese Brazilian: Nova Versão Internacional ','val' => 'portuguese-brazil'),
          25 => array('desc' => 'Portuguese European: O Livro Português ','val' => 'portuguese_europe'),
          26 => array('desc' => 'Russian Bible: Slovo Zhizny','val' => 'russian'),
          27 => array('desc' => 'Shona Bible','val' => 'shona'),
          28 => array('desc' => 'Swedish Bible: Levande Bibeln','val' => 'swedish'),
          29 => array('desc' => 'Thai Bible','val' => 'thai'),
          30 => array('desc' => 'Vietnamese Bible','val' => 'vietnamese'));
    return $lwebiblearray;
  }
  function LWkeephtml($string){
    $res = htmlentities($string);
    $res = str_replace("&lt;","<",$res);
    $res = str_replace("&gt;",">",$res);
    $res = str_replace("&quot;",'"',$res);
    $res = str_replace("&amp;",'&',$res);
    return $res;
  }
  function LWmatchBookName(&$rmatch){
    $rreadingmatch = ucwords(JText::_($rmatch[1]));
    $reading_str = $rreadingmatch.' '.$rmatch[2];
    return $reading_str;
  }
  function LWGetUserData($plugin=false) {
    global $lwConfig;
    $UserDataArray = array();
    $db	= JFactory::getDBO();
    if($plugin) {
      $db->setQuery("SELECT a.*, b.name, b.email AS emailaddr FROM #__livingword AS a LEFT JOIN #__users AS b ON (a.userid=b.id AND a.email='1')");
      $mysettings = $db->loadObjectList();
      return $mysettings;
    }
    $user = JFactory::getUser();
    $sql = $db->setQuery("SELECT * FROM #__livingword WHERE userid='".(int)$user->id."'");
    $mysettings = $db->loadObject();
    $mycounts = count($mysettings);
    if($mycounts < 1){
      $UserDataArray['bplan'] = $lwConfig['config_bible_plan'];
      $UserDataArray['bversion'] = $lwConfig['config_bible_version'];
      $UserDataArray['pbversion'] = $lwConfig['config_parallel_bible_version'];
    } else {
      $UserDataArray['bplan'] = $mysettings->bibleplan;
      $UserDataArray['bversion'] = $mysettings->bibleversion;
      $UserDataArray['pbversion'] = $mysettings->pbversion;
    }
    return $UserDataArray;
  }
  function LWGetPlanData($bplansql=null){
    $db	= JFactory::getDBO();
    $db->setQuery("SELECT * FROM #__livingword_plans_details WHERE plan='".$bplansql."' ORDER BY ordering");
    $chplan = $db->loadObjectList();
    return $chplan;  
  }
  function LWGetPlanCount($plan){
    $db	= JFactory::getDBO();
    $db->setQuery("SELECT COUNT(*) FROM #__livingword_plans_details WHERE plan='".$plan."'");
    $plancount = $db->loadResult();
    return $plancount;  
  }
  function LWGetReadingLink($plugin=false,$specdate=null,$cal=false){
    global $lwConfig;
    $user = JFactory::getUser();
    $audlink = "";
    $rlink = "";
    $reading_array = array();
    $UserDataArray = $this->LWGetUserData(false);
    $lang = JFactory::getLanguage();
    $langfile = $this->LWgetLang($UserDataArray['bversion']);
    $lang->load( 'com_livingword_biblebooks', JPATH_ROOT.'/components/com_livingword/assets', $langfile); 
    $bplan = $UserDataArray['bplan'];
    $bversion = $UserDataArray['bversion'];
    $pbversion = "";
    if(!is_numeric($UserDataArray['pbversion'])) $pbversion = ';'.$UserDataArray['pbversion'];
    $config_altaudio_version = $lwConfig['config_altaudio_version'];
    $bplansql = $bplan;
    $chplan = $this->LWGetPlanData($bplansql);
    if($lwConfig['config_use_gb']) {
      JHtml::_('behavior.modal');
      $linkattribs['class']='modal';
      $linkattribs['rel'] = "{handler: 'iframe', size: {x: 800, y: 500}}";
      $alinkattribs['class'] = 'modal'; 
      $alinkattribs['rel'] = "{handler: 'iframe', size: {x: 400, y: 200}}";
    } else {
      $linkattribs['onclick'] = "window.open(this.href,this.target,'width=800,height=500,scrollbars=1');return false;";
      $alinkattribs['onclick'] = "window.open(this.href,this.target,'width=400,height=200');return false;";
    }
    $show_audio = $lwConfig['config_show_audio'];
    if($lwConfig['config_show_bookmarks']){
      $langparams		= $user->getParameters(true);
      $userfelang = $langparams->get( 'language' );
      if(!empty($userfelang)){
        preg_match("#([a-zA-Z])[^-]#",$userfelang,$felangmatches);
        $bmlang = $felangmatches[0];
      } else {
        $langclient	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
        $langparams = JComponentHelper::getParams('com_languages');
        $defaultfelang = $langparams->get($langclient->name, 'en-GB');
        preg_match("#([a-zA-Z])[^-]#",$defaultfelang,$felangmatches);
        $bmlang = $felangmatches[0];
      }
    }
    $audio_version = $this->LWgetAudio($bversion);
    if($config_altaudio_version) $altaudioversion = $this->LWgetAudio($config_altaudio_version);
    $audio_text_version = $this->LWgetAudioTV($bversion);
    if($audio_text_version) $bversion = $audio_text_version;
    if($audio_version || $altaudioversion){
     $curdate = $this->readingCurDate($bplan);
     $d = $curdate;
     if(!empty($chplan[$d]->audio)){
      if(!is_null($specdate)) $d = $specdate;
      $aversion = explode(",",$audio_version);
      if($altaudioversion) $aversion = explode(",",$altaudioversion);
      $source = $aversion[0];
      $aid = $aversion[1];
      $alink = explode(",",$chplan[$d]->audio);
      if($bplan != 'newtest') $astrg = explode(";",$chplan[358]->reading);
      $astrg = explode(";",$chplan[$d]->reading);
      $audio_link = "";
      $player = 'flash_play.php';
      $audio_link = JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'{QUERY}'), '{STRING}', $alinkattribs).'{BOOKMARK}';
      if($curdate == 358){
          $audio_link = "";
          $audio_link = JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2]), $astrg[0], $alinkattribs).'{BOOKMARK}';
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5]), $astrg[1], $alinkattribs).'{BOOKMARK}';
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8]), $astrg[2], $alinkattribs).'{BOOKMARK}';
        }
        if($bplan == 'ontp'){
          $audio_link = JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2]), $astrg[0], $alinkattribs).'{BOOKMARK}';
          if($d != 40 && $d != 222){
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5]), $astrg[1], $alinkattribs).'{BOOKMARK}';
          }
          if($d == 170 || $d == 353){
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8]), $astrg[2], $alinkattribs).'{BOOKMARK}';
          }
        }
        if($bplan == 'chron'){
          $audio_link = JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2]), $astrg[0], $alinkattribs).'{BOOKMARK}';
          if($d == 192 || $d == 196 || $d == 268 || $d == 329 || $d == 335 || $d == 353 || $d == 360){
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[3].'&chapter='.$alink[4].'&end_chapter='.$alink[5]), $astrg[1], $alinkattribs).'{BOOKMARK}';
          }
          if($d == 360){
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[6].'&chapter='.$alink[7].'&end_chapter='.$alink[8]), $astrg[2], $alinkattribs).'{BOOKMARK}';
          $audio_link .= '</li><li>'.JHTML::_('link', JRoute::_('http://www.biblegateway.com/resources/audio/'.$player.'?source='.$source.'&aid='.$aid.'&book='.$alink[9].'&chapter='.$alink[10].'&end_chapter='.$alink[11]), $astrg[3], $alinkattribs).'{BOOKMARK}';
          }
        }
      $areading = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-\;]+)/', array( &$this, 'LWmatchBookName'), trim($chplan[$d]->reading) );
      $audio_link = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-\;]+)/', array( &$this, 'LWmatchBookName'), $audio_link );
      $audio_link = str_replace('{QUERY}', '&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2], $audio_link);
      $audio_link_img = $audio_link;
      if($plugin){ $audio_link = str_replace('{STRING}', JText::_('audio version'), trim($audio_link)); }
      $audio_link = str_replace('{STRING}', JText::_(htmlentities($areading)), trim($audio_link));
      if($lwConfig['config_show_bookmarks'] && !$show_audio && !$plugin){
        preg_match_all('#(?<=href=\")(.*?)(?=\")#',$audio_link,$reading_query);
        for($i=0;$i<count($reading_query[0]);$i++){
          $bookmark = ""; 
          $rlshare = $reading_query[0][$i];
          if(!$cal) $bookmark = '&nbsp;&nbsp;';
          $bookmark .= '<script type="text/javascript">var addthis_config={ui_language:"'.$bmlang.'",services_exclude:"print,email"};</script><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250" addthis:url="'.urldecode($rlshare).'" addthis:title="'.JText::_('LWTODAYSREADING').'-'.str_replace(";"," & ",$reading_str).'" style="text-decoration:none;"><img src="http://s7.addthis.com/static/btn/sm-plus.gif" width="11" height="11" border="0" title="'.JText::_('LWBMSHAREREADING').'" style="vertical-align:middle;" /></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>';
          $reading_array['bmimg'] = $bookmark;
          $audio_link = preg_replace("#{BOOKMARK}#",$bookmark,$audio_link,1);
        }
      } elseif(!$lwConfig['config_show_bookmarks'] || ($lwConfig['config_show_bookmarks'] && $show_audio) || $plugin) {
        $audio_link = str_replace("{BOOKMARK}","",$audio_link);
        $audio_link_img = str_replace("{BOOKMARK}","",$audio_link_img);
      }
      $rlink = str_replace('{QUERY}', '&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2], $audio_link);
      $reading_array['audlink'] = $rlink;
      if($show_audio && !$plugin && ($audio_text_version || $altaudioversion)){
        $audio_link_img = str_replace('{STRING}', '<img style="width:16px; height:9px;vertical-align:middle;" src="http://www.biblegateway.com/resources/audio/images/sound.gif" border="0" title="Play Audio" />', $audio_link_img);
        $reading_array['audimg'] = str_replace('{QUERY}', '&book='.$alink[0].'&chapter='.$alink[1].'&end_chapter='.$alink[2], $audio_link_img);
      } else {
        $reading_array['audimg'] = "";
      }
     }
    }
    if(!$audio_version || ($audio_text_version && $show_audio && $audio_version) || ($audio_text_version && $plugin && $audio_version)) {
      $curdate = $this->readingCurDate($bplan);
      if(!is_null($specdate)) $curdate = $specdate;
      $reading_link = JHTML::_('link', JRoute::_('http://www.biblegateway.com/passage/?search={QUERY};&version='.$bversion.$pbversion.'&interface=print'), '{STRING}', $linkattribs).'{BOOKMARK}';
      $reading_array['reading_str'] = preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-]+)/', array( &$this, 'LWmatchBookName'), trim($chplan[$curdate]->reading) );
      $reading_str = $reading_array['reading_str'];
      $reading_link = str_replace('{STRING}', $this->LWkeephtml(str_replace(";",",&nbsp;",$reading_str)), $reading_link);
      $rlink = str_replace('{QUERY}', urlencode($this->LWkeephtml($reading_str)), $reading_link);
      if($lwConfig['config_show_bookmarks'] && !$plugin){
        preg_match_all('#(?<=href=\")(.*?)(?=\")#',$rlink,$reading_query);
        for($i=0;$i<count($reading_query[0]);$i++){
          $bookmark = ""; 
          $rlshare = $reading_query[0][$i];
          if(!$cal) $bookmark = '&nbsp;&nbsp;';
          $bookmark .= '<script type="text/javascript">var addthis_config={ui_language:"'.$bmlang.'",services_exclude:"print,email"};</script><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250" addthis:url="'.urldecode($rlshare).'" addthis:title="'.JText::_('LWTODAYSREADING').'-'.str_replace(";"," & ",$reading_str).'" style="text-decoration:none;"><img src="http://s7.addthis.com/static/btn/sm-plus.gif" width="11" height="11" border="0" title="'.JText::_('LWBMSHAREREADING').'" style="vertical-align:middle;" /></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>';
          $reading_array['bmimg'] = $bookmark;
          if(!$cal){
            $rlink = preg_replace("#{BOOKMARK}#",$bookmark,$rlink,1);
          } else {
            $rlink = str_replace("{BOOKMARK}","",$rlink);
          }
        }
      } elseif(!$lwConfig['config_show_bookmarks'] || $plugin) {
        $rlink = str_replace("{BOOKMARK}","",$rlink);
      }
      if($show_audio && !$plugin && !$cal) $rlink .= '&nbsp;'.$reading_array['audimg'];
    }
    $reading_array['rlink'] = $rlink;
    return $reading_array;  
  }
}  
?>