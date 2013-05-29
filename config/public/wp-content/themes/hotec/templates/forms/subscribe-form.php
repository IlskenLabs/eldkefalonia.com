<div class="subscribe_section">
        <form target="_blank" method="post" action="http://feedburner.google.com/fb/a/mailverify" id="subscribe_form">
             <label for="email_subscribe"><?php _e('Sign up to receive Special Offers:','smooththemes'); ?>&nbsp;&nbsp;</label>
             <input type="email" required="required" class="subs_email_input" id="email_subscribe" name="email" value="" placeholder="<?php _e('Enter your e-mail address','smooththemes') ?>">
             <input type="hidden" name="uri" value="<?php echo esc_attr(st_get_setting("feedburner_urli")); ?>">
             <input type="hidden" value="en_US" name="loc">
            <input type="submit" name="" value="<?php _e('Subscribe','smooththemes'); ?>" class="btn btn_green">
        </form>
</div>