<?php
require 'vendor/autoload.php'; //使用composer安装的
//$ffmpeg = FFMpeg\FFMpeg::create(array(
//    'ffmpeg.binaries'  => '/usr/local/Cellar/ffmpeg/3.4.2/bin/ffmpeg',
//    'ffprobe.binaries' => '/usr/local/Cellar/ffmpeg/3.4.2/bin/ffprobe',
//    'timeout'          => 3600, // The timeout for the underlying process
//    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
//), $logger);
//$video = $ffmpeg->open('1.flv');
//$video
//    ->filters()
//    ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
//    ->synchronize();
//$video
//    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(1)) //一帧
//    ->save('frame.jpg');
//$video
////    ->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4'); //转码
//    ->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv');
//$video->save(new FFMpeg\Format\Audio\Mp3(), 'audio.mp3');
//
//$audio = $ffmpeg->open('audio.mp3');
//$waveform = $audio->waveform();
//$waveform->save('waveform.png'); //波浪图
//$video->filters()->rotate(FFMpeg\Filters\Video\RotateFilter::ROTATE_180);
//$video->save(new FFMpeg\Format\Video\X264(), 'rotate.mp4'); //旋转视频
//$audio = $ffmpeg->open('1.mp3');
//
//$format = new FFMpeg\Format\Audio\Flac(); //显示进度
////$format->on('progress', function ($audio, $format, $percentage) {
////    echo "$percentage % transcoded";
////});
//
//$format
//    ->setAudioChannels(2)
//    ->setAudioKiloBitrate(256);
//
////音频截取
//$audio->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds(30), \FFMpeg\Coordinate\TimeCode::fromSeconds(10));
////音频输出
//$audio->save($format, 'track.flac');

$ffprobe = FFMpeg\FFProbe::create(array(
    'ffmpeg.binaries'  => '/usr/local/Cellar/ffmpeg/3.4.2/bin/ffmpeg',
    'ffprobe.binaries' => '/usr/local/Cellar/ffmpeg/3.4.2/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
), $logger);
$duration = $ffprobe
    ->format('/Users/cctv/Downloads/1.mp4') // extracts streams informations
//    ->videos()                      // filters video streams
//    ->first()                       // returns the first video stream
    ->get('duration'); //提取属性,duration/filename(文件路径)/format_name(支持格式)/size(单位:字节)/bit_rate(码率/比特率bit per second)等
/**
 * 属性信息
 */
$arr = ['
["filename"]=> string(27) "/Users/cctv/Downloads/1.mp4" 
["nb_streams"]=> int(2) ["nb_programs"]=> int(0) 
["format_name"]=> string(23) "mov,mp4,m4a,3gp,3g2,mj2" 
["format_long_name"]=> string(15) "QuickTime / MOV" 
["start_time"]=> string(8) "0.000000" 
["duration"]=> string(10) "224.514000" 
["size"]=> string(8) "21572191" 
["bit_rate"]=> string(6) "768671" 
["probe_score"]=> int(100) 
["tags"]=> array(4) { ["major_brand"]=> string(4) "isom" ["minor_version"]=> string(3) "512" ["compatible_brands"]=> string(16) "isomiso2avc1mp41" ["encoder"]=> string(13) "Lavf57.83.100" }
'];




































