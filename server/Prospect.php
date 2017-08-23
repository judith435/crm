<?php
    require_once 'Dal/Connection.php';
    require_once 'Dal/PDO_Parm.php';

    class Prospect {  //prospects.id as prospect_id,prospects.prospect_name,prospects.prospect_phone,prospects.lead_id,leads.product_id,products.product_name

        //members must be public so that  JSON_encode($streets); in function GetDisplayStreets() in CitiesApi.php will work
        public $id;
        public $prospect_name;
        public $prospect_phone;
        public $lead_id;
        public $product_id;
        public $product_name;
      
        public function __construct($id, $name, $phone, $lead_id, $prod_id, $prod_name){
            $this->setID($id);
            $this->setProspectName($name);
            $this->setProspectPhone($phone); 
            $this->setLead_ID($lead_id); 
            $this->setProduct_ID($prod_id); 
            $this->setProduct_Name($prod_name); 
        }

        public function getID(){
            return $this->id;
        }

        public function getProspectName(){
            return $this->prospect_name;
        }

        public function getProspectPhone(){
            return $this->prospect_phone;
        }

        public function getLead_ID(){
            return $this->lead_id;
        }

        public function getProduct_ID(){
            return $this->product_id;
        }

        public function getProduct_Name(){
            return $this->product_name;
        }

        public function setID($id){
            $this->id = $id;
        }

        public function setProspectName($name){
            $this->prospect_name = $name;
        }

        public function setProspectPhone($phone){
            $this->prospect_phone = $phone;
        }

        public function setLead_ID($lead_id){
            $this->lead_id = $lead_id;
        }

        public function setProduct_ID($prod_id){
            $this->product_id = $prod_id;
        }

        public function setProduct_Name($prod_name){
            $this->product_name = $prod_name;
        }

        public static function getProspects() {
        //select statement has no parameters for sql statement -> must send empty parms: executeSP is general function that executes sql sp with and without parameters
            $emptyParms = []; 
            $con = new Connection('crm');
            $sp = $con->executeSP("get_Prospects", $emptyParms);

            $allProspects = array();
            while ($row = $sp->fetch())
            {                           
               array_push($allProspects, new Prospect($row['prospect_id'], 
                                                      $row['prospect_name'], 
                                                      $row['prospect_phone'], 
                                                      $row['lead_id'], 
                                                      $row['product_id'], 
                                                      $row['product_name']));
            }
            return $allProspects;
        }

    }

//prospects.id as prospect_id,prospects.prospect_name,prospects.prospect_phone,prospects.lead_id,leads.product_id,products.product_name