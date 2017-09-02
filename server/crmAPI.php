<?php
    error_reporting(0);
    
    require_once 'Lead.php';
    require_once 'Prospect.php';
    require_once 'Product.php';
    
    if(isset($_POST['action'])) {  // && function_exists($_POST['action'])
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
        case 'UpdateLead':
            Add_Update_Lead($action);  
            break;
        case 'delete':
            DeleteLead();  
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
            ErrorHandling::HandleError($error); 
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
            ErrorHandling::HandleError($error); 
        }

    }

    function Add_Update_Lead($action){
        try {
                $leadName = trim($_POST["leadName"]);
                $leadPhone = trim($_POST["leadPhone"]);
                $product = explode(",", $_POST["product"]);
                $errorInInput = "";
                Lead::add_update_Lead($action, 
                                      $leadName, 
                                      $leadPhone, 
                                      $product[0], 
                                      $product[1], 
                                      $errorInInput);
                if ($errorInInput != "") {
                    $response_array['status'] = 'error';  
                    $response_array['message'] = 'Error from Server: ' . $errorInInput; 
                }
                else {
                    $response_array['status'] = 'ok';  
                    $response_array['message'] = 'lead' . ($action == "AddLead" ? ' added ' : ' updated ')  . 'successfully'; 
                }
                echo json_encode($response_array);
        }
        catch (Exception $error) {
            ErrorHandling::HandleError($error); 
        }
    }
        
    function DeleteLead(){
        try {
                $leadID = trim($_POST["id"]);
                Lead::deleteLead($leadID);
                $response_array['status'] = 'ok';  
                $response_array['message'] = 'lead deleted successfully'; 
                echo json_encode($response_array);
        }
        catch (Exception $error) {
            ErrorHandling::HandleError($error); 
        }
    }
    

?>