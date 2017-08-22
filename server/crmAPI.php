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
        if($leadName == '')  //testing isset($_POST["leadName"]) meaningless -> it is always true
        {
            echo 'Please enter Lead Name';
            return;
        }

        $leadPhone = trim($_POST["leadPhone"]);
        if($leadPhone == '')  //testing isset($_POST["leadName"]) meaningless -> it is always true
        {
            echo 'Please enter Lead Phone';
            return;
        }

        $product = explode(",", $_POST["product"]);//
        if($product[0] == '0')  // $_POST["product"] contains product_id, product_name; e.g. "1,חיתולים" => 1  st element  contains product code 2nd element product name
        {
            echo 'Please select product';
            return;
        }

        Lead::addLead($leadName, $leadPhone, $product[0], $product[1]);
    }
        
        

?>