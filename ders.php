<?php
    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);
    @$id=$_GET["id"];
?>

<?php

@$sayfa=$_GET["sayfa"];
switch($sayfa):
        case "basla":
            $ders=$_GET["id"];
            $bilgi->d_al($kulad,$ders,$baglanti);
            echo '
                <div classs="container p-5">
                    <div class="row no-gutters fixed-bottom">
                        <div class="col-lg-5 col-md-12 ml-auto">
                            <div class="alert alert-gradient " role="alert">
                                <div class="toast" data-autohide="false" >
                                    <div class="toast-header">
                                        <strong class="mr-auto text-success">Bilgilendirme</strong>     
                                    </div>
                                    <div class="toast-body">
                                        Ders kaydınız tamamlanmıştır!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            break;

        case "kaydol":
                echo '
                    <div classs="container p-5">
                        <div class="row no-gutters fixed-bottom">
                            <div class="col-lg-5 col-md-12 ml-auto">
                                <div class="alert alert-gradient " role="alert">
                                    <div class="toast" data-autohide="false" >
                                        <div class="toast-header">
                                            <strong class="mr-auto text-danger">Uyarı</strong>     
                                        </div>
                                        <div class="toast-body">
                                            Bu videoyu görmek için derse kayıt olmalısın!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            break;
        case "basarili":
            $ders=$_GET["id"];
            $bilgi->d_al($kulad,$ders,$baglanti);
            echo '
                <div classs="container p-5">
                    <div class="row no-gutters fixed-bottom">
                        <div class="col-lg-5 col-md-12 ml-auto">
                            <div class="alert alert-gradient " role="alert">
                                <div class="toast" data-autohide="false" >
                                    <div class="toast-header">
                                        <strong class="mr-auto text-success">Bilgilendirme</strong>     
                                    </div>
                                    <div class="toast-body">
                                        Ders başarıyla satın alınmıştır!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            break;
        default:
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
    <link href="https://cdn.jsdelivr.ne0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
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
                  <?php $bilgi->kategoriler($baglanti) ?>
              <ul class="nav justify-content-end">
                  <li>
                      <form action="yonlendir?sayfa=aranan" method="post" class="arama">
                          <input type="search" name="bul" class="arama-input">
                          <i class="fa fa-search"></i>
                      </form>
                  </li>
                <li class="nav-item dropdown">
                    <div class="dropdown">
                        <button class="btn  dropdown" style="color:white;" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <span style="font-size:9px; color:black; " class="badge bg-danger "><?php $bilgi->o_bildirim($kulad,$baglanti) ?> </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu2" >
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
                            <li><a class="dropdown-item" href="sorular">Sorularım</a></li>
                            <li><a class="dropdown-item" href="kurslar">Kayıtlı Kurslar</a></li>
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
    
    <main class="bg-light">
      <div class="album py-5">
        
      <div class="container">
      <div class="row ">
        <div class="col-md-4">
            <?php $bilgi->d_s_bilgi($kulad,$id,$baglanti)?>
        </div>
        <div class="col-md-8">
            <?php
            
                $cevap=$bilgi->d_kontrol($kulad,$id,$baglanti);
                if($cevap==1){
                  $bilgi->d_s_dersler($kulad,$id,$baglanti);
                }
                else{
                  $bilgi->d_k_dersler($kulad,$id,$baglanti);
                }
                  
            ?>
        </div>
      </div>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>$(document).ready(function(){$('.toast').toast('show');});</script>
  </body>
</html>
