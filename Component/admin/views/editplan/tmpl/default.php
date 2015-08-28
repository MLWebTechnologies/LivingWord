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
  JRequest::setVar( 'hidemainmenu', 1 );
  $lang = Jfactory::getLanguage();
  $lang->load( 'com_livingword', JPATH_SITE);
  JHTML::_('behavior.tooltip');
  ?>
	<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
  {
		Joomla.submitform( task, document.getElementById('plan-form') );
	}
  </script>
	<div class="span10 form-horizontal">
	<form action="index.php?option=com_livingword" method="post" name="adminForm" id="plan-form">
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'name' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'description' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'audio' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('audio'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'newtest' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('newtest'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'published' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('message'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('message'); ?></div>
				</div>
			</div>
    </div>
	<input type="hidden" name="option" value="com_livingword" />
 	<input type="hidden" name="edit" value="<?php echo $this->edit; ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="controller" value="livingword" />
	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<?php
	echo '<br /><br />';
  $livingwordadmin->LWfooter();
?>
   </div>