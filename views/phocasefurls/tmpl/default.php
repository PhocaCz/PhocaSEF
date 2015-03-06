<?php
defined('_JEXEC') or die('Restricted access');
$user 	=& JFactory::getUser();

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'a.ordering');

JHTML::_('behavior.tooltip');
?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['state'];
				?>
			</td>
		</tr>
	</table>
	

	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
					<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
					
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Count(NR)', 'a.cw', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Count(R)', 'a.cr', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th width="10%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Date', 'a.date_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="title" width="35%"><?php echo JHTML::_('grid.sort',  'Obsolete URL', 'a.old_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="title" width="35%"><?php echo JHTML::_('grid.sort',  'New URL', 'a.new_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="10%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
					
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="11"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
			
			<tbody>
				<?php
				$k = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
					$row 	= &$this->items[$i];
					$link 	= JRoute::_( 'index.php?option=com_phocasef&controller=phocasefurls&task=edit&cid[]='. $row->id );
					
					$checked 	= JHTML::_('grid.checkedout', $row, $i );
					$published 	= JHTML::_('grid.published', $row, $i );
					
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
					<td><?php echo $checked; ?></td>
					
					<td><b style="color:#dd0000;"><?php echo $row->cw; ?></b></td>
					<td><b style="color:#009900;"><?php echo $row->cr; ?></b></td>
					
					<td><?php echo JHTML::Date($row->date_url, "%d. %m. %Y") ?></td>
					
					<td>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Phoca SEF URLs' ); ?>"><?php echo $row->old_url; ?></a>
						
					</td>
					
					<td>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Phoca SEF URLs' ); ?>"><?php echo $row->new_url; ?></a>
						
					</td>
					
					<td align="center"><?php echo $published;?></td>
					
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
					</td>
					 
					<td align="center"><?php echo $row->id; ?></td>
				</tr>
				<?php
				$k = 1 - $k;
				}
			?>
			</tbody>
		</table>
	</div>

<input type="hidden" name="controller" value="phocasefurls" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>