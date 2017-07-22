<?php

// check for required fields
if (isset($_POST["DEPARTMENT_ID"])) {
 $conn = oci_connect('hr', 'hr', '192.168.81.234/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
$deptID = $_POST["DEPARTMENT_ID"];
$response = array();
$stid = oci_parse($conn, 'SELECT * FROM departments WHERE department_id= :department_id');
//sql injection protection
oci_bind_by_name($stid, ':department_id', $deptID);
$r = oci_execute($stid);  //executes and commits


if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Fetch the results of the query
$response= array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $department = array();
        $Location=array();
        $department["department_id"] = $row["DEPARTMENT_ID"];
        $department["department_name"] = $row["DEPARTMENT_NAME"];
        $department["manager_id"] = $row["MANAGER_ID"];
        $department["location_id"] = $row["LOCATION_ID"];
    array_push($response,$department);

}
    // echoing JSON response
    echo json_encode($response);
oci_free_statement($stid);
oci_close($conn);
}
?>
