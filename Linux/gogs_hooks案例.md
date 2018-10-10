## gogs 后台 hooks 地址设置 (settings/hooks)
* https://api.xxx.com/hooks.php?token=e1bf4462321e409cee4ac0b6e849876c

## gogs 自动更新脚本
```php
<?php
/**
 * gogs git 钩子
 *
 */
$projectName = 'oa-v2.xxx.com';

// 服务器上项目目录
$projectPath = "/usrdata/www/{$projectName}/";

$logFile = "/usrdata/logs/{$projectName}/hooks.log";

// 自定义 token 用于验证
$accessToken = 'e1bf4462321e409cee4ac0b6e849876c';

// 允许 hook 推送的 ips
$accessIp = [
    '192.168.0.1',
    '192.168.0.2',
];

// 获取请求端的 IP 和 token
$clientToken = $_GET['token'];

$clientIp = $_SERVER['REMOTE_ADDR'];

// 获取执行 hook 脚本执行的用户
$who = exec('whoami');

// 打开网站目录下的 hooks.log 文件 需要在服务器上创建 并给写权限
$fs = fopen($logFile, 'a');

fwrite($fs, '================ Hook Start ===============' . PHP_EOL);

fwrite($fs, "user: {$who}" . PHP_EOL);

fwrite($fs, 'Request on [' . date("Y-m-d H:i:s") . "] from [{$clientIp}]" . PHP_EOL);

// 验证 Token
if ($clientToken !== $accessToken) {
    echo "error 403";
    fwrite($fs, "非法 token [{$clientToken}]" . PHP_EOL . PHP_EOL);
    fclose($fs);
    exit(0);
}
// 验证 IP
elseif (! in_array($clientIp, $accessIp)) {
    echo "error 503";
    fwrite($fs, "非法 ip [{$clientIp}]" . PHP_EOL . PHP_EOL);
    fclose($fs);
    exit(0);
}
// 执行 git 命令
else {
    // hook 请求端发送来的信息: https://gogs.io/docs/features/webhook.html
    /*
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    fwrite($fs, 'Data: '.print_r($data, true).PHP_EOL);
    fwrite($fs, 'Data: '.$json);
    */

    // 执行 shell 命令并把返回信息写进日志
    $output = shell_exec("cd $projectPath && /usr/local/git/bin/git pull 2>&1 && /usr/bin/npm run build");
    fwrite($fs, 'Info: '. $output);
    fwrite($fs, '================ Update End ==============='. PHP_EOL . PHP_EOL);
}

$fs and fclose($fs);
```
