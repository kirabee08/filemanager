<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->login = $data->login;
$user->password = $data->password;

if (
    !empty($user->login) &&
    !empty($user->password) &&
    $user->create()
) {
    http_response_code(200);

    $token = array(
        'iss' => $iss,
        'aud' => $aud,
        'iat' => $iat,
        'nbf' => $nbf,
        'data' => array(
            'id' => $user->id,
            'login' => $user->login
        )
    );

    $jwt = JWT::encode($token, $key);
        echo json_encode(
            array(
                'message' => 'User was created',
                'token' => $jwt,
                'user' => array(
                    'login' => $user->login
                )
            )
        );
} else {
    http_response_code(400);
    echo json_encode(
        array(
            "message" => "Unable to create user"
        )
    );
}
?>