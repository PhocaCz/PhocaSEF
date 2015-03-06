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

class PhocaCpViewPhocaSefUrl extends JView
{

	function display($tpl = null) {
		global $mainframe;
		
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayForm($tpl) {
		global $mainframe, $option;
		
		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		
		$phocasef	=& $this->get('Data');
		
		
		
		$lists = array();		
		$isNew		= ($phocasef->id < 1);

/*		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'Phoca SEF' ), $phocasef->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}*/

		JHTML::stylesheet( 'phocasef.css', 'administrator/components/com_phocasef/assets/' );
		// Set toolbar items for the page
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Phoca SEF Redirect Site' ).': <small><small>[ ' . $text.' ]</small></small>', 'red' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		

		// Edit or Create?
		if (!$isNew) {
			//$model->checkout( $user->get('id') );
		} else {
			// initialise new record
			$phocasef->published 	= 1;
			$phocasef->order 		= 0;
			$phocasef->access			= 0;
			$phocasef->catid 		= JRequest::getVar( 'catid', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, old_url AS text'
			. ' FROM #__phocasef_url'
			. ' ORDER BY ordering';
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $phocasef, $phocasef->id, $query, false );

		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $phocasef->published );

		
		
	
	
		//clean component data
		jimport('joomla.filter.output');
	
		$this->assignRef('lists', $lists);
		$this->assignRef('phocasef', $phocasef);
		$this->assignRef('request_url',	$uri->toString());
		parent::display($tpl);
	
	}
}
?>
