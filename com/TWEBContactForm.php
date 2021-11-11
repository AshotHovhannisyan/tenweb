<?php

class TWEBContactForm
{
	public static function getOptionsById($formId)
	{
		return get_post_meta($formId, 'twebcf_options', true);
	}

    public static function getAllContacts($twebs)
    {
        global $wpdb;
        global $wp_query;
        $table_name = $wpdb->prefix . 'contact_form';
        $search = '';
        if ($twebs)
            $search = " WHERE  name LIKE '%" .$twebs . "%' OR email LIKE '%" .$twebs . "%' OR gender LIKE '%" .$twebs . "%' ";

        $query = "SELECT * FROM $table_name $search" ;

        $total_record = count($wpdb->get_results($query, ARRAY_A));
        $paged          = isset( $_GET['pagenum']) ? $_GET['pagenum'] : 1;
        $post_per_page  = get_option('posts_per_page');
        $offset         = ($paged - 1)*$post_per_page;
        $max_num_pages  = ceil($total_record/ $post_per_page);
        $wp_query->found_posts   = $total_record;

// number of pages
        $wp_query->max_num_pages = $max_num_pages;

        $limit_query = " LIMIT ".$post_per_page." OFFSET ".$offset;



        return $wpdb->get_results($query.$limit_query,OBJECT);// return OBJECT
    }

	public static function renderContactForm($formId)
	{
		ob_start();
		?>
		<form class="twebcf-main-form twebcf-form-<?php echo $formId; ?>" enctype="multipart/form-data">
			<input type="hidden" id="twebcf-hidden-checker" name="twebcf-hidden-checker">
			<div class="form-group">
				<label for="twebcf-name"><?php _e('Name'); ?></label>
				<input type="text" class="form-control" id="twebcf-name" placeholder="Enter your name" name="twebcf-name" required>
			</div>
            <div class="form-group">
                <label for="twebcf-email"><?php _e('Email'); ?></label>
                <input type="text" class="form-control" id="twebcf-email" placeholder="Enter your email" name="twebcf-email" required>
            </div>
			<div class="form-group">
				<label for="twebcf-gender"><?php _e('Gender'); ?></label>
				<select id="twebcf-gender" name="twebcf-gender">
					<option value="male"><?php _e('Male'); ?></option>
					<option value="female"><?php _e('Female'); ?></option>
				</select>
				
			</div>
            <div class="form-group">
                <label for="date"><?php _e('Date'); ?></label>
                <input type="date" name="twebcf-date">
            </div>
            <div class="form-group">
                <label for="file-img"><?php _e('file'); ?></label>

                <span class="change-file">
                    <span>Choose file... </span>
                    <input type="file" value="img" accept="image/*" name="twebcf-file" id="file-img">
                </span>

            </div>
        	<div class="form-group">
	            <span id="message-data">
	            </span>
            </div>
            	
            <input type="hidden" name="action" value="twebcf_form_submission">
			<input type="submit" class="twebcf-submit-css twebcf-submit-js" data-id="<?php echo $formId; ?>" value="<?php _e('Submit'); ?>">
		</form>

		<?php

		$shortcodeContent = ob_get_contents();
		ob_get_clean();

		return $shortcodeContent;
	}
}
