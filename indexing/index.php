<?php
if (!is_file('../config.php')) {
    throw new Exception('Unable to open configuration file: config.php. Please use config.default.php for example.');
}
$config = require('../config.php');
include '../BooApi.php';
$booapi = new Booapi($config['apiKey'], $config['baseApiUrl']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $urls = preg_split('/\s*[,\r\n]+\s*/', $_POST['urls']);
    $data = ['keywords' => []];
    foreach ($urls as $url) {
        $data['keywords'][] = "site:$url";
    }
    foreach (['googleId', 'device', 'hl', 'noreask'] as $field) {
        if (isset($_POST[$field]) && $_POST[$field] != '') {
            $data[$field] = $_POST[$field];
        }
    }
    $result = $booapi->createTask($data);
    if (isset($result['id'])) {
        $queryParams = ['taskId' => $result['id']];
        header('Location: ?' . http_build_query($queryParams));
        exit();
    } else {
        $errors = isset($result['errors']) ? $result['errors'] : null;
        include 'views/new.php';
    }
} elseif (isset($_GET['taskId'])) {
    $taskId = $_GET['taskId'];
    $status = $booapi->getTaskStatus($taskId);
    if (isset($status['errors'])) {
        $errors = $status['errors'];
        unset($status);
    } elseif ($status['status'] == 'finished') {
        $limit    = min($status['total'], 100);
        $offset   = 0;
        $response = $booapi->getTaskResults($taskId, $limit, $offset);
        $result   = [];
        foreach ($response['results'] as $serp) {
            $result[] = [
                'url'       => preg_replace('/^site:/', '', $serp['query']),
                'isIndexed' => $serp['count_results'] > 0,
            ];
        }
    }
    include 'views/result.php';
} else {
    include 'views/new.php';
}
