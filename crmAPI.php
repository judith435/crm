<?php
    require_once 'Lead.php';

    if(isset($_POST['action']) && function_exists($_POST['action'])) {
        $action = $_POST['action'];
    }
    else
    {
        die();
    }

    switch($action) {
        case 'getLeads':
        getLeads();  
              break;
        default:
            die('Access denied for this function!');
    }

    function getLeads() {
        $leads = Lead::getLeads();
        echo json_encode($leads);
    }

?>