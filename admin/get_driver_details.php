<?php
include('vendor/inc/config.php');

if(isset($_POST['v_reg_no'])) {
    $v_reg_no = $_POST['v_reg_no'];

    $query = "SELECT v_driver, v_driver_contact FROM tms_vehicle WHERE v_reg_no = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $v_reg_no);
    $stmt->execute();
    $stmt->bind_result($v_driver, $v_driver_contact);
    $stmt->fetch();

    $driver_details = array(
        'v_driver' => $v_driver,
        'v_driver_contact' => $v_driver_contact
    );

    echo json_encode($driver_details);
}
?>
