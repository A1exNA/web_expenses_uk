<?php

/* ----- CSS соединение файла ----- */
function mergeCssFiles()
{
    $files = [
        '../../src/css/general.css',
        '../../src/css/fonts.css',
        '../../src/css/database.css',
        '../../src/css/header.css',
        '../../src/css/main.css',
        '../../src/css/footer.css'
    ];

    $style_css = '';
    foreach ($files as $file) {
        $style_css .= file_get_contents($file);
    }

    $outputFile = '../css/style.css';
    $needWrite = true;
    if (file_exists($outputFile)) {
        $existingContent = file_get_contents($outputFile);
        if ($existingContent === $style_css) {
            $needWrite = false;
        }
    }

    return [$needWrite, $outputFile, $style_css];
}

?>