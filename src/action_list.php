<?php
namespace Norie\Laravel\UE;

use Illuminate\Support\Facades\Storage;

/**
 * 获取已上传的文件列表
 * 这里仅仅简单修改为读取当日所有文件，没有分页。
 */

/* 判断类型 */
switch ($_GET['action']) {
    /* 列出文件 */
    case 'listfile':
        $allowFiles = config('ueditor.fileManagerAllowFiles');
        $listSize = config('ueditor.fileManagerListSize');
        $path = config('ueditor.fileManagerListPath');
        break;
    /* 列出图片 */
    case 'listimage':
    default:
        $allowFiles = config('ueditor.imageManagerAllowFiles');
        $listSize = config('ueditor.imageManagerListSize');
        $path = config('ueditor.imageManagerListPath');
}
// $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

/* 获取参数 */
// $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
// $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
// $end = $start + $size;
$start = 0;

/* 获取文件列表 */
// $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
// $files = getfiles($path, $allowFiles);
$files = Storage::allFiles($path.date('Ymd').'/');
foreach ($files as $key => $val) {
    // if (preg_match("/\.(".$allowFiles.")$/i", $val)) {
        $list[] = array(
            'url'=> '/'.$val //substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
            // 'mtime'=> filemtime($path2)
        );
    // }
}
if (!count($files)) {
    return json_encode(array(
        "state" => "no match file",
        "list" => array(),
        "start" => $start,
        "total" => count($files)
    ));
}

/* 获取指定范围的列表 */
// $len = count($files);
// for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
//     $list[] = $files[$i];
// }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

/* 返回数据 */
$result = json_encode(array(
    "state" => "SUCCESS",
    "list" => $list,
    "start" => $start,
    "total" => count($files)
));

return $result;


/**
 * 遍历获取目录下的指定类型的文件
 * @param $path
 * @param array $files
 * @return array
 */
// function getfiles($path, $allowFiles, &$files = array())
// {
//     if (!is_dir($path)) return null;
//     if(substr($path, strlen($path) - 1) != '/') $path .= '/';
//     $handle = opendir($path);
//     while (false !== ($file = readdir($handle))) {
//         if ($file != '.' && $file != '..') {
//             $path2 = $path . $file;
//             if (is_dir($path2)) {
//                 getfiles($path2, $allowFiles, $files);
//             } else {
//                 if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
//                     $files[] = array(
//                         'url'=> substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
//                         'mtime'=> filemtime($path2)
//                     );
//                 }
//             }
//         }
//     }
//     return $files;
// }