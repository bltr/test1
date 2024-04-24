<?php

use App\Controllers\ImportController;
use App\Controllers\MailingController;

require '../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('?', $_SERVER['REQUEST_URI']);
$uri = reset($request_uri);

try {
    if ($method === 'POST' && $uri === '/api/users/import') {
        $res = (new ImportController())->import();

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

} catch (\Throwable $exception) {
    http_response_code(500);
}


