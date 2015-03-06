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

class PhocaCpControllerPhocaSefUrls extends PhocaCpController
{
	function __construct() {
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply'  , 'save' );
		$this->registerTask( 'purge'  , 'purge' );
	}
	
	
	function purge() {
		$model = $this->getModel( 'phocasefurl' );

		//parent::display();
		if ($model->purge($post)) {
			$msg = JText::_( 'Empty Obsolete Sites Removed' );
		} else {
			$msg = JText::_( 'Error Removing Empty Obsolete Sites' );
		}
		$this->setRedirect( 'index.php?option=com_phocasef&view=phocasefurls', $msg );

	}
	
	function edit() {
		JRequest::setVar( 'view', 'phocasefurl' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		$model = $this->getModel( 'phocasefurl' );
		//$model->checkout();
	}

	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] 			= (int) $cid[0];
		$model = $this->getModel( 'phocasefurl' );
		
		switch ( JRequest::getCmd('task') ) {
			case 'apply':
				$id	= $model->store($post);//you get id and you store the table data
				if ($id && $id > 0) {
					$msg = JText::_( 'CHANGES TO PHOCA SEF SITES SAVED' );
				} else {
					$msg = JText::_( 'Error Saving Phoca SEF Sites' );
					$id		= $post['id'];
				}
				$this->setRedirect( 'index.php?option=com_phocasef&controller=phocasefurls&task=edit&cid[]='. $id, $msg );
				break;

			case 'save':
			default:
				if ($model->store($post)) {
					$msg = JText::_( 'Phoca SEF Sites Saved' );
				} else {
					$msg = JText::_( 'Error Saving Phoca SEF Sites' );
				}
				$this->setRedirect( 'index.php?option=com_phocasef&view=phocasefurls', $msg );
				break;
		}
		
	}

	function remove()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		$model = $this->getModel( 'phocasefurl' );
		if(!$model->delete($cid))
		{
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca SEF Sites' );
		}
		else {
			$msg = JText::_( 'PHOCA SEF SITES DELETED' );
		}

		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect( $link, $msg );
	}

	function publish()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocasefurl');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect($link);
	}

	function unpublish()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocasefurl');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect($link);
	}

	function cancel()
	{
		$model = $this->getModel( 'phocadownloadsec' );
		

		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect( $link );
	}

	function orderup()
	{
		$model = $this->getModel( 'phocasefurl' );
		$model->move(-1);

		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect( $link );
	}

	function orderdown()
	{
		$model = $this->getModel( 'phocasefurl' );
		$model->move(1);

		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect( $link );
	}

	function saveorder()
	{
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocasefurl' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$link = 'index.php?option=com_phocasef&view=phocasefurls';
		$this->setRedirect( $link, $msg  );
	}
}
?>
