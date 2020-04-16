<?php
namespace Norie\Laravel\UE;
/**
 * 上传附件和上传视频
 */

/* 上传配置 */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
        $config = array(
            "pathFormat" => config('ueditor.imagePathFormat'),
            "maxSize" => config('ueditor.imageMaxSize'),
            "allowFiles" => config('ueditor.imageAllowFiles')
        );
        $fieldName = config('ueditor.imageFieldName');
        break;
    case 'uploadscrawl':
        $config = array(
            "pathFormat" => config('ueditor.scrawlPathFormat'),
            "maxSize" => config('ueditor.scrawlMaxSize'),
            "allowFiles" => config('ueditor.scrawlAllowFiles'),
            "oriName" => "scrawl.png"
        );
        $fieldName = config('ueditor.scrawlFieldName');
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $config = array(
            "pathFormat" => config('ueditor.videoPathFormat'),
            "maxSize" => config('ueditor.videoMaxSize'),
            "allowFiles" => config('ueditor.videoAllowFiles')
        );
        $fieldName = config('ueditor.videoFieldName');
        break;
    case 'uploadfile':
    default:
        $config = array(
            "pathFormat" => config('ueditor.filePathFormat'),
            "maxSize" => config('ueditor.fileMaxSize'),
            "allowFiles" => config('ueditor.fileAllowFiles')
        );
        $fieldName = config('ueditor.fileFieldName');
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
return json_encode($up->getFileInfo());
