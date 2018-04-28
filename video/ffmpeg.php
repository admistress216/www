<?php
/**
 * 1.命令
 */
$arr = ['
ffmpeg -i 1.mp4, //获取视频信息
ffmpeg -i "concat:1524797315.mp3|1524797327.mp3" -acodec copy output.mp3, //连接语音
-i 片头.wav -i 内容.WAV -i 片尾.wav -filter_complex \'[0:0] [1:0] [2:0] concat=n=3:v=0:a=1 [a]\' -map [a] 合成.wav
'];

/**
 * 2.知识点
 */
