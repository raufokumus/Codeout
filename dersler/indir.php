<?php
    @$adres=$_GET["id"];
    @$file=$_GET["file"];
    header("Content-Disposition: attachment; filename=dosya.rar");
    readfile("$adres/dosya9313.rar");
?>