<?php
    defined('ABSPATH')||die('No Script Kiddies Please');

    //https://www.googleapis.com/youtube/v3/search?key=AIzaSyD4LfoFoZcCkBX8zf6-PjUcpJ8prV7spwM&channelId=UCq-Fj5jknLsUf-MWSy4_brA&&part=snippet,id&order=date&maxResults=100

    class EV_ADMIN{
        public function __construct(){
            add_action("admin_menu",[$this,"admin_menu_pages"]);
        }

        function admin_menu_pages(){
            add_menu_page(
                'EV Imports',
                'EV Import',
                'manage_options',
                'ev-import',
                [$this,'ev_bulk_import'],
                '',
                5
            );

            add_submenu_page(
                'ev-import',
                'EV Import Settings',
                'API Key',
                'manage_options',
                'ev-import-settings',
                [$this,'ev_import_settings'],
                1
            );
        }

        function ev_bulk_import(){
            include_once('settings/ev-channel-import.php');
        }

        function ev_import_settings(){
            include_once('settings/ev-api-settings.php');
        }
    }
?>