<?php
    require_once 'Lead.php';
    require_once 'Prospect.php';

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
        case 'getProspects':
        getProspects();  
              break;
        default:
            die('Access denied for this function!');
    }

    function getLeads() {
        $leads = Lead::getLeads();
        echo json_encode($leads);
    }

    function getProspects() {
        $prospects = Prospect::getProspects();
        echo json_encode($prospects);
    }

?>