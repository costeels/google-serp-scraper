<?php
if (!is_file('config.php')) {
    throw new Exception('Unable to open configuration file: ./config.php. Please use config.default.php for example.');
}
$config = require('config.php');
include 'BooApi.php';
$booapi = new Booapi($config['apiKey'], $config['baseApiUrl']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['keywords' => preg_split('/\s*[,\r\n]+\s*/', $_POST['keywords'])];
    foreach (['googleId', 'device', 'hl', 'noreask'] as $field) {
        if (isset($_POST[$field]) && $_POST[$field] != '') {
            $data[$field] = $_POST[$field];
        }
    }
    $result = $booapi->createTask($data);
    if (isset($result['id'])) {
        $queryParams = [
            'taskId' => $result['id'],
            'domain' => $_POST['domain'],
        ];
        header('Location: ?' . http_build_query($queryParams));
        exit();
    } else {
        $errors = isset($result['errors']) ? $result['errors'] : null;
        include 'views/new.php';
    }
} elseif (isset($_GET['taskId'])) {
    $taskId = $_GET['taskId'];
    $domain = $_GET['domain'];
    $status = $booapi->getTaskStatus($taskId);
    if (isset($status['errors'])) {
        $errors = $status['errors'];
        unset($status);
    } elseif ($status['status'] == 'finished') {
        $limit     = min($status['total'], 100);
        $offset    = 0;
        $response  = $booapi->getTaskResults($taskId, $limit, $offset);
        $positions = [];
        foreach ($response['results'] as $serp) {
            $position = [
                'query'    => $serp['query'],
                'position' => null,
                'url'      => null,
            ];
            foreach ($serp['organic'] as $serpItem) {
                if ($serpItem['domain'] == $domain) {
                    $position['position'] = $serpItem['position'];
                    $position['url']      = $serpItem['url'];
                    break;
                }
            }
            $positions[] = $position;
        }
    }
    include 'views/result.php';
} else {
    include 'views/new.php';
}
