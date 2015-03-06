<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 
$editor =& JFactory::getEditor();
?>
<script language="javascript" type="text/javascript">
	<!--
		var sectioncategories = new Array;
	
	
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		/*if (form.title.value == ""){
			alert( "<?php echo JText::_( 'Component item must have a title', true ); ?>" );
		} else*/  if (form.old_url.value == ""){
			alert( "<?php echo JText::_( 'You must set an Obsolete URL', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>

<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>


<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="old_url">
					<?php echo JText::_( 'Obsolete URL' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="old_url" id="old_url" size="72" maxlength="250" value="<?php echo $this->phocasef->old_url;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="new_url">
					<?php echo JText::_( 'New URL' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="new_url" id="new_url" size="72" maxlength="250" value="<?php echo $this->phocasef->new_url;?>" />
			</td>
		</tr>
		
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td colspan="2">
				<?php echo $this->lists['published']; ?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<label for="ordering">
					<?php echo JText::_( 'Ordering' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->lists['ordering']; ?>
			</td>
		</tr>
		
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="cw">
					<?php echo JText::_( 'Count(No Redirect)' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="cw" id="cw" size="8" maxlength="11" value="<?php echo $this->phocasef->cw;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="cr">
					<?php echo JText::_( 'Count(Redirect)' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="cr" id="cr" size="8" maxlength="11" value="<?php echo $this->phocasef->cr;?>" />
			</td>
		</tr>
		
	</table>
	</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_phocasef" />
<input type="hidden" name="cid[]" value="<?php echo $this->phocasef->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocasefurls" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
