<?php

// check for required fields
if (isset($_POST["SMS_TEXT"]) && isset($_POST["RECIEPIENT_NO"])) {
 $conn = oci_connect('hr', 'hr', '192.168.81.234/XE');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$response = array();
$stid = oci_parse($conn, 'INSERT INTO sms_logs (sms_text,reciepient_no) VALUES(:SMS_TEXT,:RECIEPIENT_NO)');



$smsText=$_POST["SMS_TEXT"];
$reciepient_no=$_POST["RECIEPIENT_NO"];

//sql injection protection

oci_bind_by_name($stid,':SMS_TEXT',$smsText);
oci_bind_by_name($stid,':RECIEPIENT_NO',$reciepient_no);

$r = oci_execute($stid);  //executes and commits

if ($r) {
$response["sms_text"]=$smsText;
$response["reciepient_no"]=$reciepient_no;
echo json_encode($response);
}
else{
  echo json_encode("Failed");
}
oci_free_statement($stid);
oci_close($conn);
}
?>
