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

class PhocaCpModelPhocaSefUrls extends JModel
{
	var $_data 					= null;
	var $_total 				= null;
	var $_pagination 			= null;

	function __construct()
	{
		parent::__construct();
		global $mainframe, $option;		
		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	function getData()
	{
		if (empty($this->_data)){
			$query 		 = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}	
		return $this->_data;
	}

	function getTotal()
	{
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	function getPagination()
	{
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}

	function _buildQuery() {	
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();

		$query = 'SELECT a.*, 0 AS checked_out'
		. ' FROM #__phocasef_url AS a'
		. $where
		. ' GROUP BY a.id'
		. $orderby;
		
		return $query;
	}
	
	
	function _buildContentOrderBy() {		
		global $mainframe;
		$context			= 'com_phocasef.phocasefurls.list.';
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY  a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order . ' ' . $filter_order_Dir .  ', a.ordering ';
		}
		return $orderby;
	}
	
	
	function _buildContentWhere() {
		global $mainframe;
		$context			= 'com_phocasef.phocasefurls.list.';
		$filter_state		= $mainframe->getUserStateFromRequest( $context.'filter_state',		'filter_state',		'',				'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $context.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
		$where = array();

		if ($search) {
			$where[] = 'LOWER(a.old_url) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'a.published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'a.published = 0';
			}
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}
}
?>