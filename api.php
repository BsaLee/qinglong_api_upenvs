<?php

// 检查是否传递了必须的参数
if (!isset($_GET['value']) || !isset($_GET['name'])) {
    // 如果 value 或 name 参数不存在，返回错误信息
    $response = array(
        'error' => '必须提供 value 和 name 参数'
    );
    echo json_encode($response);
    exit;
}

// 获取传递的参数值
$value = $_GET['value'];
$name = $_GET['name'];
$remarks = isset($_GET['remarks']) ? $_GET['remarks'] : '';

// 如果 remarks 参数为空，传递当前时间
if (empty($remarks)) {
    $remarks = date('Y-m-d H:i:s');
}

// 执行 /getToken.php 的 GET 请求
$getTokenUrl = 'http://127.0.0.1/getToken.php';
$ch = curl_init($getTokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// 解析返回的 JSON 数据
$responseData = json_decode($response, true);

// 检查返回的 code 是否为 200
if (isset($responseData['code']) && $responseData['code'] == 200) {
    // 构造请求参数数组
    $params = array(
        'value' => $value,
        'name' => $name,
        'remarks' => $remarks
    );

    // 构造 upenvs.php 的请求 URL
    $upenvsUrl = 'http://127.0.0.1/upenvs.php?' . http_build_query($params);

    // 执行 upenvs.php 的 GET 请求
    $ch = curl_init($upenvsUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // 输出 upenvs.php 返回的 JSON 数据
    echo $response;
} else {
    // 如果返回的 code 不为 200，则返回固定错误信息
    $response = array(
        'error' => '出错了，请联系管理员'
    );
    echo json_encode($response);
}
