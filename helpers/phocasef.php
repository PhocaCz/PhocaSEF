<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Download
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class PhocaSefHelper
{
	function createUrlEntry() {
		$db 		= &JFactory::getDBO();
		$uri		= &JFactory::getURI();
		
		$paramsC 	= JComponentHelper::getParams('com_phocasef') ;
		$enable_url = $paramsC->get( 'enable_url', 1 );
		$store_url 	= $paramsC->get( 'store_url', 1 );
		$store_ref 	= $paramsC->get( 'store_ref', 1 );

		if ((int)$store_ref == 1) {
			// REF
			if (isset($_SERVER['HTTP_REFERER'])) {
				$refSite = $_SERVER['HTTP_REFERER'];
				$refSite = addslashes((html_entity_decode(urldecode($refSite))));
			} else {
				$refSite = 'not-set';
			}
			
			$query =  ' SELECT * FROM #__phocasef_ref'
					 .' WHERE '. $db->nameQuote('ref_url')
					 .' = '
					 .$db->Quote($refSite);
					 
	        $db->setQuery($query);
	        $results = $db->loadObjectList();
			
			$date = gmdate('Y-m-d H:i:s');
			if ($results) {
				// Update count
				$query = 'UPDATE '.$db->nameQuote('#__phocasef_ref')
						.' SET count_url = (count_url + 1),'
						.' date_url = '.$db->Quote($date)
						.' WHERE ref_url = '.$db->Quote($refSite);
						
				$db->setQuery($query);
				$db->query();
			} else {
				// Record not correctly REF
				// URL - Get the required site -------------------------------------
				$path 	= $uri->getPath();
				$path 	= substr_replace($path, '', 0, strlen(JURI::base(true)));
				$path 	= ltrim($path, '/');	
				// Do both path as the same : www...com/new == www...com/new/
				$path = rtrim($path, '/');
				// Non SEF site
				$queryUrl = $uri->getQuery();
				if ($queryUrl) {
					$path = $path .'?'. $uri->getQuery();
				}
				$path = addslashes(html_entity_decode(urldecode($path)));
				// -----------------------------------------------------------------
				
				$query = 'INSERT INTO '.$db->nameQuote('#__phocasef_ref')
						.' ('.$db->nameQuote('count_url').','
						.' '.$db->nameQuote('ref_url').','
						.' '.$db->nameQuote('ref_to_url').','
						.' '.$db->nameQuote('date_url').')'
						.' VALUES ('.$db->Quote(1).','
						.' '.$db->Quote($refSite).','
						.' '.$db->Quote($path).','
						.' '.$db->Quote($date).')';
				$db->setQuery($query);
				$db->query();
			}
		}
		
		if ((int)$enable_url == 1) {
			
			// URL - Get the required site -------------------------------------
			$path 	= $uri->getPath();
			$path 	= substr_replace($path, '', 0, strlen(JURI::base(true)));
			$path 	= ltrim($path, '/');
			// Do both path as the same : www...com/new == www...com/new/
			$path 	= rtrim($path, '/');
			// Non SEF site
			$queryUrl = $uri->getQuery();
				if ($queryUrl) {
					$path = $path .'?'. $uri->getQuery();
				}
			$path 	= html_entity_decode(urldecode($path));// no adshlashes they are add by Joomla!
			
			
			// -----------------------------------------------------------------
			
			$query = ' SELECT * FROM '.$db->nameQuote('#__phocasef_url')
					.' WHERE '.$db->nameQuote('old_url')
					.' = '
					.' '.$db->Quote($path);
	        $db->setQuery($query);
	        $result = $db->loadObject();
			
			$date = gmdate('Y-m-d H:i:s');
			
			if ($result) {
		
				// Update count cr = right (new link exists), cw = wrong (new link doesn't exist)
				if (/*isset($result->new_url) && $result->new_url != '' &&*/ isset($result->published) && (int)$result->published == 1) {
					if ((int)$store_url == 1) {
						$query = 'UPDATE '.$db->nameQuote('#__phocasef_url')
						.' SET '.$db->nameQuote('cr').' = (cr + 1),'
						.' '.$db->nameQuote('date_url').' = '.$db->Quote($date)
						.' WHERE '.$db->nameQuote('old_url').' = '.$db->Quote($path);
						$db->setQuery($query);
						$db->query();
					}
					
					// Redirect
					$file = '';
					$line = '';
					$new  = $result->new_url;
					
					
					// NO LOOP
					$new	= html_entity_decode(urldecode($new));
					$path	= html_entity_decode(urldecode($path));
					
					// As new url can be saved with \ (wrong)
					$newCheck = rtrim(str_replace('\\', '/', $new), '/');
					$pathCheck = rtrim(str_replace('\\', '/', $path), '/');
					
					// As new url can be saved \'
					$new2Check = rtrim(stripslashes($new), '/');
					$path2Check = rtrim(stripslashes($path), '/');
			
					// No loop
					if ($new != $path && $new != rtrim($path, '/') && $path != rtrim($new, '/') && rtrim($path, '/') != rtrim($new, '/') && $newCheck != $pathCheck && $new2Check != $path2Check) {
						$root = JURI::root();
						
						if( strstr($new, $root) === false ) {
							$url = $root;
							// Add to the root slash if not exists
							if( substr($url, -1) != '/' ) {
								$url .= '/';
							}
							// Slash is added in url, remove it from new
							if( substr($new, 0, 1) == '/' ) {
								$new = substr($new, 1);
							}
							$url .= $new;
						} else {
							$url = $new;
						}
					
						if (!headers_sent($file, $line)) {
							// Use the link to redirect
							header("HTTP/1.1 301 Moved Permanently");
							header("Location: ".$url);
							header("Connection: close");
							exit();
					}
					
					} else {
						return true;
					}
					
					
				} else {
					if ((int)$store_url == 1) {
						$query = 'UPDATE '.$db->nameQuote('#__phocasef_url')
						.' SET cw = ( cw + 1),'
						.' date_url = '.$db->Quote($date)
						.' WHERE old_url = '.$db->Quote($path);
					
						$db->setQuery($query);
						$db->query();
					}
				}
				
			} else {
				// Record not correctly URL
				if ((int)$store_url == 1) {
					
					$query = 'INSERT INTO '.$db->nameQuote('#__phocasef_url')
						.' ('.$db->nameQuote('old_url').','
						.' '.$db->nameQuote('new_url').','
						.' '.$db->nameQuote('date_url').','
						.' '.$db->nameQuote('cw').')'
						.' VALUES ('.$db->Quote($path).','
						.' '.$db->Quote('').','
						.' '.$db->Quote($date).','
						.' '.$db->Quote(1).')';
					$db->setQuery($query);
					$db->query();
				}
			}
		}
		return true;
	}
	
	function getPhocaVersion()
	{
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_phocasef';
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.'com_phocasef';
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$xml_items = '';
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
					foreach($data as $key => $value) {
						$xml_items[$key] = $value;
					}
				}
			}
		}
		
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
			return $xml_items['version'];
		} else {
			return '';
		}
	}
}
?>