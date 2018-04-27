<?php
/**
 * 1.命令
 */
$arr = ['
ffmpeg -i 1.mp4, //获取视频信息
ffmpeg -i "concat:1524797315.mp3|1524797327.mp3" -acodec copy output.mp3, //连接语音
'];

/**
 * 2.知识点
 */
