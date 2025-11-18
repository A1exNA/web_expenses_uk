<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <?php
    require_once '../../src/functions/css_functions.php';
    $variable_array = mergeCssFiles();
    $needWrite = $variable_array[0];
    $outputFile = $variable_array[1];
    $style_css = $variable_array[2];
    ?>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="font__main">
    <header>
        <div class="h1">УК Тверьжилфонд</div>
    </header>
    <main>
        <?php
        if ($needWrite) {
            file_put_contents($outputFile, $style_css);
            echo 'Файл обновлён';
        } else {
            echo 'Изменений нет, файл не перезаписан';
        }
        ?>
    </main>