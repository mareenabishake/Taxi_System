<?php
// Include the configuration file to establish a database connection
include('vendor/inc/config.php');

// Check if the vehicle ID is provided in the POST request
if (isset($_POST['v_id'])) {
    $v_id = $_POST['v_id']; // Retrieve the vehicle ID from the POST request
    
    // Prepare the SQL query to fetch vehicle cost and driver details
    $query = "SELECT v.v_cost, v.d_id, CONCAT(d.d_fname, ' ', d.d_lname) AS driver_name 
              FROM tms_vehicle v 
              LEFT JOIN tms_driver d ON v.d_id = d.d_id 
              WHERE v.v_id = ?";
    
    // Prepare the SQL statement
    $stmt = $mysqli->prepare($query);
    // Bind the vehicle ID parameter to the SQL query
    $stmt->bind_param('i', $v_id);
    // Execute the query
    $stmt->execute();
    // Get the result set from the executed query
    $result = $stmt->get_result();
    
    // Check if a row is returned
    if ($row = $result->fetch_assoc()) {
        // Create a response array with driver and vehicle details
        $response = array(
            'driver_name' => $row['driver_name'],
            'd_id' => $row['d_id'],
            'v_cost' => $row['v_cost']
        );
        // Return the response as a JSON object
        echo json_encode($response);
    } else {
        // Return an error message if no vehicle or driver is found
        echo json_encode(array('error' => 'Vehicle or driver not found'));
    }
    
    // Close the prepared statement
    $stmt->close();
} else {
    // Return an error message if no vehicle ID is provided
    echo json_encode(array('error' => 'No vehicle ID provided'));
}

// Close the database connection
$mysqli->close();
?>
