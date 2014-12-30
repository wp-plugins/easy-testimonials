<h3>Pro Registration</h3>			
<?php if(!isValidKey()): ?><p>Fill out the fields below, if you have purchased the pro version of the plugin, to activate additional features such as Front-End Testimonial Submission.</p><?php endif; ?>
<?php if(isValidKey()): ?>	
<p class="plugin_is_registered">✓ Easy Testimonials Pro is registered and activated. Thank you!</p>
<?php else: ?>
<p class="plugin_is_not_registered">✘ Your plugin is not registered and activated. You will not be able to use the PRO features until you upgrade. <a href="http://goldplugins.com/our-plugins/easy-testimonials-details/" target="_blank">Click here</a> to upgrade today!</p>
<?php endif; ?>	
<?php if(!isValidMSKey()): ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="easy_t_registered_name">Email Address</label></th>
		<td><input type="text" name="easy_t_registered_name" id="easy_t_registered_name" value="<?php echo get_option('easy_t_registered_name'); ?>"  style="width: 250px" />
		<p class="description">This is the e-mail address that you used when you registered the plugin.</p>
		</td>
	</tr>
</table>
	
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="easy_t_registered_key">API Key</label></th>
		<td><input type="text" name="easy_t_registered_key" id="easy_t_registered_key" value="<?php echo get_option('easy_t_registered_key'); ?>"  style="width: 250px" />
		<p class="description">This is the API Key that you received after registering the plugin.</p>
		</td>
	</tr>
</table>
<?php endif; ?>