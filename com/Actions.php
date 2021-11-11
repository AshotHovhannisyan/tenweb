<?php

class Actions
{
	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		add_action('init', array($this, 'twebcfPostTypeRegister'));
		add_action('add_meta_boxes', array($this, 'contactFormOptions'));
		add_shortcode('twebcf_form', array($this, 'contactFormShortcodeInit'));
		add_action('save_post', array($this, 'saveForm'), 100, 3);
		add_action('manage_'.TWEBCF_POST_TYPE.'_posts_custom_column' , array($this, 'formsTableColumns'), 10, 2);
		add_action('wp_enqueue_scripts', array($this, 'twebcfLoadFrontScriptsAndStyles'));
		add_action('admin_menu', array($this, 'twebcfAddAdminPage'));
        add_action('admin_enqueue_scripts', array($this, 'twebcfLoadAdminScriptsAndStyles'), 10, 1);
		new Ajax();
	}

    //add custom post type
	public function twebcfPostTypeRegister(){
		register_post_type(TWEBCF_POST_TYPE,
			array(
				'labels'      => array(
					'name'          => __('Contact Forms'),
                    'add_new' => __( 'Add New Form' ),
					'singular_name' => __('Form'),
                    'add_new_item'          => __( 'View Product' ),
				),
					'public'      => true,
					'has_archive' => true,
					'menu_icon' => 'dashicons-email-alt',
					'supports'            => array('title'),
                'menu_position' => 220

			)
		);


	}

	public function twebcfAddAdminPage(){
        add_menu_page('show form', 'Show Forms', 'manage_options', 'show-form', array($this, 'adminPage'), 'dashicons-email-alt', 221);
    }

    public function adminPage(){
        $twebs = '';
	    if (isset($_GET['twebs'])){
            $twebs = $_GET['twebs'];
        }
        $contacts = TWEBContactForm::getAllContacts($twebs);
        require_once(TWEBCF_VIEWS_PATH . 'admin-page.php');
    }

	//create custom option field
	public function contactFormOptions()
	{
		add_meta_box(
			'contactFormOptions',
			__('Options'),
			array($this, 'contactFormOptionsView'),
            TWEBCF_POST_TYPE,
			'normal',
			'high'
		);
	}

	//admin page options form
	public function contactFormOptionsView(){
        $formId = get_the_ID();
        $options = TWEBContactForm::getOptionsById($formId);
		require_once(TWEBCF_VIEWS_PATH . 'form-fields.php');
	}

    //when save post, save fields
    public function saveForm($formId = 0, $post = array())
    {
        if ($post->post_type == TWEBCF_POST_TYPE) {
            $options = TWEBCFHelper::filterPostDataBeforeSaving($_POST);
            update_post_meta($formId, 'twebcf_options', $options);
        }
    }

    //create custom contact form shortcode
	public function contactFormShortcodeInit($args, $content){
		$contactFormId = (int)$args['id'];

		$shortcodeContent =  TWEBContactForm::renderContactForm($contactFormId);

		return do_shortcode($shortcodeContent);
	}

    //create shortcode to show contact form
	public function formsTableColumns($column, $postId){
		$postId = (int)$postId;
		global $post_type;
		
		$form = TWEBContactForm::getOptionsById($postId);

		if (empty($form) && $post_type == TWEBCF_POST_TYPE) {
			return false;
		}

		if ($column == 'shortcode') {
			echo '<input type="text" readonly value="[twebcf_form id='.$postId.']" class="code">';
		}
	}

//	front enqueue
	public function twebcfLoadFrontScriptsAndStyles(){
		wp_enqueue_style('twebcf-main',  TWEBCF_CSS_URL.'style.css');
		wp_enqueue_script( 'twebcf-contact-form', TWEBCF_JS_URL.'script.js', array('jquery'));
		wp_localize_script('twebcf-contact-form', 'TWEBCF_AJAX_DATA', array(
			'url' => admin_url('admin-ajax.php')
		));
	}

    //	admin enqueue
	public function twebcfLoadAdminScriptsAndStyles(){
        wp_enqueue_style('twebcf-admin-main',  TWEBCF_CSS_URL.'admin-style.css');
    }
}
