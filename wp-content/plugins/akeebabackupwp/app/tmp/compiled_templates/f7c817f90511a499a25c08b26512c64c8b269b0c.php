<?php /* /var/www/vhosts/sweet-johnson.137-184-185-215.plesk.page/education.sweet-johnson.137-184-185-215.plesk.page/wp-content/plugins/akeebabackupwp/app/Solo/ViewTemplates/Wizard/wizard.blade.php */ ?>
<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2023 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Akeeba\Engine\Factory;

defined('_AKEEBA') or die();

/** @var \Solo\View\Wizard\Html $this */

$config = Factory::getConfiguration();

?>

<div id="akeeba-confwiz">
	<div id="backup-progress-pane" style="display: none">
		<div class="akeeba-block--warning">
			<?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_INTROTEXT'); ?>
		</div>

		<div id="backup-progress-header" class="akeeba-panel--info">
            <header class="akeeba-block-header">
                <h3>
                    <?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_PROGRESS'); ?>
                </h3>
            </header>

            <div id="backup-progress-content">
				<div id="backup-steps">
					<div id="step-minexec" class="akeeba-label--grey"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_MINEXEC'); ?></div>
					<div id="step-directory" class="akeeba-label--grey"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_DIRECTORY'); ?></div>
					<div id="step-dbopt" class="akeeba-label--grey"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_DBOPT'); ?></div>
					<div id="step-maxexec" class="akeeba-label--grey"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_MAXEXEC'); ?></div>
					<div id="step-splitsize" class="akeeba-label--grey"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_SPLITSIZE'); ?></div>
				</div>
				<div class="backup-steps-container">
					<div id="backup-substep">
					</div>
				</div>
			</div>
			<span id="ajax-worker"></span>
		</div>

	</div>

	<div id="error-panel" class="akeeba-block--failure" style="display:none">
		<h3 class="alert-heading"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_HEADER_FAILED'); ?></h3>
		<div id="errorframe">
			<p id="backup-error-message">
			</p>
		</div>
	</div>

	<div id="backup-complete" style="display: none">
		<div class="akeeba-block--success">
			<h2 class="alert-heading"><?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_HEADER_FINISHED'); ?></h2>
			<div id="finishedframe">
				<p>
					<?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFWIZ_CONGRATS'); ?>
				</p>
			</div>

            <a class="akeeba-btn--primary--big" href="<?php echo $this->container->router->route('index.php?&view=backup'); ?>">
				<span class="akion-play"></span>
				<?php echo \Awf\Text\Text::_('COM_AKEEBA_BACKUP'); ?>
			</a>

            <a class="akeeba-btn--ghost" href="<?php echo $this->container->router->route('index.php?&view=configuration'); ?>">
				<span class="akion-wrench"></span>
				<?php echo \Awf\Text\Text::_('COM_AKEEBA_CONFIG'); ?>
			</a>

			<?php if(AKEEBABACKUP_PRO): ?>
            <a class="akeeba-btn--ghost" href="<?php echo $this->container->router->route('index.php?&view=schedule'); ?>">
				<span class="akion-calendar"></span>
				<?php echo \Awf\Text\Text::_('COM_AKEEBA_SCHEDULE'); ?>
			</a>
			<?php endif; ?>
		</div>

	</div>
</div>
