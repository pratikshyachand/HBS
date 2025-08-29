<?php
    require "db-config.php";

/**
 * The dbConnect function connects php with MySQL server.
 * @param The function does not take any parameters.
 * @return The function returns the mysqli object on success, or false on failure.
 */

    function dbConnect(){
        try{
        $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
       
        return $mysqli;
        }
        catch(mysqli_sql_exception $e){
            die("Connection failed: " . mysqli_connect_error());
        }
    }

