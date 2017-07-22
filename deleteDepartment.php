<?php

if (isset($_POST["DEPARTMENT_ID"])) {
 $conn = oci_connect('hr', 'hr', '192.168.81.234/XE');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
$response = array();
$stid = oci_parse($conn, "DELETE FROM departments WHERE department_id =:department_id");
$deptId = $_POST["DEPARTMENT_ID"];
//sql injection protection
oci_bind_by_name($stid, ':department_id', $deptId);
$r = oci_execute($stid);  //executes and commits

if ($r) {
$response["department_id"]=$deptId;
echo json_encode($response);
}
else{
  echo json_encode("Failed");
}
oci_free_statement($stid);
oci_close($conn);

}
?>
