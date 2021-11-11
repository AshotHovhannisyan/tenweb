<?php

class Ajax
{
	public function __construct()
	{
		$this->actions();
	}

	public function actions()
	{

        add_action('wp_ajax_twebcf_form_submission', array($this, 'formSubmission'));
		add_action('wp_ajax_nopriv_twebcf_form_submission', array($this, 'formSubmission'));
	}

	public function formSubmission()
	{
        $name = $_POST['twebcf-name'];
        $email = $_POST['twebcf-email'];
        $gender = $_POST['twebcf-gender'];
        $date = $_POST['twebcf-date'];
        $file = $_FILES['twebcf-file'];



        $target_file = TWEBCF_PUBLIC_PATH . 'images/' . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'contact_form';
            $wpdb->insert($table_name, array(
                'name' => $name,
                'email' => $email,
                'gender' => $gender,
                'file' => $file['name'],
                'date' => date('Y-m-d', strtotime($date)
            )));
            
			echo "data was successfully sent";
			wp_die();
        }
        
        echo "Sorry, there was an error";
		wp_die();
	}
}
