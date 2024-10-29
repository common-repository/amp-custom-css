<?php
if (!defined('ABSPATH'))
    exit; //Exit if accessed directly

function amp_custom_css_settings() {
   
    global $ampcc_plugin;
    global $blog_id;
    $amp_css = '';
    if (isset($_POST['ampcc_save_settings'])) {
    if (isset( $_POST['amp_nonce'] ) && wp_verify_nonce($_POST['amp_nonce'], 'add-nonce') ){ 
	$amp_css = strip_tags(stripslashes($_POST['ampcc_css_entry']));
	$settings_array = array('blog_id' => $blog_id, 'amp_css' => $amp_css);
	update_option('ampcc_settings', $settings_array);
	echo '<div id="message" class="updated fade">';
	echo '<p>Your AMP custom CSS settings is updated</p>';
	echo '</div>';
    }
    }
    $settings = get_option('ampcc_settings');
    if ($settings) {
	if ($settings['blog_id'] == $blog_id) {
	    $amp_css = $settings['amp_css'];    
	} else {
	    $amp_css = NULL;
	}
    }
    ?> 
    	<div class="cssfield">
    	    <h1><label for="title">Add Your Own Custom AMP CSS Here</label></h1> 
			<?php
			echo '<p>' . __('<b>IMPORTANT - No need to add < style > tag</b>', 'ampcc') . '</p>';
			?>
    		<form action="" method="POST">
                <?php wp_nonce_field('add-nonce', 'amp_nonce'); ?>
    		    <textarea name="ampcc_css_entry" id="ampcc_css_entry" dir="ltr" style="width:100%;height:400px;"><?php echo $amp_css; ?></textarea>    
    		    <br />
    		    <input type="submit" name="ampcc_save_settings" value="Save" class="button-primary" />
    		</form>
            <br/>
            <b>If you like our plugin then please help us with small donation</b>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick" />
            <input type="hidden" name="hosted_button_id" value="LJWAJGETTWW2G" />
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
            </form>
    	    </div>
    <?php
}
