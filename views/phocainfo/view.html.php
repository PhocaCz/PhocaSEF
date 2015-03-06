<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class PhocaCpViewPhocaInfo extends JView
{
	function display($tpl = null) {
		global $mainframe;
		JHTML::stylesheet( 'phocasef.css', 'administrator/components/com_phocasef/assets/' );
		JToolBarHelper::title(   JText::_( 'Phoca SEF Info' ), 'info' );
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'screen.phocasef', true );
		
		$version = PhocaSefHelper::getPhocaVersion();
		
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
	}
}
?>
