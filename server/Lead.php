<?php
error_reporting(0);
require_once 'Share/Validations.php';
require_once 'Bll/BusinessLogicLayer.php';

    class Lead implements JsonSerializable { 

        private $id;
        private $lead_name;
        private $lead_phone;
        private $product_id;
        private $product_name;

        public function __construct($ld_id, $ld_name, $ld_phone, $prod_id, $prod_name, &$errorInInput){
            $this->setID($ld_id);
            $this->setLeadName($ld_name, $errorInInput);
            $this->setLeadPhone($ld_phone, $errorInInput); 
            $this->setProduct_ID($prod_id, $errorInInput); 
            $this->setProduct_Name($prod_name); 
        }

        public function getID(){
            return $this->id;
        }

        public function getLeadName(){
            return $this->lead_name;
        }

        public function getLeadPhone(){
            return $this->lead_phone;
        }

        public function getProduct_ID(){
            return $this->product_id;
        }

        public function getProduct_Name(){
            return $this->product_name;
        }

        public function setID($ld_id){
            $this->id = $ld_id;
        }

        public function setLeadName($ld_name, &$errorInInput){
            if(!Validations::nameOK($ld_name)){
                $errorInInput .= " Lead Name cannot be empty\n";
            }
            $this->lead_name = $ld_name;
        }

        public function setLeadPhone($ld_phone, &$errorInInput){
            if(!Validations::phoneOK($ld_phone)){
                $errorInInput .= " Lead phone must contain a valid number\n";
            }
            $this->lead_phone = $ld_phone;
        }

        public function setProduct_ID($prod_id, &$errorInInput){
            if(!Validations::optionSelected($prod_id)){
                $errorInInput .= " Please select product\n";
            }
            $this->product_id = $prod_id;
        }

        public function setProduct_Name($prod_name){
            $this->product_name = $prod_name;
        }

        public static function getLeads() {
            try {
                $emptyParms = []; 
                $allLeads = array();
                $errors = "";

                $resultSet = BusinessLogicLayer::get('crm', 'get_Leads', $emptyParms);
                while ($row = $resultSet->fetch())
                {                           
                  array_push($allLeads, new Lead($row['lead_id'], $row['lead_name'], $row['lead_phone'], $row['product_id'], $row['product_name'], $errors));
                }
                return $allLeads;
            }
            catch (Exception $error) {
                throw $error;
            }
        }

        public static function addLead($ld_name, $ld_phone, $prod_id, $prod_name, &$errorInInput) {
            try {
                    $Lead = new Lead(0, $ld_name, $ld_phone, $prod_id, $prod_name, $errorInInput);
                    if ($errorInInput != "") { //error found in data members of lead object
                        return;
                    }
                    $Parms =  array();
                    array_push($Parms, new PDO_Parm("lead_name", $Lead -> getLeadName(), 'string')); 
                    array_push($Parms, new PDO_Parm("lead_phone", $Lead -> getLeadPhone(), 'string'));
                    array_push($Parms, new PDO_Parm("product_id", $Lead -> getProduct_ID(), 'integer'));
                    $lead = BusinessLogicLayer::get('crm', 'check_Lead_exists', $Parms);
                    if ($lead->rowCount() > 0) { // lead with same name, phone & product already exists
                        $errorInInput = "lead with same name, phone & product already exists";
                        return;
                    }
                    BusinessLogicLayer::update('crm', 'insert_lead', $Parms);
            }
            catch (Exception $error) {
                throw $error;
            }
        }

        public function jsonSerialize() {
            try {
                    return  [
                                'id' => $this->getID(),
                                'lead_name' => $this->getLeadName(),
                                'lead_phone' => $this->getLeadPhone(),
                                'product_id' => $this->getProduct_ID(),
                                'product_name' => $this->getProduct_Name()
                            ];
                }
                catch (Exception $error) {
                    throw $error;
                }
    }
}

