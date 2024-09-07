<?php
include('vendor/inc/config.php');

if(isset($_POST['car_type'])){
    $car_type = $_POST['car_type'];

    // Select only available vehicles of the chosen category
    $query = "SELECT v_reg_no FROM tms_vehicle WHERE v_category=? AND v_status='Available'";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $car_type);
    $stmt->execute();
    $res = $stmt->get_result();
    
    while($row = $res->fetch_object()) {
        echo '<option value="'.$row->v_reg_no.'">'.$row->v_reg_no.'</option>';
    }
}
?>
