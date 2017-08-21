<?php
    require_once 'Connection.php';
    require_once 'PDO_Parm.php';

    class Product { 

        //members must be public so that  JSON_encode($streets); in function GetDisplayStreets() in CitiesApi.php will work
        public $id;
        public $name;
      
        public function __construct($prod_id, $prod_name){
            $this->setID($prod_id);
            $this->setName($prod_name); 
        }

        public function getID(){
            return $this->id;
        }

        public function getName(){
            return $this->name;
        }

        public function setID($prod_id){
            $this->id = $prod_id;
        }

        public function setName($prod_name){
            $this->name = $prod_name;
        }

        public static function getProducts() {
        //select statement has no parameters for sql statement -> must send empty parms: executeSP is general function that executes sql sp with and without parameters
            $emptyParms = []; 
            $con = new Connection('crm');
            $sp = $con->executeSP("get_Products", $emptyParms);

            $allProducts = array();
            while ($row = $sp->fetch())
            {                           
               array_push($allProducts, new Product($row['id'], $row['product_name']));
            }
            return $allProducts;
        }

    }

