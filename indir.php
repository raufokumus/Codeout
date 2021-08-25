<?php
    @$adres=$_GET["id"];
    @$file=$_GET["file"];
    header("content-type: application/vnd.rar");
    header("Content-Disposition: attachment; filename=dosya.rar");
    readfile("$file.rar");
?>