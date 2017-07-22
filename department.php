<?php

$conn = oci_connect('hr', 'hr', '192.168.81.234/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Prepare the statement
$stid = oci_parse($conn, 'SELECT departments.department_id,departments.department_name,departments.manager_id,employees.first_name,employees.last_name
,departments.location_id,locations.street_address,locations.postal_code,locations.city,locations.state_province,locations.country_id
FROM departments
LEFT JOIN employees ON departments.manager_id=employees.employee_id
LEFT JOIN locations ON departments.location_id=locations.location_id');
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
$response["departments"]= array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $department = array();
        $manager=array();
        $loc=array();



        //for manager object
        $manager["employee_id"]=$row["MANAGER_ID"];
        $manager["first_name"]=$row["FIRST_NAME"];
        $manager["last_name"]=$row["LAST_NAME"];
        //for location object
        $loc["location_id"]=$row["LOCATION_ID"];
        $loc["street_address"]=$row["STREET_ADDRESS"];
        $loc["postal_code"]=$row["POSTAL_CODE"];
        $loc["city"]=$row["CITY"];
        $loc["state_province"]=$row["STATE_PROVINCE"];
        $loc["country"]=$row["COUNTRY_ID"];
        //for deparment object
        $department["department_id"] = $row["DEPARTMENT_ID"];
        $department["department_name"] = $row["DEPARTMENT_NAME"];
        $department["manager"] = $manager;
        $department["location"] = $loc;
    array_push($response["departments"],$department);
}
    //echoing JSON response
    echo json_encode($response);
oci_free_statement($stid);
oci_close($conn);

?>
