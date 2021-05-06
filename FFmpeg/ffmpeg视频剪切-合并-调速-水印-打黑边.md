### 参考
* https://fzheng.me/2016/01/08/ffmpeg/


### 1. 剪切: 从 0秒 剪到第 170秒. 建议用在大文件上 (需要视频时长)
* ffmpeg -i test.mp4 -ss 0 -c copy -to 170 test_剪切.mp4


### 2. 合并: 先把 MP4 转为 ts 才能做合并
* ffmpeg -i test.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts test1.ts

* ffmpeg -i test.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts test2.ts

* ffmpeg -i "concat:test1.ts|test2.ts|" -c copy test_合并.mp4


### 3. 播放速度: 处理速度太慢, 考虑用在小文件上
* ffmpeg -i test.mp4 -filter_complex "[0:v]setpts=0.9*PTS[v];[0:a]atempo=1.1[a]" -map "[v]" -map "[a]" test_速率.mp4


### 4. 水印: 处理速度太慢, 考虑用在小文件上
* ffmpeg -i test.mp4 -max_muxing_queue_size 1024 -vf "movie=baidu.png [watermark];[in][watermark] overlay=10:10[out]" test_水印.mp4


### 5. 黑边: 处理速度太慢, 考虑用在小文件上. (需要视频分辨率-宽高)
* ffmpeg -i test.mp4 -max_muxing_queue_size 1024 -vf pad=660:380:10:10:black -y test_黑边.mp4
