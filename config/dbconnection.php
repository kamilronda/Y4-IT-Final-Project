<?php

class Connection
{
    public function getConnection()
    {
        return new PDO("mysql:host=eu-cdbr-west-03.cleardb.net;dbname=closeapart","b8f435749b8567","990bce58",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }    
}

?>