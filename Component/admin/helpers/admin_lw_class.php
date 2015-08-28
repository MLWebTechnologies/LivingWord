<?php
/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
class livingwordadmin 
{
	public function addSubmenu2($vName = 'livingword')
	{
		JHtmlSidebar::addEntry(
			JText::_('CPanel'),
			'index.php?option=com_livingword',
			$vName == 'livingword'
		);
		JHtmlSidebar::addEntry(
			JText::_('Plans'),
			'index.php?option=com_livingword&task=manage_plans',
			$vName == 'manageplan'
		);
		JHtmlSidebar::addEntry(
			JText::_('Books'),
			'index.php?option=com_livingword&task=manage_books',
			$vName == 'managebooks'
		);
		JHtmlSidebar::addEntry(
			JText::_('Subscribers'),
			'index.php?option=com_livingword&task=manage_sub',
			$vName == 'managesub'
		);
		JHtmlSidebar::addEntry(
			JText::_('CSS'),
			'index.php?option=com_livingword&task=manage_css',
			$vName == 'managecss'
		);
		JHtmlSidebar::addEntry(
			JText::_('Links'),
			'index.php?option=com_livingword&task=manage_link',
			$vName == 'managelink'
		);
		JHtmlSidebar::addEntry(
			JText::_('Languages'),
			'index.php?option=com_livingword&task=manage_lang',
			$vName == 'managelang'
		);
	}
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$assetName = 'com_livingword';
		$level = 'component';
		$actions = JAccess::getActions('com_livingword', $level);
		foreach ($actions as $action) {
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}
		return $result;
	}
  function LWgetPrefOptions(){
    global $bible_version, $bible_plan;
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
    $db = JFactory::getDBO();
    $db->setQuery("SELECT * FROM #__livingword_plans WHERE published=1 ORDER BY id");
    $bible_plan = $db->loadObjectList();    
  }
  function LWgetLangCats(){
    $lang_cats = array(
          1 => array ('lang' => 'Amharic','lv' => 'AM'),
          2 => array ('lang' => 'Amuzgo Guerrero','lv' => 'AMU'),
          3 => array ('lang' => 'Awadhi','lv' => 'AWA'),
          4 => array ('lang' => 'Bulgarian','lv' => 'BG'),
          5 => array ('lang' => 'Chinanteco de Comaltepec','lv' => 'CCO'),
          6 => array ('lang' => 'Cebuano','lv' => 'CEB'),
          7 => array ('lang' => 'Cherokee','lv' => 'CHR'),
          8 => array ('lang' => 'Kaqchikel','lv' => 'CKW'),
          9 => array ('lang' => 'Czech','lv' => 'CS'),
          10 => array ('lang' => 'Danish','lv' => 'DA'),
          11 => array ('lang' => 'German','lv' => 'DE'),
          12 => array ('lang' => 'English','lv' => 'EN'),
          13 => array ('lang' => 'Spanish','lv' => 'ES'),
          14 => array ('lang' => 'Persian','lv' => 'FA'),
          15 => array ('lang' => 'Finnish','lv' => 'FI'),
          16 => array ('lang' => 'French','lv' => 'FR'),
          17 => array ('lang' => 'Greek','lv' => 'GRC'),
          18 => array ('lang' => 'Hebrew','lv' => 'HE'),
          19 => array ('lang' => 'Hindi','lv' => 'HI'),
          20 => array ('lang' => 'Hiligaynon','lv' => 'HIL'),
          21 => array ('lang' => 'Croatian','lv' => 'HR'),
          22 => array ('lang' => 'Haitian Creole','lv' => 'HT'),
          23 => array ('lang' => 'Hungarian','lv' => 'HU'),
          24 => array ('lang' => 'Hawai‘i Pidgin','lv' => 'HWC'),
          25 => array ('lang' => 'Icelandic','lv' => 'IS'),
          26 => array ('lang' => 'Japanese','lv' => 'JA'),
          27 => array ('lang' => 'Jakaltek','lv' => 'JAC'),
          28 => array ('lang' => 'Kekchi','lv' => 'KEK'),
          29 => array ('lang' => 'Korean','lv' => 'KO'),
          30 => array ('lang' => 'Kurdish','lv' => 'KU'),
          31 => array ('lang' => 'Latin','lv' => 'LA'),
          32 => array ('lang' => 'Dholuo','lv' => 'LUO'),
          33 => array ('lang' => 'Maori','lv' => 'MI'),
          34 => array ('lang' => 'Macedonian','lv' => 'MK'),
          35 => array ('lang' => 'Malayalam','lv' => 'ML'),
          36 => array ('lang' => 'Marathi','lv' => 'MR'),
          37 => array ('lang' => 'Mam, Central ','lv' => 'MVC'),
          38 => array ('lang' => 'Mam, Todos Santos','lv' => 'MVJ'),
          39 => array ('lang' => 'Low German','lv' => 'NDS'),
          40 => array ('lang' => 'Nepali','lv' => 'NE'),
          41 => array ('lang' => 'Nahuatl','lv' => 'NGU'),
          42 => array ('lang' => 'Dutch','lv' => 'NL'),
          43 => array ('lang' => 'Norwegian','lv' => 'NO'),
          44 => array ('lang' => 'Southern Ndebele','lv' => 'NR'),
          45 => array ('lang' => 'Oriya','lv' => 'OR'),
          46 => array ('lang' => 'West Central Oromo','lv' => 'ORM'),
          47 => array ('lang' => 'Punjabi','lv' => 'PA'),
          48 => array ('lang' => 'Polish','lv' => 'PL'),
          49 => array ('lang' => 'Pipil','lv' => 'PPL'),
          50 => array ('lang' => 'Portuguese','lv' => 'PT'),
          51 => array ('lang' => 'Quichua','lv' => 'QU'),
          52 => array ('lang' => 'Quiché','lv' => 'QUT'),
          53 => array ('lang' => 'Romanian','lv' => 'RO'),
          54 => array ('lang' => 'Russian','lv' => 'RU'),
          55 => array ('lang' => 'Slovak','lv' => 'SK'),
          56 => array ('lang' => 'Somali','lv' => 'SO'),
          57 => array ('lang' => 'Albanian','lv' => 'SQ'),
          58 => array ('lang' => 'Serbian','lv' => 'SR'),
          59 => array ('lang' => 'Swedish','lv' => 'SV'),
          60 => array ('lang' => 'Swahili','lv' => 'SW'),
          61 => array ('lang' => 'Tamil','lv' => 'TA'),
          62 => array ('lang' => 'Thai','lv' => 'TH'),
          63 => array ('lang' => 'Tagalog','lv' => 'TL'),
          64 => array ('lang' => 'Twi','lv' => 'TWI'),
          65 => array ('lang' => 'Ukrainian','lv' => 'UK'),
          66 => array ('lang' => 'Urdu','lv' => 'UR'),
          67 => array ('lang' => 'Vietnamese','lv' => 'VI'),
          68 => array ('lang' => 'Chinese','lv' => 'ZH')
          );
  }
  function LWparseXml($xmlfile){
      $data = "";
			if (file_exists($xmlfile)){
			$data = JApplicationHelper::parseXMLInstallFile($xmlfile);
			}
    return $data;
	}
	function lw_get_php_setting($val, $colour=0, $yn=1) {
		$r =  (ini_get($val) == '1' ? 1 : 0);
		if ($colour) {
			if ($yn) {
				$r = $r ? '<span style="color: green;">ON</span>' : '<span style="color: red;">OFF</span>';
			} else {
				$r = $r ? '<span style="color: red;">ON</span>' : '<span style="color: green;">OFF</span>';
			}
			return $r;
		} else {
			return $r ? 'ON' : 'OFF';
		}
	}
	function lw_get_server_software() {
		if (isset($_SERVER['SERVER_SOFTWARE'])) {
			return $_SERVER['SERVER_SOFTWARE'];
		} else if (($sf = phpversion() <= '4.2.1' ? getenv('SERVER_SOFTWARE') : $_SERVER['SERVER_SOFTWARE'])) {
			return $sf;
		} else {
			return 'n/a';
		}
	}
	function LWfooter() {
    $lang = Jfactory::getLanguage();
    $lang->load( 'com_livingword', JPATH_SITE); 
    include_once('components/com_livingword/helpers/lw_version.php');
    $lwversion = new LWVersion();
	  ?>
		<div align="center" class="small">
		  <a href="<?php echo $lwversion->getUrl()?>" target="_blank">LivingWord Component - <?php echo $lwversion->getShortCopyright();?></a>
		</div>
	  <?php
	}
  function checkutf8($lf)
  {
    $arr = array('ERV-AWA','ERV-AR','B21','ERV-RU','ERV-SR','ERV-TH','ERV-ZH','BG1940','CHR','TR1550','HHH','ICELAND','982','MAORI','ERV-MR','ERV-NE','NGU','ERV-OR','ERV-PA','NP','NBTN','ERV-TA','TNCV','UKR','ESV-UR','VIET','CCB');
    if(in_array($lf,$arr)) return true;
    return false;
  }
  function matchBookName(&$rmatch){
    global $lwConfig;
    $rreadingmatch = ucwords(JText::_($rmatch[1]));
    !$this->checkutf8($lwConfig['config_bible_version']) ? $reading_str = htmlentities(html_entity_decode($rreadingmatch)).' '.$rmatch[2] : $reading_str = $rreadingmatch.' '.$rmatch[2];
    return $reading_str;
  }
  function LWRedirect($str,$msg=null) {
		$app = JFactory::getApplication();
  	$app->redirect($str,$msg);
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
	function LWsideBar()
	{
		$lang	= JFactory::getLanguage();
    $user = JFactory::getUser();
    $version = new JVersion();
    include_once('components/com_livingword/helpers/lw_version.php');
    $lwversion = new LWVersion();
    $task = JRequest::getVar('task');
		if($user->authorise('core.admin')){?>
      <div class="row-fluid">
      	<div class="span2">
      		<div class="sidebar-nav">
      			<ul class="nav nav-list">
      				<li class="nav-header"><?php echo JText::_('SUBMENU'); ?></li>
      				<li class="<?php echo $task == '' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword"><?php echo JText::_('Dashboard'); ?></a></li>
      				<li class="<?php echo $task == 'manage_plans' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_plans"><?php echo JText::_('Manage Plans'); ?></a></li>
      				<li class="<?php echo $task == 'manage_books' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_books"><?php echo JText::_('Manage Bible Books'); ?></a></li>
      				<li class="<?php echo $task == 'manage_sub' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_sub"><?php echo JText::_('Manage Subscribers'); ?></a></li>
      				<li class="<?php echo $task == 'manage_css' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_css"><?php echo JText::_('Manage CSS'); ?></a></li>
      				<li class="<?php echo $task == 'manage_link' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_link"><?php echo JText::_('Manage Links'); ?></a></li>
      				<li class="<?php echo $task == 'manage_lang' ? 'active' : ''?>"><a href="<?php echo JURI::base(); ?>index.php?option=com_livingword&task=manage_lang"><?php echo JText::_('Manage Languages'); ?></a></li>
      			</ul>
      		</div>
      	<?php if($task != 'manage_lang') {
            echo '</div>'; 
          }
		}
	}
  function utf8dec( $s_String )
  {
    $s_String = htmlentities($s_String." ", ENT_COMPAT, 'UTF-8');
    return substr($s_String, 0, strlen($s_String)-1);
  }
  function customCharHandling($str,$bv){
    if($bv == 88) $str = str_replace("'",'%CB%88',$str);
    return $str;
  }
}
?>