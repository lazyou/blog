<?php
$pid = pcntl_fork(); // 一旦调用成功，事情就变得有些不同了
echo $pid . PHP_EOL;
sleep(100);
if ($pid == -1) {
    die('fork failed');
} else if ($pid == 0) {
} else {
}
