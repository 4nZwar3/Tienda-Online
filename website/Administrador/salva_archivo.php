<?php
    $file_name=$_FILES['archivo']['name'];
    $file_tmp=$_FILES['archivo']['tmp_name'];
    $cadena=explode(".", $file_name);
    $len=count($cadena);
    $pos=$len-1;
    $ext=$cadena[$pos];
    $dir="archivos/";
    $file_enc=md5_file($file_tmp);
    $nuevoFile="$file_enc.$ext";

    echo "file_name:$file_name <br>";
    echo "file_name:$file_name <br>";
    echo "-------------------------------------<br>";
    echo "ext:$ext <br>";
    echo "nuevoNombre:$file_enc <br>";
    echo "-------------------------------------<br>";
    echo "nuevoFile:$nuevoFile <br>";

    if($file_name!=''){
        $destino=$dir.$nuevoFile;
        copy($file_tmp, $destino);
    }
?>