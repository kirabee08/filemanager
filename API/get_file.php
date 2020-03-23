<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('objects/file.php');

$data = json_decode(file_get_contents("php://input"));

$file = new File($data->directory . '/' . $data->name);

$content = $file->getContent();

if ($content) {
    http_response_code(200);
    echo json_encode(
        array(
            'message' => 'File info',
            'content' => $content
        )
    );
} else {
    http_response_code(200);
    echo json_encode(
        array(
            'message' => 'File is empty'
        )
    );
}
?>