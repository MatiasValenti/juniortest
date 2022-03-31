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
}

?>