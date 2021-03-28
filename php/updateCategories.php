<?php
    $jsonString = $_POST['jsonData'];
    $fileName = $_POST['fileName'];
    $fileToCreate = $_POST['fileToCreate'];
    $file = fopen('../json/'.$fileName, 'w') or die('unable to open file');
    fwrite($file, json_encode($jsonString));
    $file2 = fopen('../json/'.$fileToCreate.'.json', 'w') or die('unable to open file');
    fwrite($file2, '{"categories":[], "sub_categories":{} }');
    fclose($file);
    fclose($file2);
    echo $jsonString;
?>