<?php

    include("../../fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Out</title>
    <link href="../../csss/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="icon.svg">

</head>
<body>

    <section id="menu">
        <div class="menu-sol">
            <a id="logo" href="../../index">CodeOut</a>  
        </div>
    </section>

    <section id="anasayfa">
        <div id="dersler">
            <h5 class="baslik">Dersler</h5>
            <hr>
            <main>
                <div class="icerik">
                        
                </div>         
            </main>
        </div>        
    </section>
</body>
</html>