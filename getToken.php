<?php

// 请求地址
$url = 'http://192.168.1.1:5700/open/auth/token';
// 请求参数
$params = [
    'client_id' => '11111-',// 青龙应用client_id
    'client_secret' => '2222222'// 青龙应用client_secret
];
// 请求头
$headers = [
    'Accept: application/json'
];

// 将请求参数附加到 URL
$url .= '?' . http_build_query($params);

// 初始化 cURL
$ch = curl_init($url);
// 设置 GET 请求
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// 发送请求并获取响应
$response = curl_exec($ch);

// 检查是否有错误发生
if(curl_errno($ch)) {
    $error_message = curl_error($ch);
    echo "错误: $error_message";
    exit;
}

curl_close($ch);

// 解析 JSON 响应
$data = json_decode($response, true);

// 检查是否成功获取 token
if ($data && isset($data['code'])) {
    if ($data['code'] === 200 && isset($data['data']['token'])) {
        // 清空原有数据并写入新的 token
        file_put_contents('token.txt', $data['data']['token']);
        echo json_encode(['code' => 200]); // 返回成功的 JSON
    } else {
        echo json_encode(['code' => 0]); // 返回失败的 JSON
    }
} else {
    echo json_encode(['code' => 0]); // 返回失败的 JSON
}
?>
