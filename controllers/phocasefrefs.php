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

class PhocaCpControllerPhocaSefRefs extends PhocaCpController
{
	function __construct() {
		parent::__construct();
		// Register Extra tasks
	
		$this->registerTask( 'purge'  , 'purge' );
	}
	
	
	function purge() {
		$model = $this->getModel( 'phocasefrefs' );

		//parent::display();
		if ($model->purge($post)) {
			$msg = JText::_( 'All Referring Sites Removed' );
		} else {
			$msg = JText::_( 'Error Removing All Referring Sites' );
		}
		$this->setRedirect( 'index.php?option=com_phocasef&view=phocasefrefs', $msg );

	}

	function remove()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		$model = $this->getModel( 'phocasefrefs' );
		if(!$model->delete($cid))
		{
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca SEF Referring site(s)' );
		}
		else {
			$msg = JText::_( 'Phoca SEF Referring site(s) Deleted' );
		}

		$link = 'index.php?option=com_phocasef&view=phocasefrefs';
		$this->setRedirect( $link, $msg );
	}

}
?>
