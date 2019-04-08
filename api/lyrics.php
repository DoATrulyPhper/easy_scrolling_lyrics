<?php

/**
 * 处理歌词逻辑
 *
 * @return array
 */
function getLyrics()
{
    $data = explode("\n", json_decode(file_get_contents('../lyrics/1.txt'), true)['lrc']['lyric']);
    $result = [];
    foreach ($data as $lyrics) {
        $lyr = explode(']', $lyrics);
        if (!empty($lyr[0]) && !empty($lyr[1])) {
            $time = getTime(trim($lyr[0], '['));
            $result[$time] = isset($lyr[1]) ? $lyr[1] : '';
        }
    }
    return ['code' => 200, 'data' => $result];
}

/**
 * 格式化时间
 *
 * @param $time
 * @return string
 */
function getTime($time)
{
    $time = explode(':', $time);
    $points = $time[0] * 60;
    $seconds = bcadd($points, $time[1]);
    return $seconds;
}

/**
 * 辅助函数
 * 打印 print_r
 *
 * @param $data
 */
function p($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit;
}

/**
 * @return void
 */
function response()
{
    echo json_encode(getLyrics());
    exit;
}

response();