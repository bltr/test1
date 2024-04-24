<?php

require '../vendor/autoload.php';

use App\Controllers\ImportController;
use App\Controllers\MailingController;
use App\Exceptions\ValidationException;

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('?', $_SERVER['REQUEST_URI']);
$uri = reset($request_uri);

try {
    if ($method === 'POST' && $uri === '/api/users/import') {
        $res = (new ImportController())->import($_FILES);

        header('Content-Type: application/json');
        echo json_encode($res);
        exit;
    }

    if ($method === 'POST' && $uri === '/api/users/mailing') {
        $res = (new MailingController())->send();

        header('Content-Type: application/json');
        echo json_encode($res);
        exit;
    }

    http_response_code(404);

} catch (ValidationException $exception) {
    header('Content-Type: application/json');
    http_response_code(422);
    echo json_encode(['error' => $exception->getMessage()]);
} catch (\Throwable $exception) {
    http_response_code(500);
    // echo $exception->getMessage();
}


