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

function getHostelDetails(){
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM tbl_hostel");
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc())
        $data[] = $row;
    
    $stmt->close();
    return $data;
}