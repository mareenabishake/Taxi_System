<?php
include('vendor/inc/config.php');

if(isset($_POST['v_category']) && isset($_POST['pickup_location'])) {
    $v_category = $_POST['v_category'];
    $pickup_location = $_POST['pickup_location'];
    
    // Get all available vehicles with their details
    $query = "SELECT v.v_id, v.v_reg_no, v.v_location, v.v_cost 
             FROM tms_vehicle v 
             WHERE v.v_category = ? AND v.v_status = 'Available'";
             
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $v_category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $vehicles = array();
    while($row = $result->fetch_assoc()) {
        // Only include vehicles with location set
        if (!empty($row['v_location'])) {
            $vehicles[] = array(
                'v_id' => $row['v_id'],
                'v_reg_no' => $row['v_reg_no'],
                'v_location' => $row['v_location'],
                'v_cost' => $row['v_cost']
            );
        }
    }
    $stmt->close();
    
    header('Content-Type: application/json');
    echo json_encode($vehicles);
}
?>
