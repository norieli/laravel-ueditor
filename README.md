# laravel-ueditor
laravel api &amp; baidu ueditor  &amp; aliyun oss

填坑百度，终呈于此。

## Inspired By
- [thephpleague/flysystem-aws-s3-v2](https://github.com/thephpleague/flysystem-aws-s3-v2)
- [apollopy/flysystem-aliyun-oss](https://github.com/apollopy/flysystem-aliyun-oss) 
- [jacobcyl/ali-oss-storage](https://github.com/jacobcyl/Aliyun-oss-storage)
- [front-end-static-source](https://github.com/HaoChuan9421/vue-ueditor-wrap)

## Require
- Laravel 5+
- cURL extension
- php 7.0+

## Important
- No Baidu original front-end static source ！！！

## Installation Back-End
- step 1:

In order to install AliOSS-storage, just add

    "norieli/laravel-ueditor": "^1.0"

to your composer.json. Then run `composer install` or `composer update`.  
Or you can simply run below command to install:

    "composer require norieli/laravel-ueditor:^1.0"

- step 2:

copy :

    "yourproject/vendor/norieli/laravel-ueditor/src/config.php"

to 

    "yourproject/config/ueditor.php"

and change to your own config

- step 3:

add to routes
```php
// ueditor get
Route::get('/ueditor',function ()
{
    return (new \Norie\Laravel\UE\Controller())->do();
});
// ueditor get
Route::middleware(['auth:api'])->post('/ueditor',function ()
{
    return (new \Norie\Laravel\UE\Controller())->do();
});
```
- step 4 (if you need aliyun OSS):

1. In your `config/app.php` add this line to providers array:
```php
Jacobcyl\AliOSS\AliOssServiceProvider::class,
```
2. Add the following in app/filesystems.php:
```php
'disks'=>[
    ...
    'oss' => [
            'driver'        => 'oss',
            'access_id'     => '<Your Aliyun OSS AccessKeyId>',
            'access_key'    => '<Your Aliyun OSS AccessKeySecret>',
            'bucket'        => '<OSS bucket name>',
            'endpoint'      => '<the endpoint of OSS, E.g: oss-cn-hangzhou.aliyuncs.com | custom domain, E.g:img.abc.com>', // OSS 外网节点或自定义外部域名
            //'endpoint_internal' => '<internal endpoint [OSS内网节点] 如：oss-cn-shenzhen-internal.aliyuncs.com>', // v2.0.4 新增配置属性，如果为空，则默认使用 endpoint 配置(由于内网上传有点小问题未解决，请大家暂时不要使用内网节点上传，正在与阿里技术沟通中)
            'cdnDomain'     => '<CDN domain, cdn域名>', // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'ssl'           => <true|false> // true to use 'https://' and false to use 'http://'. default is false,
            'isCName'       => <true|false> // 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
            'debug'         => <true|false>
    ],
    ...
]
```
3. Then set the default driver in app/filesystems.php:
```php
'default' => 'oss',
```

Well! the Back-end is done!
## Installation Back-End
- step 1:

See [vue-ueditor](https://github.com/HaoChuan9421/vue-ueditor-wrap) to learn more.


If you not use vue,
you can download this static resouce. [download](https://github.com/HaoChuan9421/vue-ueditor-wrap/blob/master/assets/downloads/utf8-php.zip)


- step 2 (If you need auth. if not, remove auth midleware in routes):

Whatever you choose. You also change 4 fiels to add http request hearder.

1. static/UE/dialogs/image/image.js
2. static/UE/dialogs/image/image.js
3. static/UE/dialogs/video/video.js

 the same code area
```js
 uploader.on('uploadBeforeSend', function (file, data, header) {
        //这里可以通过data对象添加POST参数
        header['X_Requested_With'] = 'XMLHttpRequest';
        // like this
        header['Authorization'] = 'Bearer ' + localStorage.getItem('token');
    });

```

4. static/UE/ueditor.all.js
```js
var xhr = new XMLHttpRequest()
    xhr.open('post', action, true)
    // like this
    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
    if (me.options.headers && Object.prototype.toString.apply(me.options.headers) === "[object Object]") {
    for (var key in me.options.headers) {
      xhr.setRequestHeader(key, me.options.headers[key])
    }
}
```
5. static/UE/ueditor.config.js

```js
    // 服务器统一请求接口路径
    , serverUrl: URL + "/api/ueditor"
```

Well! The both done!

## Something
[Welcome to issue questions](https://github.com/norieli/laravel-ueditor/issues)

## Documentation
More development detail see [Aliyun OSS DOC](https://help.aliyun.com/document_detail/32099.html?spm=5176.doc31981.6.335.eqQ9dM)
## License
Source code is release under Apache license. Read LICENSE file for more information.