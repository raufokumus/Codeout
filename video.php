<?php
    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);
    @$ders=$_GET["id"];
    @$video=$_GET["video"];
    $izlenen=$bilgi->k_d_takip($kulad,$ders,$baglanti);

    
    @$durum=$_GET["1"];
    switch($durum):
            case "1":
                $bilgi->d_gör($kulad,$ders,$video,$baglanti);
                header("video?id=$ders&video=$video&1=1");
                break;
    endswitch;
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rauf Okumuş">
    <title>Code Out</title>
    <link rel="shortcut icon" href="icon.svg">
    
    <link href="csss/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <meta name="theme-color" content="#7952b3">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  </head>
  <body>
<header>
      
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="g-index" class="navbar-brand d-flex align-items-center">
                <strong style="font-size:25px;">Codeout</strong>
            </a>
                   
            <ul class="nav justify-content-end">
              
                <li class="nav-item dropdown">
                    <div class="dropdown">
                        <button class="btn  dropdown" style="color:white;" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <span style="font-size:9px; color:black; " class="badge bg-danger "><?php $bilgi->o_bildirim($kulad,$baglanti) ?> </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            
                            <?php $bilgi->bildirim($kulad,$baglanti) ?>

                        </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown align-items-center">
                    <div class="dropdown">

                        <button class="btn dropdown-toggle"  style="color:white;" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-user"></i>
                            <?php echo $kulad; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu2">
                            <?php $bilgi->y_panel($kulad,$baglanti) ?>

                            <li><a class="dropdown-item" href="kurslar">Kayıtlı Kurslar</a></li>
                            <li><a class="dropdown-item" href="sorular">Sorularım</a></li>
                            <li><a class="dropdown-item" href="kullanıcı">Ayarlar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item"  style="color:red;" href="yonlendir?sayfa=exit">Çıkış</a></li>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
      </div>
    </header>
   
    <main>
        <section class="py-5 mt-0  container-fluid d-flex">
            
            <div class="container col-md-9">
                <?php $bilgi->d_video($kulad,$ders,$video,$baglanti) ?>
                <?php $bilgi->d_bilgi($kulad,$ders,$video,$baglanti)?>
            </div>
            <div class="container col-md-3">
                    <div class="progress float-center mb-2" style="width:96%; height:22px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark p-1" role="progressbar" aria-valuenow="<php echo $izlenen; >" aria-valuemin="0" aria-valuemax="100" style=" width: <?php echo $izlenen; ?>%">Tamamlanan: %<?php echo $izlenen; ?></div>
                    </div>

                <?php $bilgi->d_liste($kulad,$ders,$baglanti) ?>
            </div>
        </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

    $("input[name='rating']").click(function () {

        var star = $('.bi');
        var select = $(this).val();

        star.slice(0,5).removeClass("bi-star-fill");
        star.slice(0,5).addClass("bi-star");

        star.slice(0, select).removeClass("bi-star");
        star.slice(0, select).addClass("bi-star-fill");

    });

</script>
</body>
</html>

<?php

    @$sayfa=$_GET["sayfa"];
    switch($sayfa):
            case "exit":
                $bilgi->cikis($baglanti);
                echo "<script>alert('Çıkış Yapılıyor')</script>";
                break;

            default:
    endswitch;
    
?>