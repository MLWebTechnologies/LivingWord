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
		Joomla.submitform( task, document.getElementById('lwlink-form') );
	}
  </script>
	<div class="span10 form-horizontal">
	<form action="index.php?option=com_livingword" method="post" name="adminForm" id="lwlink-form">
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'name' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'published' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'catid' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'url' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('url'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'target' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput('target'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
				</div>
			</div>
    </div>
<div class="clr"></div>
	<input type="hidden" name="option" value="com_livingword" />
	<input type="hidden" name="controller" value="livingword" />
	<input type="hidden" name="cid[]" value="<?php echo $this->form->getValue('id'); ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form><br /><br /><br /><br />
	<?php $livingwordadmin->LWFooter(); ?>