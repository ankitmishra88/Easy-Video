<?php

defined('ABSPATH')||die('No Script Kiddies Please');

//Main Class EV_LOADER

class EV_LOADER{
    private $ev_cpt;
    private $ev_api;
    private $ev_admin;

    public function __construct(){
       require_once(EV_PLUGIN_DIR.'/classes/admin/class.ev_cpt.php');
       require_once(EV_PLUGIN_DIR.'/classes/admin/class.ev_api.php');
       require_once(EV_PLUGIN_DIR.'/classes/admin/class.ev_admin.php'); 
       require_once(EV_PLUGIN_DIR.'/includes/functions.php'); 
       $this->init();
    }

    function init(){
        $this->ev_cpt=new EV_CPT();
        $this->ev_api=new EV_API();
        $this->ev_admin=new EV_ADMIN();
    }

    public function cpt(){
        return $this->ev_cpt;
    }

    public function api(){
        return $this->ev_api;
    }

    public function admin(){
        return $this->ev_admin;
    }

}

?>