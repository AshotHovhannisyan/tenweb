<?php

class TWEBCFInitialize
{
    private static $instance = null;
    private $actions;
    private $filters;

    private function __construct()
    {
        $this->init();
    }

    public static function getInstance()
    {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        $this->includeData();
        $this->actions();
        $this->filters();
        register_activation_hook(TWEBCF_FILE_NAME, array( $this, 'activate'));
    }

    private function includeData()
    {
        require_once(TWEBCF_PATH.'TWEBCFHelper.php');
        require_once(TWEBCF_COM_PATH.'TWEBContactForm.php');
        require_once(TWEBCF_COM_PATH.'Filters.php');
        require_once(TWEBCF_COM_PATH.'Actions.php');
        require_once(TWEBCF_COM_PATH.'Ajax.php');
    }

    public function actions()
    {
        $this->actions = new Actions();
    }

    public function filters()
    {
        $this->filters = new Filters();
    }

    public function activate(){
        TWEBCFHelper::createTable();
    }
}


TWEBCFInitialize::getInstance();
