<?php

     require_once "func.php";
     require_once "auth_check.php";
     
     
   $popup_message = [] ;

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
    $userID         = $_SESSION['user_id'];
    $status         = 'Pending';
    $isDelete = 0;

    // Validate input
    if (empty($type) || empty($owner) || empty($hostelName) || empty($panNo) || empty($email) || empty($provinceID) ||
        empty($districtID) || empty($municipalityID) || empty($wardNo) || empty($contact)) {
        $popup_message[] = "❌ All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $popup_message[] = "⚠️ Invalid email format.";
    }

    if (!preg_match("/^[0-9]{10}$/", $contact)) {
        $popup_message[] = "⚠️ Invalid contact number.";
    }

    if (!preg_match("/^[0-9]{9}$/", $panNo)) {
        $popup_message[] = "⚠️ Invalid pan number.";
    }

    if ($wardNo<1 || $wardNo>32){
        $popup_message[] = "⚠️ Ward number must be between 1 and 32.";
    }

    // Check for existing email
    if (empty($popup_message)) {
        try {
            $con = dbConnect();
            $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $popup_message[] = "⚠️ This email is already linked to an account.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Email check failed: " . $e->getMessage());
            die("Error checking email.");
        }
    }

    //Check for existing pan
     if (empty($popup_message)) {
        try {
            $con = dbConnect();
            $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE pan_no = ?");
            $stmt->bind_param("s", $panNo);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $popup_message[] = "⚠️ Hostel with this pan number already exists.";
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
                $popup_message[] = "Failed to upload document.";
            }
        } else {
            $popup_message[] = "⚠️ Invalid document type. Only JPG, PNG, or PDF allowed.";
        }
    } else {
        $popup_message[] = "⚠️ No business document uploaded.";
    }

    // Insert data into DB
    if (empty($popup_message)) {
        try {
            $stmt = $con->prepare("INSERT INTO tbl_hostel 
                (hostel_name, owner, pan_no, type, contact, email, province_id, district_id, municip_id, user_id, ward, status, business_doc, is_delete) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

            $stmt->bind_param("ssssssiiiiissi", 
                $hostelName, $owner, $panNo, $type, $contact, $email,
                $provinceID, $districtID, $municipalityID, $userID, $wardNo, $status, $documentPath,$isDelete);

            if ($stmt->execute()) {
                $popup_message[] = "✅ Hostel registeration request sent successfully.";
                $hostel_id = $stmt->insert_id;
                $message = "📢 New hostel registration: " .$hostelName;
                $link = "../frontend/admin/form_details.php?id=" .$hostel_id;
                
                $notif_stmt = $con->prepare("INSERT INTO notifications (user_id, message, link) VALUES (?,?,?)");
                $notif_stmt->bind_param("iss", $user_id, $message, $link);
               
                $notif_stmt->execute();
                $notif_stmt->close();

                
            } else {
                die("Insert failed: " . $stmt->error);
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Insert failed: " . $e->getMessage());
            die("Something went wrong during registration.");
        }
    } 
    
}


// user clicked save changes button after editing
if(isset($_POST['btnSave'])) {

    $hostel_id      = (int)$_POST['hostel_id'];
    $type           = trim($_POST['type']);
    $owner          = trim($_POST['owner_name']);
    $hostelName     = trim($_POST['hostel_name']);
    $provinceID     = (int)$_POST['province'];
    $districtID     = (int)$_POST['district'];
    $municipalityID = (int)$_POST['municipality'];
    $wardNo         = (int)$_POST['ward_no'];
    $email          = trim($_POST['emailID']);
    $contact        = trim($_POST['contact']);
    $description    = trim($_POST['description']);
    $admissionFee   = (int)$_POST['admission_fee'];  // new admission fee field
    $amenities      = isset($_POST['amenities']) ? $_POST['amenities'] : [];

    // --- Validate required fields ---
    if(empty($type) || empty($owner) || empty($hostelName) || empty($email) || empty($provinceID) || empty($districtID) || empty($municipalityID) || empty($wardNo) || empty($contact)) {
        $popup_message[] = "All fields are required.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $popup_message[] = "⚠️ Invalid email format.";
    if(!preg_match("/^[0-9]{10}$/", $contact)) $popup_message[] = "⚠️ Invalid contact number.";
    if($wardNo < 1 || $wardNo > 32) $popup_message[] = "⚠️ Ward number must be between 1 and 32.";

    // --- Handle cover image upload ---
    $coverPath = null;
    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $allowedExt = ['jpg','jpeg','png','svg'];
        $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, $allowedExt)){
            $uploadDir = "uploads/hostel_covers/";
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $coverPath = $uploadDir . uniqid("cover_", true) . "." . $ext;
            if(!move_uploaded_file($_FILES['cover_image']['tmp_name'], $coverPath)){
                $popup_message[] = "Failed to upload cover image.";
            }
        } else {
            $popup_message[] = "Invalid cover image format. Only JPG, PNG, or SVG allowed.";
        }
    }

    // --- Update DB if no errors ---
    if(empty($popup_message)) {
        $con = dbConnect();

        if($coverPath) {
            $stmt = $con->prepare("UPDATE tbl_hostel SET 
                                    hostel_name=?, owner=?, type=?, contact=?, province_id=?, district_id=?, municip_id=?, ward=?, description=?, image=?, admission_fee=?
                                    WHERE id=?");
            $stmt->bind_param("ssssiiiissii", $hostelName, $owner, $type, $contact, $provinceID, $districtID, $municipalityID, $wardNo, $description, $coverPath, $admissionFee, $hostel_id);
        } else {
            $stmt = $con->prepare("UPDATE tbl_hostel SET 
                                    hostel_name=?, owner=?, type=?, contact=?, province_id=?, district_id=?, municip_id=?, ward=?, description=?, admission_fee=?
                                    WHERE id=?");
            $stmt->bind_param("ssssiiiisii", $hostelName, $owner, $type, $contact, $provinceID, $districtID, $municipalityID, $wardNo, $description, $admissionFee, $hostel_id);
        }

        if($stmt->execute()){
        $popup_message[] = "✅ Hostel info updated successfully.";
        } else {
        $popup_message[] = "❗Update failed.";
        }

        $stmt->close();



        // Save amenities in tbl_hostel_amenities
        // First, clear old amenities
        $delStmt = $con->prepare("DELETE FROM tbl_hostel_amenities WHERE hostel_id=?");
        $delStmt->bind_param("i", $hostel_id);
        $delStmt->execute();
        $delStmt->close();

        if(!empty($amenities)) {
            $insertStmt = $con->prepare("INSERT INTO tbl_hostel_amenities (hostel_id, amenity_id) VALUES (?, ?)");
            foreach($amenities as $amenity_id){
                $insertStmt->bind_param("ii", $hostel_id, $amenity_id);
                $insertStmt->execute();
            }
            $insertStmt->close();
        }
        $con->close();
    } 
}

    