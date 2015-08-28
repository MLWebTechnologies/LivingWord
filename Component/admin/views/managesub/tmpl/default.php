<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
global $livingwordadmin;
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, 'manage_sub');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_livingword&task=manage_sub'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span12">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_LIVINGWORD_FILTER_SEARCH_DESC');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_LIVINGWORD_SEARCH'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_LIVINGWORD_SEARCH'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
					<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
				</select>
			</div>
		</div>
		<div class="clearfix"> </div>
		<table class="table table-striped" id="lwsubsList">
  	<thead>
		<tr>
				<th width="1%" class="hidden-phone">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
  			<th class="hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Subscriber', 'name', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
  			<th class="hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Bible Plan', 'bibleplan', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
  			<th class="hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Bible Version', 'bibleversion', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
  			<th class="hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Alternate Start Date', 'startdate', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
  			<th class="hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Plan View', 'planview', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
  			<th width="5%" class="nowrap hidden-phone">
  				<?php echo JHTML::_('grid.sort',   'Send Email', 'email', $listDirn, $listOrder, 'manage_sub' ); ?>
  			</th>
		</tr></thead>
			<tfoot>
				<tr>
					<td colspan="7">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
    	<tbody>
		<?php
		foreach ($this->items as $i => $item) {
			?>
		<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->name; ?>">
			<td class="center hidden-phone" width="5">
      	<?php echo JHtml::_('grid.id', $i, $item->id); ?>
      </td>
      <td class="small hidden-phone"><?php echo $item->name; ?></td>
      <td class="small hidden-phone"><?php echo $item->bibleplan; ?></td>
      <td class="small hidden-phone"><?php echo $item->bibleversion; ?></td>
      <td class="small hidden-phone"><?php if($item->startdate != '0000-00-00'){ echo date("Y-m-d",strtotime($item->startdate));} else {echo $item->startdate;} ?></td>
      <td class="small hidden-phone"><?php if($item->planview == 1){ echo 'List';} elseif($item->planview == 2) {echo 'Calendar';} else {echo 'Default';} ?></td>
      <?php
			$approvedimg = '';
      $approvedimg[] = '<a class="btn btn-micro active" rel="tooltip"';
			if ($item->email) {
  			$approvedimg[] = ' href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\', \'livingword.unapprovesub\')"';
  			$approvedimg[] = ' title="'.addslashes(htmlspecialchars(JText::_('Unapprove'))).'">';
  			$approvedimg[] = '<i class="icon-publish">';
			} else {
  			$approvedimg[] = ' href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\', \'livingword.approvesub\')"';
  			$approvedimg[] = ' title="'.addslashes(htmlspecialchars(JText::_('Approve'))).'">';
  			$approvedimg[] = '<i class="icon-unpublish">';
			} 
			$approvedimg[] = '</i>';
			$approvedimg[] = '</a>';
      ?>
     <td class="center small hidden-phone"><?php echo implode($approvedimg); ?></td></tr>
				<?php
			}?>
		</tbody>
		</table>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div></form></div><br />
	<?php
  $livingwordadmin->LWfooter();
?>