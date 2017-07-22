<?php
if (isset($_POST["DEPARTMENT_ID"]) && isset($_POST["DEPARTMENT_NAME"]) && isset($_POST["MANAGER_ID"]) && isset($_POST["LOCATION_ID"])) {


$conn = oci_connect('hr', 'hr', '192.168.81.234/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Prepare the statement
$s.tid = oci_parse($conn, 'UPDATE departments
SET department_name =:department_name , manager_id=:manager_id, location_id=:location_id
WHERE department_id = :department_id');


$deptId = $_POST["DEPARTMENT_ID"];
$deptName = $_POST["DEPARTMENT_NAME"];
$managerId=$_POST["MANAGER_ID"];
$locationId=$_POST["LOCATION_ID"];

//sql injection protection
oci_bind_by_name($stid, ':department_id', $deptId);
oci_bind_by_name($stid, ':department_name', $deptName);
oci_bind_by_name($stid,':manager_id',$managerId);
oci_bind_by_name($stid,':location_id',$locationId);



if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Fetch the results of the query
$response= array();
if($r){
        $department = array();
        $department["department_id"] = $deptId;
        $department["department_name"] = $deptName;
        $department["manager_id"] = $managerId;
        $department["location_id"] = $locationId;
        array_push($response,$department);

}
    // echoing JSON response
    echo json_encode($response);
oci_free_statement($stid);
oci_close($conn);
}
?>
