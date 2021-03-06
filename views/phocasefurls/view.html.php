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
jimport( 'joomla.application.component.view' );
 
class PhocaCpViewPhocaSefUrls extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();

		JHTML::stylesheet( 'phocasef.css', 'administrator/components/com_phocasef/assets/' );
		// Set toolbar items for the page
		JToolBarHelper::title(   JText::_( 'Phoca SEF Redirect Site' ), 'red' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList(  JText::_( 'WARNWANTDELLISTEDITEMS' ), 'remove', 'delete');
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Custom', '<a href="#" onclick="javascript:if(confirm(\''.JText::_('REALLY REMOVE ALL OBSOLETE SITES').'\')){submitbutton(\'purge\')};" class="toolbar"><span class="icon-32-purge" title="'.JText::_('Purge').'" type="Custom"></span>'.JText::_('Purge').'</a>');	
	//	JToolBarHelper::deleteList(  JText::_( 'Really remove all not set items' ), 'purge', 'Purge');
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		
		JToolBarHelper::preferences('com_phocasef', '360');

		//Filter
		$context			= 'com_phocasef.phocasef.list.';

		$option				= JRequest::getCmd( 'option' );
		
		$filter_state		= $mainframe->getUserStateFromRequest( $context.'filter_state',		'filter_state',		'',				'word' );
		
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $context.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );

		// Get data from the model
		$items		= & $this->get( 'Data');
		$total		= & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );
		// build list of categories
		$javascript 	= 'class="inputbox" size="1" onchange="submitform( );"';
		
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;
		
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		
		parent::display($tpl);
	}
}
?>