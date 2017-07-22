<?php

$conn = oci_connect('hr', 'hr', '192.168.81.234/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Prepare the statement
$stid = oci_parse($conn, 'SELECT * FROM contacts');
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
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $contact = array();
        $contact["contact_id"] = $row["CONTACT_ID"];
        $contact["full_name"] = $row["FULL_NAME"];
        $contact["mobile_no"] = $row["MOBILE_NO"];

    array_push($response,$contact);

}
    // echoing JSON response
    echo json_encode($response);
oci_free_statement($stid);
oci_close($conn);

?>
