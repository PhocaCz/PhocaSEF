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
			</td>
		</tr>
	</table>
	

	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					<th width="3"><?php echo JText::_( 'NUM' ); ?></th>
					<th width="3"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
					
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Count', 'a.count_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th width="15%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Date', 'a.date_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="title" width="40%"><?php echo JHTML::_('grid.sort',  'Referring Site', 'a.ref_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="title" width="40%"><?php echo JHTML::_('grid.sort',  'Target Site', 'a.ref_to_url', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
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
					$checked 	= JHTML::_('grid.checkedout', $row, $i );
					
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
					<td><?php echo $checked; ?></td>
					
					<td><b style="color:#dd0000;"><?php echo $row->count_url; ?></b></td>
					
					<td><?php echo JHTML::Date($row->date_url, "%d. %m. %Y, %H:%M") ?></td>
					
					<?php 
					if ($row->ref_url !='not-set') {
						?>
						<td><a href="<?php echo $row->ref_url;?>" target="_blank"><?php echo $row->ref_url; ?></a></td>
						<?php
					} else {
						?>
						<td><?php echo $row->ref_url; ?></td>
						<?php
					}
					?>
					 
					<td><?php echo $row->ref_to_url; ?></td>
					 
					<td align="center"><?php echo $row->id; ?></td>
				</tr>
				<?php
				$k = 1 - $k;
				}
			?>
			</tbody>
		</table>
	</div>

<input type="hidden" name="controller" value="phocasefrefs" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>