<?php

    include("../fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);
    @$ders=$_GET["id"];

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Out</title>
    <link href="../csss/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="icon.svg">

</head>
<body>

    <section id="menu">
        <div class="menu-sol">
            <a id="logo" href="../index.php">CodeOut</a>  
        </div>
    </section>


    <section id="anasayfa">
        <div id="dersler">
            <h5 class="baslik">Ders</h5>
            <hr>
            <main>
                <?php $bilgi->d_edit($kulad,$ders,$baglanti) ?>
            </main>
        </div>        
    </section>
</body>
</html>