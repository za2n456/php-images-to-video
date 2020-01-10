<?php

    try
    {
        $config = new \PHPVideoToolkit\Config(array(
            'temp_directory'              => 'tmp',
            //'ffmpeg'                      => __DIR__.'\ffmpeg.exe',
            //'ffprobe'                     => __DIR__.'\ffprobe.exe',
            'ffmpeg'                      => '/bin/ffmpeg',
            'ffprobe'                     => '/bin/ffprobe',
            'php_exec_infinite_timelimit' => true,
            'cache_driver'                => 'InTempDirectory',
            'set_default_output_format'   => true,
        ), true);
    }
    catch(\PHPVideoToolkit\Exception $e)
    {
        echo '<h1>Config set errors</h1>';
        \PHPVideoToolkit\Trace::vars($e);
        exit;
    }
    
