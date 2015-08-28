<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
global $livingwordadmin;
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_livingword.manageplan');
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_livingword&task=plan.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'lwplanList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
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
		Joomla.tableOrdering(order, dirn, 'manage_plan');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_livingword&task=manage_plan'); ?>" method="post" name="adminForm" id="adminForm">
	<?php //echo $livingwordadmin->LWsideBar(); ?>
	<div id="j-main-container" class="span10">
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
		<table class="table table-striped" id="lwplanList">
	   <thead>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, 'manage_plan', 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Plan', 'a.plan', $listDirn, $listOrder, 'manage_plan' ); ?>
					</th>
					<th>
						<?php echo JHTML::_('grid.sort',   'Reading', 'a.reading', $listDirn, $listOrder, 'manage_plan' ); ?>
					</th>
          <?php
          if($this->items[0]->plan=='bio'){
          ?>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Character', 'figure', $listDirn, $listOrder, 'manage_plan' ); ?>
					</th>
          <?php
          }
          if($this->items[0]->plan=='chron'){
          ?>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Description', 'descrip', $listDirn, $listOrder, 'manage_plan' ); ?>
					</th>
          <?php
          }
          ?>
    			<th width="1%" class="nowrap center hidden-phone">
    				<?php echo JHTML::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder, 'manage_plan' ); ?>
    			</th>
  	  	</tr>
      </thead>
			<tfoot>
				<tr>
					<td colspan="10" class="center">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
		<?php
		foreach ($this->items as $i => $item) {
				$ordering   = ($listOrder == 'a.ordering');
				$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
				$canChange  = true;//$user->authorise('core.edit.state', 'com_livingword.manageplans.' . $item->catid) && $canCheckin;
			?>
			<tbody>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $this->id;?>">
					<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';
						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = ' inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip<?php echo $disableClassName;?>" title="<?php echo $disabledLabel;?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>
				<td class="center hidden-phone" width="5">
        	<?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td align="center hidden-phone"><?php echo trim($item->plan); ?></td>
				<td align="center hidden-phone"><span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Reading' );?>::<?php echo preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-]+)/', array( &$livingwordadmin, 'matchBookName'), trim($item->reading) ); ?>">
				<a href="#edit" onclick="return listItemTask('cb<?php echo $i; ?>','editreading')">
				<?php echo preg_replace_callback( '/(LWBIBLEBOOK\d+)\s([\d\.\:\,\-]+)/', array( &$livingwordadmin, 'matchBookName'), trim($item->reading) ); ?></a></span></td>
        <?php
        if($item->plan=='bio'){
        ?>
        <td align="center hidden-phone"><?php echo $item->figure; ?></td>
        <?php
        }
        elseif($item->plan=='chron'){
        ?>
        <td align="center hidden-phone"><?php echo $item->descrip; ?></td>
        <?php
        }
        else {
        ?>
        <td align="center hidden-phone"><?php echo ''; ?></td>
        <?php
        }
        ?>
     		<td align="center hidden-phone">
    			<?php echo $item->id; ?>
    		</td>
		</tr></tbody>
  <?php
  }
  ?>
		</table>
			<input type="hidden" name="task" value="manage_plan" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="planid" value="<?php echo $this->id;?>" />
			<input type="hidden" name="plan" value="<?php echo $item->plan;?>" />
<!--			<input type="hidden" name="name" value="<?php //echo $this->name;?>" />-->
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form><br />
	<?php
  $livingwordadmin->LWfooter();
?>