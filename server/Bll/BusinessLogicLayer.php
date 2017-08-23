<?php
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
            $con = new Connection($db);  
            $stmt = $con->executeSP($spName, $SP_parms);
        }
        
    }
?>
