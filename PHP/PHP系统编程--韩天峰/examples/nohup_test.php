<?php

$number = 0;

while (1) {
    sleep(1);

    echo $number++;

    file_put_contents('nohup_test_log.log', "{$number}\n", FILE_APPEND);
}
