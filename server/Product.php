<?php
    require_once 'Dal/Connection.php';
    require_once 'Dal/PDO_Parm.php';

    class Product  implements JsonSerializable { 

        //members must be public so that  JSON_encode($streets); in function GetDisplayStreets() in CitiesApi.php will work
        private $id;
        private $name;
      
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
            try {
                $emptyParms = []; 
                $allProducts = array();
                
                $resultSet = BusinessLogicLayer::get('crm', 'get_Products', $emptyParms);
                
                while ($row = $resultSet->fetch())
                {                           
                  array_push($allProducts, new Product($row['id'], $row['product_name']));
                }
                return $allProducts;
            }
            catch (Exception $error) {
                throw $error;
            }

        }

        public function jsonSerialize() {
            return  [
                        'id' => $this->getID(),
                        'name' => $this->getName() 
                    ];
        }


    }

