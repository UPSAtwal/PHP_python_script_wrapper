<?php

$s = array();

$q = isset($_GET['q']) ? addslashes(strip_tags(trim($_GET['q']))) : null;
$r = shell_exec("cd /home/ups/public_html/LexIntel/chatbot/ && /home/ups/public_html/LexIntel/.venv/bin/python /home/ups/public_html/LexIntel/chatbot/final_script.py " . $q);

exec("cd /home/ups/public_html/LexIntel/chatbot/ && /home/ups/public_html/LexIntel/.venv/bin/python -W 'ignore' /home/ups/public_html/LexIntel/chatbot/final_script.py " . $q, $output, $return_var);

//Clear excess newlines
// $r = preg_replace('/^\h*\v+/m', '', $r);
// $data = array("response" => $r);

$output = preg_replace('/^\h*\v+/m', '', $output);
$data = array("response" => $output);

if (empty($q)) {
    $s['status'] = "error"; 
    $s['message'] = "Query is empty. Still, a response is received";
    $s['response'] = $data['response'];
} else if ($return_var != 0) {
    $s['status'] = "error"; 
    $s['message'] = "An error occurred running bash commands: " . $return_var;
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
