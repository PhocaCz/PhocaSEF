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
defined( '_JEXEC' ) or die( 'Restricted access' );

function com_install() {

	?>
	<h2 style="color:#990000">Important</h2>
	<p><span style="color:#990000">(1)</span> For successfully running of this component, Joomla! core file needs to be edited. Please do this change only if you know what you are doing. Before it, backup the edited file.</p> 
	<p>Edit the  <span style="background:#d0d0d0">libraries/joomla/error/error.php</span> file (with help of text editor), add into the "raiseError" method (row + - 169) the following code:</p>
	<div style="background:#ffffcc;border:1px solid #ffff33;padding:5px"><code>
	//PHOCAEDIT <br />
	if ($code == '404') {<br />
	   include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocasef'.DS.'helpers'.DS.'phocasef.php' );<br />  
	   PhocaSefHelper::createUrlEntry();<br />
	}<br />
	//PHOCAEDIT<br />
	</code></div>
	<p>You should paste it before:<br /><span style="background:#f0f0f0">$reference = & JError::raise(E_ERROR, $code, $msg, $info, true);</span></p>
	<p><span style="color:#990000">(2)</span> Search Engine Friendly URLs needs to be enabled in Global Configuration of Joomla!</p>
<?php
	
	$message = '<p>Please select if you want to Install or Upgrade Phoca SEF component. Click Install for new Phoca SEF installation. If you click on Install and some previous Phoca SEF version is installed on your system, all Phoca SEF data stored in database will be lost. If you click on Uprade, previous Phoca SEF data stored in database will be not removed.</p>';
	

	?>
	<div style="padding:20px;border:1px solid #b36b00;background:#fff">
		<a style="text-decoration:underline" href="http://www.phoca.cz/" target="_blank"><?php
			echo  JHTML::_('image.site', 'icon-phoca-logo.png', 'components/com_phocasef/assets/images/', NULL, NULL, 'Phoca.cz');
		?></a>
		<div style="position:relative;float:right;">
			<?php echo  JHTML::_('image.site', 'logo-phoca.png', 'components/com_phocasef/assets/images/', NULL, NULL, 'Phoca.cz');?>
		</div>
		<p>&nbsp;</p>
		<?php echo $message; ?>
		<div style="clear:both">&nbsp;</div>
		<div style="text-align:center"><center><table border="0" cellpadding="20" cellspacing="20">
			<tr>
				<td align="center" valign="middle">
					<a href="index.php?option=com_phocasef&amp;controller=phocainstall&amp;task=install"><?php
					echo JHTML::_('image.site',  'install.png', '/components/com_phocasef/assets/images/', NULL, NULL, 'Install' );
					?></a>
				</td>
				
				<td align="center" valign="middle">
					<a href="index.php?option=com_phocasef&amp;controller=phocainstall&amp;task=upgrade"><?php
					echo JHTML::_('image.site',  'upgrade.png', '/components/com_phocasef/assets/images/', NULL, NULL, 'Upgrade' );
					?></a>
				</td>
			</tr>
		</table></center></div>
		
		<p>&nbsp;</p><p>&nbsp;</p>
		<p>
		<a href="http://www.phoca.cz/phocasef/" target="_blank">Phoca SEF Main Site</a><br />
		<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca SEF User Manual</a><br />
		<a href="http://www.phoca.cz/forum/" target="_blank">Phoca SEF Forum</a><br />
		</p>
		
		<p>&nbsp;</p>
		<p><center><a style="text-decoration:underline" href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></center></p>		
<?php	
}
?>