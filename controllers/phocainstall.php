<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

class PhocaCpControllerPhocaInstall extends PhocaCpController
{
	function __construct() {
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );		
	}

	
	
	function install() {		
		$db			= &JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// ------------------------------------------
		// URL
		// ------------------------------------------
		
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'phocasef_url`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query=' CREATE TABLE `'.$dbPref.'phocasef_url`('."\n";
		$query.='  `id` int(11) NOT NULL auto_increment,'."\n";
		$query.='  `cw` int(11) NOT NULL default \'0\','."\n";
		$query.='  `cr` int(11) NOT NULL default \'0\','."\n";
		$query.='  `new_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `old_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `date_url` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.='  `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.='  `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.='  PRIMARY KEY  (`id`)'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// ------------------------------------------
		// REF
		// ------------------------------------------
		
		$query=' DROP TABLE IF EXISTS `'.$dbPref.'phocasef_ref`;'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query=' CREATE TABLE `'.$dbPref.'phocasef_ref` ('."\n";
		$query.='  `id` int(11) NOT NULL auto_increment,'."\n";
		$query.='  `count_url` int(11) NOT NULL default \'0\','."\n";
		$query.='  `ref_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `ref_to_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `date_url` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.='  `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.='  `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.='  PRIMARY KEY  (`id`)'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
		*/	
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca SEF not successfully installed' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca SEF successfully installed' );
		}
		
		$link = 'index.php?option=com_phocasef';
		$this->setRedirect($link, $msg);
	}
	
	
	function upgrade() {
		
		$db			=& JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// ------------------------------------------
		// URL
		// ------------------------------------------
		
		$query=' CREATE TABLE IF NOT EXISTS `'.$dbPref.'phocasef_url`('."\n";
		$query.='  `id` int(11) NOT NULL auto_increment,'."\n";
		$query.='  `cw` int(11) NOT NULL default \'0\','."\n";
		$query.='  `cr` int(11) NOT NULL default \'0\','."\n";
		$query.='  `new_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `old_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `date_url` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.='  `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.='  `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.='  PRIMARY KEY  (`id`)'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// ------------------------------------------
		// REF
		// ------------------------------------------

		
		$query=' CREATE TABLE IF NOT EXISTS `'.$dbPref.'phocasef_ref` ('."\n";
		$query.='  `id` int(11) NOT NULL auto_increment,'."\n";
		$query.='  `count_url` int(11) NOT NULL default \'0\','."\n";
		$query.='  `ref_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `ref_to_url` varchar(255) NOT NULL default \'\','."\n";
		$query.='  `date_url` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.='  `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.='  `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.='  PRIMARY KEY  (`id`)'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// CHECK TABLES
		
		$query =' SELECT * FROM `'.$dbPref.'phocasef_url` LIMIT 1;';
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		
		$query=' SELECT * FROM `'.$dbPref.'phocasef_ref` LIMIT 1;'."\n";
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		
		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
		*/	
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca SEF not successfully upgraded' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca SEF successfully upgraded' );
		}
		
		$link = 'index.php?option=com_phocasef';
		$this->setRedirect($link, $msg);
	}
	
}
// utf-8 test: ä,ö,ü,ř,ž
?>