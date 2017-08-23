<?php

    class Validations { 


        public static function nameOK($name) {
            if($name == '')
            {
                return false;
            }
            return true;
        }

        public static function phoneOK($phone) {
            if(!ctype_digit($phone))
            {
                return false;
            }
            return true;
        }

        public static function optionSelected($option) {
            if($option == '0')
            {
                return false;
            }
            return true;
        }
    }
