<?php

$s = array();

$q = isset($_GET['q']) ? addslashes(strip_tags(trim($_GET['q']))) : null;
$r = shell_exec("cd /home/ups/public_html/LexIntel/chatbot/ && /home/ups/public_html/LexIntel/.venv/bin/python /home/ups/public_html/LexIntel/chatbot/final_script.py " . $q);

//Clear excess newlines
$r = preg_replace('/^\h*\v+/m', '', $r);
$data = array("response" => $r);

if (empty($q)) {
    $s['status'] = "error"; 
    $s['message'] = "Query is empty. Still, a response is received";
    $s['response'] = $data['response'];
} else {
    $s['status'] = "success";
    $s['query'] = $q;
    $s['response'] = $data['response'];
}

//CORS Origin Policy
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header("Content-type: application/json; charset=utf-8");

echo json_encode($s);
