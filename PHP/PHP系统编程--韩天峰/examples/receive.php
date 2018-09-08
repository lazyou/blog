<?php 
//file receive.php 
$ip = msg_get_queue(12340); 

msg_receive($ip,0,$msgtype,4,$data,false,null,$err); 
echo "msgtype {$msgtype} data {$data}\n"; 

msg_receive($ip,0,$msgtype,4,$data,false,null,$err); 
echo "msgtype {$msgtype} data {$data}\n";
