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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class PhocaCpModelPhocaSefUrl extends JModel
{
	var $_id;
	var $_data;
	
	function __construct() {
		parent::__construct();
		
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData() {
		if ($this->_loadData()) {
			
		} else {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function isCheckedOut( $uid=0 ) {
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}
	
	function store($data)
	{
		$row =& $this->getTable();
		// Create the timestamp for the date
		$row->date_url = gmdate('Y-m-d H:i:s');
		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Do both path as the same : www...com/new == www...com/new/
		$row->old_url = rtrim($row->old_url, '/');
		
		if ($row->old_url == $row->new_url) {
			$this->setError($this->_db->getErrorMsg("Old and new file cannot be the same"));
			return false;
		}
		
		if ($row->old_url == rtrim($row->new_url, '/')) {
			$this->setError($this->_db->getErrorMsg("Old and new file cannot be the same"));
			return false;
		}
		
		// if new item, order last in appropriate group
		if (!$row->id) {
			$row->ordering = $row->getNextOrder( );
		}
		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Store the table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return $row->id;
	}
	
	

	function delete($cid = array()) {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		global $mainframe;
		$db =& JFactory::getDBO();
		
		$result = false;
	
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'DELETE FROM #__phocasef_url'
					. ' WHERE id IN ( '.$cids.' )';
				
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
			
		return true;
	}
	
	
	function purge() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		global $mainframe;
		$db =& JFactory::getDBO();
		
		$result = false;
	
		$query = 'DELETE FROM #__phocasef_url'
				. ' WHERE new_url =\'\' ';
				
		$db->setQuery( $query );
		if (!$db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}	
		return true;
	}

	function publish($cid = array(), $publish = 1)
	{
		$user 	=& JFactory::getUser();

		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocasef_url'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function move($direction) {
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$row->move( $direction, ' published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function saveorder($cid = array(), $order) {
		$row 	=& $this->getTable();
		$total	= count( $cid );

		// update ordering values
		for( $i=0; $i < $total; $i++ )
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		}
		$row->reorder( );
	}
	
	function _loadData() {
		if (empty($this->_data)) {		
			$query = 'SELECT a.* '.	
					' FROM #__phocasef_url AS a' .
					' WHERE a.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {
		if (empty($this->_data)) {
			$phocasef = new stdClass();
			$phocasef->id			= 0;
			$phocasef->cw			= 0;
			$phocasef->cr			= 0;
			$phocasef->new_url		= null;
			$phocasef->old_url		= null;
			$phocasef->date_url		= null;
			$phocasef->published	= 0;
			$phocasef->ordering		= 0;
			$this->_data			= $phocasef;
			return (boolean) $this->_data;
		}
		return true;
	}	
}
?>