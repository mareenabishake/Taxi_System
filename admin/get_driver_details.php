<?php
include('vendor/inc/config.php');

if(isset($_POST['v_reg_no'])) {
    $v_reg_no = $_POST['v_reg_no'];
    
    // Prepare the SQL query to fetch driver name, contact, and vehicle cost
    $query = "SELECT v_driver, v_driver_contact, v_cost FROM tms_vehicle WHERE v_reg_no = ?";
    $stmt = $mysqli->prepare($query);
    
    if($stmt) {
        $stmt->bind_param('s', $v_reg_no); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc(); 
            echo json_encode($row); 
        } else {
            echo json_encode(['error' => 'No data found for registration number: ' . $v_reg_no]);
        }

        $stmt->close(); // Close the statement
    } else {
        echo json_encode(['error' => 'Error in query preparation']);
    }
} else {
    echo json_encode(['error' => 'No registration number provided']);
}

$mysqli->close(); 
?>
