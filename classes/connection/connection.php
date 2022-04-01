<?php

class connection {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connectionDb;

    function __construct()
    {
        $listdata = $this->connectionData();
        foreach ($listdata as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->connectionDb = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if($this->connectionDb->connect_errno){
            echo "Connection failed";
            die();
        }
    }

    private function connectionData() {
        $direction = dirname(__FILE__);
        $jsondata = file_get_contents($direction . "/" . "config");
        return json_decode($jsondata, true);

    }

    private function UTF8Convertor($array) {
        array_walk_recursive($array, function(&$item,$key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }
    





    public function getData($sqlquery){
        $results = $this->connectionDb->query($sqlquery);
        $resultArr = array();
        foreach ($results as $key) {
            $resultArr[] = $key ;
        };
        return $this->UTF8Convertor($resultArr);
    }



    public function postData($sqlquery){
        $results = $this->connectionDb->query($sqlquery);
        return $this->connectionDb->affected_rows;
    }

    public function postDataId($sqlquery){
        $results = $this->connectionDb->query($sqlquery);
        $rows = $this->connectionDb->affected_rows;
        if ($rows >= 1){
            return $this->connectionDb->insert_id;
        } else {
            return 0;
        }
    }
}




?>