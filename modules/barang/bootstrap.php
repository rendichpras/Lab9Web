<?php

if (!isset($method, $page)) {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/input.php';
