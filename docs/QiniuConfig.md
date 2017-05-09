### Please Set **config/filesystems.php**
> disks
```php
'qiniu' => [
    'driver'     => 'qiniu',
    'domains'    => [
        'default' => 'http://*/', //你的七牛域名
        //'default' => 'http://**.bkt.clouddn.com/', //你的七牛域名
        'https'   => '*.*.so',                        //你的HTTPS域名
        'custom'  => '*.*.so',                        //你的自定义域名
    ],
    'access_key' => '**',  //AccessKey
    'secret_key' => '**',  //SecretKey
    'bucket'     => '**',  //Bucket名字
    'notify_url' => '',  //持久化处理回调地址
],
```