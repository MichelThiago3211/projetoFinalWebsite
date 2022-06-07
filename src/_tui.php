<?php
    // identifica se o arquivo foi enviado
    if(isset($_FILES['arquivo'])){
        // exibir nome do arquivo
        echo $_FILES['arquivo']['name'];
        // exibir dados do arquivo
        $fileContent = file_get_contents($_FILES['arquivo']['tmp_name']);
        echo $fileContent;

        switch ($_FILES['arquivo']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }
    }
    else {
        echo "No file found";
    }
?>