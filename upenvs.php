<?php

// 读取token
$token = file_get_contents('token.txt');

// 接收GET参数
$value = $_GET['value'] ?? '';
$name = $_GET['name'] ?? '';
$remarks = $_GET['remarks'] ?? '';

// 构建POST请求数据
$postData = json_encode([
    [
        "value" => $value,
        "name" => $name,
        "remarks" => $remarks
    ]
]);

// 构建请求头
$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer ' . $token
];

// 执行POST请求
$ch = curl_init('http://192.168.1.1:5700/open/envs');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// 解析返回的JSON数据
$responseData = json_decode($response, true);

// 提取code并输出
$code = $responseData['code'] ?? null;
echo json_encode(['code' => $code]);
