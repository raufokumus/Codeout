<?php

    include("../../fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);

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
            <h5 class="baslik">Html</h5>
            <hr>
            <main>

            	<div class="icerik">
                    <br>
                    <h3>Ders-1</h3>
                    <h5><a href="D1/ders1">Derse Git</a></h5>
                </div>

                <div class="icerik">
                    <br>
                    <h3>Ders-2</h3>
                    <h5><a href="D1/ders2">Derse Git</a></h5>
                </div>
                
                
                
            </main>
        </div>        
    </section>
</body>
</html>

<?php

    @$sayfa=$_GET["sayfa"];
    switch($sayfa):
            case "exit":
                $bilgi->cikis($baglanti);
                echo "<script>alert('Çıkış Yapılıyor')</script>";
                break;

            case "basla":
                $ders=$_GET["id"];
                $bilgi->d_al($kulad,$ders,$baglanti);
                break;
            
            default:

                
    endswitch;

?>