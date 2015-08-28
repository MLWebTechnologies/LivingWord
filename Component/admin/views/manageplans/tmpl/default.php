<?php
/**
* LivingWord Component for Joomla
* By Mike Leeper
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
  global $livingwordadmin, $lwConfig;
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_livingword.manageplans');
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_livingword&task=plans.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'lwplansList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
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
		Joomla.tableOrdering(order, dirn, 'manage_plans');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_livingword&task=manage_plans'); ?>" method="post" name="adminForm" id="adminForm">
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
		<table class="table table-striped" id="lwplansList">
	   <thead>
      	<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, 'manage_plans', 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Name', 'a.name', $listDirn, $listOrder, 'manage_plans' ); ?>
					</th>
    			<th width="5%" class="title"><?php echo JText::_( 'Default' );?></th>
					<th>
						<?php echo JHTML::_('grid.sort',   'Description', 'a.description', $listDirn, $listOrder, 'manage_plans' ); ?>
					</th>
					<th class="title" width="25%"><?php echo JText::_( 'Plan Message' ); ?></th>
					<th width="5%" class="nowrap center">
						<?php echo JHTML::_('grid.sort',   'Audio Capable', 'a.audio', $listDirn, $listOrder, 'manage_plans' ); ?>
					</th>
					<th class="nowrap center" width="5%">
						<?php echo JHTML::_('grid.sort',   JText::_( 'Coverage' ), 'a.newtest', $listDirn, $listOrder, 'manage_plans' ); ?>
					</th>
					<th class="nowrap center" width="5%">
						<?php echo JHTML::_('grid.sort',   'Published', 'a.published', $listDirn, $listOrder, 'manage_plans' ); ?>
					</th>
    			<th width="1%" class="nowrap center hidden-phone">
    				<?php echo JHTML::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder, 'manage_plans' ); ?>
    			</th>
  	  	</tr>
      </thead>
			<tfoot>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
		<?php
    $template	= JFactory::getApplication()->getTemplate();
		foreach ($this->items as $i => $item) {
      $message = trim($item->message,"<p></p>");
      $message = $this->escape(JText::_($message));
      $message = strip_tags($message,"<i><strong><u><em><strike>");
      $message = stripslashes($message);
      if (strlen($message) > 150) $message = substr($message, 0 , 148) . " ...";
				$ordering   = ($listOrder == 'a.ordering');
				$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
				$canChange  = true;//$user->authorise('core.edit.state', 'com_livingword.manageplans.' . $item->catid) && $canCheckin;
			?>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo md5($item->newtest);?>">
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
				<td class="small hidden-phone">
          <?php echo $this->escape(JText::_($item->name)); ?>
					<?php if ($item->checked_out) : ?><br />
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'plans.', $canCheckin);  ?>
          <?php endif; ?>
        </td>
   			<?php
        $template	= JFactory::getApplication()->getTemplate();
        $imagedir = 'templates/'.$template.'/images/admin';
        $imagedir2 = 'templates/'.$template.'/images/menu';
        ?>
        <td class="center hidden-phone">
					<?php echo JHtml::_('jgrid.isdefault', $lwConfig['config_bible_plan'] == $item->name, $i, JText::_( 'Default Bible Plan' ), $lwConfig['config_bible_plan'] != $item->name);?>
				</td>
        <td class="small hidden-phone"><?php echo JText::_($item->description); ?></td>
        <td class="small hidden-phone"><?php echo $message; ?></span></td>
      <?php
			if ($item->audio) {
      	$audioimg = "<img src=\"".$imagedir."/tick.png\" border=\"0\" />";
			} else {
	      $audioimg = "";
			} 
			if ($item->newtest == 0) {
      	$newtestimg = "Old & New Testament";
			} elseif ($item->newtest == 1){
	      $newtestimg = "New Testament Only";
			} elseif ($item->newtest == 2){
	      $newtestimg = "Old Testament Only";
      }
			$publishimg = '';
      $publishimg[] = '<a class="btn btn-micro active" rel="tooltip"';
			if ($item->published) {
  			$publishimg[] = ' href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\', \'livingword.unpublishplan\')"';
  			$publishimg[] = ' title="'.addslashes(htmlspecialchars(JText::_('Unpublish Plan'))).'">';
  			$publishimg[] = '<i class="icon-publish">';
			} else {
  			$publishimg[] = ' href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\', \'livingword.publishplan\')"';
  			$publishimg[] = ' title="'.addslashes(htmlspecialchars(JText::_('Publish Plan'))).'">';
  			$publishimg[] = '<i class="icon-unpublish">';
			} 
			$publishimg[] = '</i>';
			$publishimg[] = '</a>';
    ?>           		
    <td class="center hidden-phone"><?php echo $audioimg; ?></td>
    <td class="small hidden-phone"><?php echo $newtestimg; ?></td>
    <td class="center hidden-phone"><?php echo implode($publishimg); ?>
    </td>
		<td class="center hidden-phone">
			<?php echo (int)$item->id; ?>
		</td>
		</tr>
  <?php
  }
  ?>
    </tbody>  
	</table>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</div></form></div><br />
	<?php
  $livingwordadmin->LWfooter();
?>