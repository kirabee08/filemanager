<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('objects/file_directory.php');
include_once('objects/file.php');

$data = json_decode(file_get_contents("php://input"));

$directory = new FileDirectory($data->path);

$files = $directory->getFiles();
$files_info = array();

foreach ($files as $file) {
    if (!in_array($file, array('.', '..'))) {
        $file_instance = new File($data->path . '/' . $file);
        $file_info = $file_instance->getInfo();

        $info = array(
            'title' => $file,
            'size' => $file_info['size'],
            'uploadDate' => date('d.m.Y', $file_info['uploadDate'])
        );

        array_push($files_info, $info);
    }
}

if ($files && count($files) > 0) {
    http_response_code(200);
    echo json_encode(
        array(
            'message' => 'List of files',
            'files' => $files_info
        )
    );
} else {
    http_response_code(400);
    echo json_encode(
        array(
            'message' => 'No files found'
        )
    );
}
?>