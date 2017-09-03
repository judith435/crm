<?php
    error_reporting(0);

    require_once 'Dal/Connection.php';
    require_once 'Dal/PDO_Parm.php';



    class BusinessLogicLayer {
        // REFACTOR: use Builder pattern
        /*
            $table_name: string
            $arr: [field] => [value]
            $conds: [field] => []
        */
        public static function update($db, $spName, $SP_parms) {
            try {
                $con = new Connection($db);  
                $con->executeSP($spName, $SP_parms);
            }
            catch (Exception $error) {
                throw $error;
            }
        }

        public static function get($db, $spName, $SP_parms) {
            try {
                $con = new Connection($db);  
                return $con->executeSP($spName, $SP_parms);
            }
            catch (Exception $error) {
                throw $error;
            }
        }
    }

        // interface IBLL
    // {
    //     // public function setVariable($name, $var);
    //     // public function getHtml($template);
    // }

    // public static function getLeads() {
    //     //select statement has no parameters for sql statement -> must send empty parms: executeSP is general function that executes sql sp with and without parameters
    //     $emptyParms = []; 
    //     $allLeads = array();
    //     $errors = "";

    //     $resultSet = BusinessLogicLayer::get('crm', 'get_Leads', $emptyParms);

    //     while ($row = $resultSet->fetch())
    //     {                           
    //        array_push($allLeads, new Lead($row['lead_id'], $row['lead_name'], $row['lead_phone'], $row['product_id'], $row['product_name'], $errors));
    //     }
    //     return $allLeads;
    // }

    // public static function addLead($ld_name, $ld_phone, $prod_id, $prod_name, &$errorInInput) {
        
    //     $Lead = new Lead(0, $ld_name, $ld_phone, $prod_id, $prod_name, $errorInInput);
    //     if ($errorInInput != "") {
    //         return;
    //     }

    //     $Parms =  array();
    //     array_push($Parms, new PDO_Parm("lead_name", $Lead -> getLeadName(), 'string')); 
    //     array_push($Parms, new PDO_Parm("lead_phone", $Lead -> getLeadPhone(), 'string'));
    //     array_push($Parms, new PDO_Parm("product_id", $Lead -> getProduct_ID(), 'integer'));
    //     BusinessLogicLayer::update('crm', 'insert_lead', $Parms);
    //     echo 'new lead added successfully';

    // }

?>

