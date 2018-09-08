<?php

//file send.php 
$ip = msg_get_queue(12340); 

msg_send($ip,8,"abcd",false,false,$err);
