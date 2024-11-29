<?php
// Include the configuration file to establish a database connection
include('vendor/inc/config.php');

// Check if vehicle category and pickup location are provided in the POST request
if (isset($_POST['v_category']) && isset($_POST['pickup_location'])) {
    $v_category = $_POST['v_category']; // Retrieve the vehicle category from the POST request
    $pickup_location = $_POST['pickup_location']; // Retrieve the pickup location from the POST request
    
    // Prepare the SQL query to fetch available vehicles of the specified category
    $query = "SELECT v.v_id, v.v_reg_no, v.v_location, v.v_cost 
              FROM tms_vehicle v 
              WHERE v.v_category = ? AND v.v_status = 'Available'";
    
    // Prepare the SQL statement
    $stmt = $mysqli->prepare($query);
    // Bind the vehicle category parameter to the SQL query
    $stmt->bind_param('s', $v_category);
    // Execute the query
    $stmt->execute();
    // Get the result set from the executed query
    $result = $stmt->get_result();
    
    // Initialize an array to store vehicle details
    $vehicles = array();
    // Fetch each row from the result set
    while ($row = $result->fetch_assoc()) {
        // Check if the vehicle location is not empty
        if (!empty($row['v_location'])) {
            // Add vehicle details to the array
            $vehicles[] = array(
                'v_id' => $row['v_id'],
                'v_reg_no' => $row['v_reg_no'],
                'v_location' => $row['v_location'],
                'v_cost' => $row['v_cost']
            );
        }
    }
    
    // Set the content type to JSON
    header('Content-Type: application/json');
    // Return the vehicle details as a JSON object
    echo json_encode($vehicles);
}
?>
