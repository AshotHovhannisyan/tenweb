<?php

class TWEBCFHelper
{

	public static function filterPostDataBeforeSaving($postData)
	{
		$filteredData = array();

		// get prefix twebcf
		foreach ($postData as $key => $value) {
			if (strpos($key, 'twebcf') === 0) {
				$filteredData[$key] = $value;
			}
		}

		return $filteredData;
	}

	public static function createTable(){
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'contact_form';

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name VARCHAR(256) NOT NULL,
                email VARCHAR(256) NOT NULL,
                gender VARCHAR(10) NOT NULL,
                file VARCHAR(256) NULL,
                date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        maybe_create_table($table_name, $sql );
    }

//
//	public static function getFieldLabelByName($name = '')
//	{
//		$fieldLabels = array(
//			'jthcf-name' => 'Name',
//			'jthcf-gender' => 'Gender'
//		);
//
//		if (!isset($fieldLabels)) {
//			return '';
//		}
//
//		return $fieldLabels[$name];
//	}
}
