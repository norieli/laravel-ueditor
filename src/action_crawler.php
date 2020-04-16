<?php
namespace Norie\Laravel\UE;
/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14 OMG 今天是2020-04-14
 * Time: 下午19:18
 */
set_time_limit(0);

/* 上传配置 */
$config = array(
    "pathFormat" => config('ueditor.catcherPathFormat'),
    "maxSize" => config('ueditor.catcherMaxSize'),
    "allowFiles" => config('ueditor.catcherAllowFiles'),
    "oriName" => "remote.png"
);
$fieldName = config('ueditor.catcherFieldName');

/* 抓取远程图片 */
$list = array();
if (isset($_POST[$fieldName])) {
    $source = $_POST[$fieldName];
} else {
    $source = $_GET[$fieldName];
}
foreach ($source as $imgUrl) {
    $item = new Uploader($imgUrl, $config, "remote");
    $info = $item->getFileInfo();
    array_push($list, array(
        "state" => $info["state"],
        "url" => $info["url"],
        "size" => $info["size"],
        "title" => htmlspecialchars($info["title"]),
        "original" => htmlspecialchars($info["original"]),
        "source" => htmlspecialchars($imgUrl)
    ));
}

/* 返回抓取数据 */
return json_encode(array(
    'state'=> count($list) ? 'SUCCESS':'ERROR',
    'list'=> $list
));