<?php
session_start();
require_once 'func.php';  

function getHostelName($user_id){
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM tbl_hostel where status = 'Approved' and user_id = ?");
     $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc())
     {
        
        $data[] = $row;
    }
    $stmt->close();
    return $data;

 
}



?>