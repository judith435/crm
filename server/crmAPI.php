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
        try {
            $leads = Lead::getLeads();
            echo json_encode($leads);
        }
        catch (Exception $error) {
            ErrorHandling::LogError($error); 
            $response_array = array(
                "status" => "error",
                "message" => "server error please contact support center",
            );
            $ttt = json_encode($response_array);
            echo "I do no know 2222";//$response_array;
        }
    }

    function getProspects() {
        $prospects = Prospect::getProspects();
        echo json_encode($prospects);
    }

    function getProducts() {
        try {
            $products = Product::getProducts();
            echo json_encode($products);
        }
        catch (Exception $error) {
            ErrorHandling::LogError($error); 
        }

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
            // header('Content-type: application/json');
        }
        else {
            $response_array['status'] = 'ok';  
            $response_array['message'] = 'lead added successfully'; 
        }
        echo json_encode($response_array);
    }
        
        

?>