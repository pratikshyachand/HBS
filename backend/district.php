<?php
     require_once "func.php";


     $errors = array();

   if(isset($_GET["id"]))
    {   header('Content-Type: application/json');
        echo getMunicipality($_GET["id"]);
    }

  function getMunicipality($districtID)
  {
    $con = dbConnect();
    if(!$con)
    {
        return false;
    }

    $stmt = $con->prepare("SELECT * FROM tbl_municipality where district_id = ?");
    $stmt->bind_param("i",$districtID);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc())
    {
        $data[] = $row;

    }
    $stmt->close();
    return json_encode($data);
  }    

//user clicker hostel registration submit button
// Handle form submission
if (isset($_POST['btn_submit'])) {
    $type           = trim($_POST['type']);
    $owner          = trim($_POST['owner_name']);
    $hostelName     = trim($_POST['hostel_name']);
    $panNo          = trim($_POST['pan_no']);
    $provinceID     = (int)$_POST['province'];
    $districtID     = (int)$_POST['district'];
    $municipalityID = (int)$_POST['municipality'];
    $wardNo         = (int)$_POST['ward_no'];
    $email          = trim($_POST['emailID']);
    $contact        = trim($_POST['contact']);
    $userID         = 41; // Temporary placeholder
    $status         = 'Pending';
    $isDelete = 0;

    // Validate input
    if (empty($type) || empty($owner) || empty($hostelName) || empty($panNo) || empty($email) || empty($provinceID) ||
        empty($districtID) || empty($municipalityID) || empty($wardNo) || empty($contact)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^[0-9]{10}$/", $contact)) {
        $errors[] = "Invalid contact number.";
    }

    if (!preg_match("/^[0-9]{9}$/", $panNo)) {
        $errors[] = "Invalid pan number.";
    }

    if ($wardNo<1 || $wardNo>32){
        $errors[] = "Ward number must be between 1 and 32.";
    }

    // Check for existing email
    if (empty($errors)) {
        try {
            $con = dbConnect();
            $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $errors[] = "This email is already linked to an account.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Email check failed: " . $e->getMessage());
            die("Error checking email.");
        }
    }

    //Check for existing pan
     if (empty($errors)) {
        try {
            $con = dbConnect();
            $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE pan_no = ?");
            $stmt->bind_param("s", $panNo);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $errors[] = "Hostel with this pan number already exists.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Email check failed: " . $e->getMessage());
            die("Error checking email.");
        }
    }

    // Handle file upload
    $documentPath = null;
    if (isset($_FILES['doc_img']) && $_FILES['doc_img']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['doc_img']['tmp_name'];
        $original = $_FILES['doc_img']['name'];
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($ext, $allowed)) {
            $newName = uniqid("doc_", true) . "." . $ext;
            $uploadDir = "uploads/docs/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $documentPath = $uploadDir . $newName;

            if (!move_uploaded_file($tmp, $documentPath)) {
                $errors[] = "Failed to upload document.";
            }
        } else {
            $errors[] = "Invalid document type. Only JPG, PNG, or PDF allowed.";
        }
    } else {
        $errors[] = "No business document uploaded.";
    }

    // Insert data into DB
    if (empty($errors)) {
        try {
            $stmt = $con->prepare("INSERT INTO tbl_hostel 
                (hostel_name, owner, pan_no, type, contact, email, province_id, district_id, municip_id, user_id, ward, status, business_doc, is_delete) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

            $stmt->bind_param("ssssssiiiiissi", 
                $hostelName, $owner, $panNo, $type, $contact, $email,
                $provinceID, $districtID, $municipalityID, $userID, $wardNo, $status, $documentPath,$isDelete);

            if ($stmt->execute()) {
                echo "<script>alert('Hostel registered successfully!');</script>";
                $hostel_id = $stmt->insert_id;
                $message = "New hostel registration: " .$hostelName;
                $link = "../admin/registration-req.php";

                $notif_stmt = $con->prepare("INSERT INTO notifications ( message, link) VALUES (?, ?)");
                $notif_stmt->bind_param("ss", $message, $link);
                $notif_stmt->execute();
                $notif_stmt->close();

                exit();
            } else {
                die("Insert failed: " . $stmt->error);
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Insert failed: " . $e->getMessage());
            die("Something went wrong during registration.");
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}

function getHostelName(){
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM tbl_hostel");
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc())
     {
        
        $data[] = $row;
    }
    $stmt->close();
    return $data;

 
}

//user clicked on select-hostel dropdown menu to manage its profile
if (isset($_POST['hostel_id']))
 {
    $hostel_id = $_POST['hostel_id'];
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE id = ?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hostel = $result->fetch_assoc();
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($hostel);
    exit();
}

// user clicked save changes button after editing
if(isset($_POST['btnSave']))
{
    $type           = trim($_POST['type']);
    $owner          = trim($_POST['owner_name']);
    $hostelName     = trim($_POST['hostel_name']);
    $provinceID     = (int)$_POST['province'];
    $districtID     = (int)$_POST['district'];
    $municipalityID = (int)$_POST['municipality'];
    $wardNo         = (int)$_POST['ward_no'];
    $email          = trim($_POST['emailID']);
    $contact        = trim($_POST['contact']);
    $userID         = 41; // Temporary placeholder
    $status         = 0;
    $description    = $_POST['description'];
    
    // Validate input
    if (empty($type) || empty($owner) || empty($hostelName) || empty($email) || empty($description) || empty($provinceID) ||
        empty($districtID) || empty($municipalityID) || empty($wardNo) || empty($contact)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^[0-9]{10}$/", $contact)) {
        $errors[] = "Invalid contact number.";
    }


    if ($wardNo<1 || $wardNo>32){
        $errors[] = "Ward number must be between 1 and 32.";
    }

 

     // Insert data into DB
    if (empty($errors)) {
        $con = dbConnect();
        try {
            $stmt = $con->prepare("UPDATE tbl_hostel set
                hostel_name = ?, owner = ?, type = ?, contact = ?, province_id = ?, district_id = ?, municip_id = ?, user_id = ?, ward = ?, description = ? where email = ? ");
               

            $stmt->bind_param("ssssiiiiiss", 
                $hostelName, $owner, $type, $contact,
                $provinceID, $districtID, $municipalityID, $userID, $wardNo,  $description, $email);

            if ($stmt->execute()) {
                echo "<script>alert('Saved changes successfully!');</script>";
                exit();
            } else {
                die("Insert failed: " . $stmt->error);
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Insert failed: " . $e->getMessage());
            die("Something went wrong during saving changes.");
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }

}

    