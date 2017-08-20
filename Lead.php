<?php
    require_once 'Connection.php';
    require_once 'PDO_Parm.php';

    class Lead { 

        //members must be public so that  JSON_encode($streets); in function GetDisplayStreets() in CitiesApi.php will work
        public $id;
        public $lead_name;
        public $lead_phone;
        public $product_id;
        public $product_name;
      
        public function __construct($ld_id, $ld_name, $ld_phone, $prod_id, $prod_name){
            $this->setID($ld_id);
            $this->setLeadName($ld_name);
            $this->setLeadPhone($ld_phone); 
            $this->setProduct_ID($prod_id); 
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

        public function setLeadName($ld_name){
            $this->lead_name = $ld_name;
        }

        public function setLeadPhone($ld_phone){
            $this->lead_phone = $ld_phone;
        }

        public function setProduct_ID($prod_id){
            $this->product_id = $prod_id;
        }

        public function setProduct_Name($prod_name){
            $this->product_name = $prod_name;
        }

        public static function getLeads() {
        //select statement has no parameters for sql statement -> must send empty parms: executeSP is general function that executes sql sp with and without parameters
            $emptyParms = []; 
            $con = new Connection('crm');
            $sp = $con->executeSP("get_Leads", $emptyParms);

            $allLeads = array();
            while ($row = $sp->fetch())
            {                           
               array_push($allLeads, new Lead($row['lead_id'], $row['lead_name'], $row['lead_phone'], $row['product_id'], $row['product_name']));
            }
            return $allLeads;
        }

    }

