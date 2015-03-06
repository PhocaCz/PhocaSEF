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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TablePhocaSefUrl extends JTable
{
	var $id 		= null;
	var $cw 		= null;
	var $cr 		= null;
	var $new_url	= null;
	var $old_url	= null;
	var $date_url	= null;
	var $published	= null;
	var $ordering 	= null;

	
	function __construct(& $db) {
		parent::__construct('#__phocasef_url', 'id', $db);
	}
}
?>