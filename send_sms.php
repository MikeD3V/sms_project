<?php
$data = json_decode(file_get_contents('php://input'), true);

$send_data = [
    'sender_id' => $data['sender_id'],
    'recipient' => $data['recipient'],
    'message' => $data['message']
];

$token = $data['token'];

$parameters = json_encode($send_data);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $token"
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$get_sms_status = curl_exec($ch);

if (strpos($get_sms_status, '<html') !== false) {
    echo "Error: API returned an HTML response. Possible API issue or incorrect request.";
} else {
    echo "SMS Sent! Response: " . $get_sms_status;
}
?>
