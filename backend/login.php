<?php
    require "func.php";


    function login($username, $password){
        $mysqli = dbConnect();
        $query = "select username from tbl_user where password = '$password'";


        if($result = $mysqli->query($query)){

        //echo "successful";

        /*--------- numeric array ---------*/
        //while ($row = $result->fetch_array(MYSQLI_NUM))

        //$array[][];
        //$array[];
        $row = $result->fetch_array(MYSQLI_NUM);

        if ($username === $row[0])
            return true;
        else
            return false;
        }

        else
            echo "Error updating: " . $mysqli->error;
	    $mysqli->close();
    }