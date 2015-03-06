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

jimport('joomla.application.component.controller');

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
 if ($view == 'phocasef' || $view == 'phocacp') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocasef', true);
	JSubMenuHelper::addEntry(JText::_('Redirect Site'), 'index.php?option=com_phocasef&view=phocasefurls' );
	JSubMenuHelper::addEntry(JText::_('Referring Sites'), 'index.php?option=com_phocasef&view=phocasefrefs' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocasef&view=phocainfo' );
} else if ($view == 'phocasefurls') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocasef');
	JSubMenuHelper::addEntry(JText::_('Redirect Site'), 'index.php?option=com_phocasef&view=phocasefurls', true );
	JSubMenuHelper::addEntry(JText::_('Referring Sites'), 'index.php?option=com_phocasef&view=phocasefrefs' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocasef&view=phocainfo' );
}  else if ($view == 'phocasefrefs') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocasef');
	JSubMenuHelper::addEntry(JText::_('Redirect Site'), 'index.php?option=com_phocasef&view=phocasefurls' );
	JSubMenuHelper::addEntry(JText::_('Referring Sites'), 'index.php?option=com_phocasef&view=phocasefrefs', true );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocasef&view=phocainfo' );
} else if ($view == 'phocainfo') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocasef');
	JSubMenuHelper::addEntry(JText::_('Redirect Site'), 'index.php?option=com_phocasef&view=phocasefurls' );
	JSubMenuHelper::addEntry(JText::_('Referring Sites'), 'index.php?option=com_phocasef&view=phocasefrefs' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocasef&view=phocainfo', true );
} 

class PhocaCpController extends JController
{
	function display()
	{
		parent::display();
	}
}
?>
