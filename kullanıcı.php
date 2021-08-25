<?php
    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);

    @$sayfa=$_GET["sayfa"];
    switch ($sayfa):
            case "cikis":
                $bilgi->cikis($baglanti);
                echo "<script>alert('Çıkış Yapılıyor')</script>";
            break;
            case "name":
                $k_adi=htmlspecialchars($_POST["k_adi"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_adi_degis($k_adi,$kulad,$baglanti);
            break;
            case "sifre":
                $kulad=$bilgi->kuladial($baglanti);
                $sifre=htmlspecialchars($_POST["k_sifre"]);
                $sifrekontrol=htmlspecialchars($_POST["k_sifre_2"]);
                if($sifrekontrol==$sifre)
                {
                    $bilgi->k_sifre_degis($kulad,$sifre,$baglanti);
                }
                else
                {
                    echo '
                    <div class="toast" data-autohide="false">
                        <div class="toast-header">
                            <strong class="mr-auto text-danger">Başarılı</strong>
                        </div>
                        <div class="toast-body">
                            Girilen şifrelen farkı!
                        </div>
                    </div>
                ';
                }
                
            break;
            case "yetki":
                $kulad=$bilgi->kuladial($baglanti);
                $seviye=htmlspecialchars($_POST["seviye"]);
                $bilgi->k_seviye_degis($kulad,$seviye,$baglanti);
            break;
            case "yonetim":
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->yetki_kontrol($kulad,$baglanti);
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

    <main>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class=" align-items-start">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profil</button>
                              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Ayarlar</button>
                              <button class="nav-link" id="nav-odeme-tab" data-bs-toggle="tab" data-bs-target="#nav-odeme" type="button" role="tab" aria-controls="nav-odeme" aria-selected="false">Ödemeler</button>
                              
                                <?php    
                                    $bilgi->user_yetki($kulad,$baglanti)
                                ?>
                                
                            </div>
                            
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <?php 
                                    $bilgi->user_info($kulad,$baglanti)
                                ?>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <?php 
                                    $bilgi->user_set($kulad,$baglanti)
                                ?>
                            </div>
                            <div class="tab-pane fade" id="nav-odeme" role="tabpanel" aria-labelledby="nav-odeme-tab">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">Sıra</th>
                                        <th scope="col">Ders Adı</th>
                                        <th scope="col">Fiyatı</th>
                                        <th scope="col">Satın alma tarihi</th>
                                        <th scope="col">Ders</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $bilgi->user_odeme($kulad,$baglanti)
                                        ?>
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
  $('.toast').toast('show');
});
</script>
  </body>
</html>