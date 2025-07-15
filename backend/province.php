<?php
     require_once "func.php";


   
  function getProvince()
  {
    $con = dbConnect();
    if(!$con)
    {
        return false;
    }

    $stmt = $con->prepare("SELECT * FROM tbl_province");
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc())
    {
        $data[] = $row;

    }
    $stmt->close();
    return $data;
    
  }   

    if(isset($_GET['id']))
    {   header('Content-Type: application/json');
        echo getDistrict($_GET['id']);
    }

    function getDistrict($provinceID)
  {
     $con = dbConnect();
    if(!$con)
    {
        return false;
    }
    $stmt = $con->prepare("SELECT * FROM tbl_district where province_id = ?");
    $stmt->bind_param("i",$provinceID);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc())
    {
        $data[] = $row;

    }
    $stmt->close();
    return json_encode($data);

  }   
  
  