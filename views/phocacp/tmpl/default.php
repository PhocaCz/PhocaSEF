<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="cpanel">
	<?php
	$link = 'index.php?option=com_phocasef&view=phocasefurls';
	echo PhocaHelperControlPanel::quickIconButton( 'com_phocasef', $link, 'icon-48-red.png', JText::_( 'Redirect Site' ) );
	
	$link = 'index.php?option=com_phocasef&view=phocasefrefs';
	echo PhocaHelperControlPanel::quickIconButton( 'com_phocasef', $link, 'icon-48-ref.png', JText::_( 'Referring Site' ) );
	
	
	$link = 'index.php?option=com_phocasef&view=phocainfo';
	echo PhocaHelperControlPanel::quickIconButton( 'com_phocasef', $link, 'icon-48-info.png', JText::_( 'Info' ) );
	?>
			
			<div style="clear:both">&nbsp;</div>
			<p>&nbsp;</p>
			<div style="text-align:center;padding:0;margin:0;border:0">
				<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocasef" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
				<a href="http://www.phoca.cz/adv/phocasef" target="_blank">Phoca Gallery</a>
				</iframe> 
			</div>
			
			
			</div>
		</td>
		
		<td width="45%" valign="top">
			<div style="300px;border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
			<div style="float:right;margin:10px;">
				<?php
					echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocasef/assets/images/', NULL, NULL, 'Phoca.cz' )
				?>
			</div>
			
			<h3><?php echo JText::_('Version');?></h3>
			<p><?php echo $this->version ;?></p>

			<h3><?php echo JText::_('Copyright');?></h3>
			<p>&copy; 2007 - <?php echo date("Y"); ?> Jan Pavelka</p>
			<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>

			<h3><?php echo JText::_('License');?></h3>
			<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>
			<p>&nbsp;</p>
			
			<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocasef=<?php echo $this->version ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>
			
			
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_phocasef" />
<input type="hidden" name="view" value="phocacp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>