
<?php

// check for required fields
if (isset($_POST["DEPARTMENT_NAME"]) && isset($_POST["MANAGER_ID"]) && isset($_POST["LOCATION_ID"])) {
 $conn = oci_connect('hr', 'hr', '192.168.81.234/XE');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$response = array();
$stid = oci_parse($conn, 'INSERT INTO departments (department_name,manager_id,location_id) VALUES(:department_name,:manager_id,:location_id)');

//$deptId = $_POST["DEPARTMENT_ID"];
$deptName = $_POST["DEPARTMENT_NAME"];
$managerId=$_POST["MANAGER_ID"];
$locationId=$_POST["LOCATION_ID"];

oci_bind_by_name($stid, ':department_name', $deptName);
oci_bind_by_name($stid,':manager_id',$managerId);
oci_bind_by_name($stid,':location_id',$locationId);


$r = oci_execute($stid);  //executes and commits

if ($r) {
//$response["department_id"]=$deptId;
$response["department_name"]=$deptName;
$response["manager_id"]=$managerId;
$response["location_id"]=$locationId;
echo json_encode($response);
}
else{
  echo json_encode("Failed");
}
oci_free_statement($stid);
oci_close($conn);
}
?>
