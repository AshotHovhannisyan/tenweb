<?php

class Filters
{
	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		add_filter('manage_'.TWEBCF_POST_TYPE.'_posts_columns', array($this, 'formsTableColumns'));
	}

	public function formsTableColumns($columns)
	{
		$columns['shortcode'] = __('Shortcode');

		return $columns;
	}
}
