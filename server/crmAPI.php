<?php
    require_once 'Lead.php';
    require_once 'Prospect.php';
    require_once 'Product.php';
    
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
        case 'getProducts':
            getProducts();  
            break;
        case 'AddLead':
            AddLead();  
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

    function getProducts() {
        $products = Product::getProducts();
        $dodo = json_encode($products);
        echo json_encode($products);
    }

    function AddLead(){
        
        $leadName = trim($_POST["leadName"]);
        $leadPhone = trim($_POST["leadPhone"]);
        $product = explode(",", $_POST["product"]);//
        $errorInInput = "";
        Lead::addLead($leadName, $leadPhone, $product[0], $product[1], $errorInInput);
        if ($errorInInput != "") {
            $response_array['status'] = 'error';  
            $response_array['message'] = $errorInInput; 
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }
        
        

?>