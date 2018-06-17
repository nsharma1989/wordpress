<div id="<?php echo $widgetId; ?>" class="<?php echo $widgetClass; ?>">
	<meta http-equiv="content-type" content='text/html;charset=UTF-8'>
	<?php if ($isCallback): ?>
	<div class="submission-message card">
		<div class="card-block">
			<p class="text-success"><?php _e('Your request has been receive, we will be contacting you soon.'); ?></p>
		</div>
	</div>
	<?php endif; ?>
	<?php echo $form; ?>
	<iframe name='captchaFrame' style='display:none;'></iframe>
</div>