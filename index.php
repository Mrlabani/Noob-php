<?php
// File upload script + webhook handler

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle webhook first
    if (isset($_GET['webhook'])) {
        $input = file_get_contents("php://input");

        $payload = json_decode($input, true);
        if ($payload) {
            // Store webhook data
            file_put_contents("webhook.log", print_r($payload, true), FILE_APPEND);
            http_response_code(200);
            echo "Webhook received.";
            exit;
        } else {
            http_response_code(400);
            echo "Invalid webhook.";
            exit;
        }
    }
    // Handle file upload
    else if (isset($_FILES['file'])) {
        $filename = basename($_FILES['file']['name']);
        $temp = $_FILES['file']['tmp_name'];

        if (move_uploaded_file($temp, "uploads/" . $filename)) {
            echo "<p>File successfully uploaded. File URL: <a href='/uploads/$filename'>/uploads/$filename</a></p>";
        } else {
            echo "<p>Failed to upload.</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>File Upload</title></head>
<body>
    <h1>File Upload</h1>
    <form action="/" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

    <h2>Webhook</h2>
    <p>Send webhook data to <code>/?webhook=1</code> with a JSON payload in the body.</p>

</body>
</html>
