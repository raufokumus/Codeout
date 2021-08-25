<?php

    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("ind");

    @$sayfa=$_GET["sayfa"];
    switch($sayfa){
        case "giris":
            $mail=htmlspecialchars($_POST["mail"]);
            if($mail!=null)
            {
                $sifre=htmlspecialchars($_POST["sifre"]);
                $bilgi->giriskontrol($mail,$sifre,$baglanti);
            }
            break;

        case "kayit":
            $kulad=htmlspecialchars($_POST["kulad"]);
            if($kulad!=null)
            {
                $mail=htmlspecialchars($_POST["mail"]);
                $sifre=htmlspecialchars($_POST["sifre"]);
                $bilgi->kayitkontrol($kulad,$mail,$sifre,$baglanti);
            }
        break;
    }
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8 ">
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
                <li>
                    <form action="yonlendir?sayfa=aranan" method="post"  class="arama">
                        <input type="search" name="bul"  class="arama-input">
                        <i class="fa fa-search"></i>
                    </form>
                </li>
                <li class="nav-item dropdown align-items-center" >
                    <div class="dropdown" >

                        <button class="btn dropdown-toggle"  style="color:white;" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            
                            <strong>Giriş Yap / Kaydol</strong>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" style="width:400px; transform: translate(-50%); "> 
                            
                            
                            <li>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Giriş</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Kaydol</button>
                                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Şifremi Unuttum</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        
                                        <form action ="?sayfa=giris" method="post" style=" margin:10px; padding:10px;" >

                                            <h1 class="h3 mb-3 fw-normal">Giriş</h1>

                                            <div class="form-floating">
                                                
                                                <input required type="email" name="mail" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                <label for="floatingInput"><i class="fas fa-envelope"></i> Email</label>
                                            </div>
                                            <div class="form-floating">
                                                <input required type="password" name="sifre" class="form-control" id="floatingPassword" placeholder="Password">
                                                <label for="floatingPassword"><i class="fas fa-key"></i> Şifre</label>
                                            </div>

                                            <div class="checkbox mb-3">
                                                <label>
                                                    <input type="checkbox" value="remember-me"> Beni Hatırla
                                                </label>
                                            </div>
                                            <button class="w-100 btn btn-lg btn-primary" type="submit">Giriş</button>
                                    
                                        </form>    

                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" id="giris">
                                        <form action="?sayfa=kayit" method="post" style=" margin:10px; padding:10px;">

                                            <h1 class="h3 mb-3 fw-normal">Kayıt</h1>

                                            <div class="form-floating">
                                                <input required  type="text" name="kulad" class="form-control" id="floatingInput" placeholder="name">
                                                <label for="floatingInput"><i class="fas fa-user"></i> Kullanıcı Adı</label>
                                            </div>
                                            <div class="form-floating">
                                                <input required type="email" name="mail" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                <label for="floatingInput"><i class="fas fa-envelope"></i> Email</label>
                                            </div>
                                            <div class="form-floating">
                                                <input required type="password" name="sifre" class="form-control" id="floatingPassword" placeholder="name@Password.com">
                                                <label for="floatingPassword"><i class="fas fa-key"></i> Şifre</label>
                                            </div>

                                            <div class="checkbox mb-3">
                                                <label>
                                                    <input type="checkbox" value="remember-me"> Beni Hatırla
                                                </label>
                                            </div>
                                            <button class="w-100 btn btn-lg btn-primary" type="submit">Kaydol</button>

                                        </form>  
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                                </div>    
                            </li>

                        </ul>
                    </div>
                </li>
                
                
            </ul>
            
        </div>
      </div>

    </header>

    <main>

      <section class=" container ">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel" >
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            
            </div>
            <div class="carousel-inner">
      
                <div class="carousel-item active" style="height:200px;">
                  <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#212529"/></svg>
                  <div class="container">
                    <div class="carousel-caption text-center">
                      <h1>Codeout'a</h1>
                      <h1> Hoşgeldiniz</h1>
                    </div>
                  </div>
                </div>

            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Önceki</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Sonraki</span>
            </button>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

          <?php $bilgi->dersler($baglanti);?>
            
            
          </div>
        </div>
      </div>

    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>$(document).ready(function(){$('.toast').toast('show');});</script>
  </body>
</html>
<?php
    @$sayfa=$_GET["sayfa"];
        switch($sayfa){
            
            case "girisyap":
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
                                          Dersi görebilmek için giriş yapın!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                ';
                break;
            case "hataligiris":
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
                                            Girilen mail/şifre hatalı!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                ';
                break;
            case "hatalikayit":
                echo '
                    <div classs="container p-5">
                        <div class="row no-gutters fixed-bottom">
                            <div class="col-lg-5 col-md-12 ml-auto">
                                <div class="alert alert-gradient " role="alert">
                                    <div class="toast" data-autohide="false">
                                        <div class="toast-header">
                                            <strong class="mr-auto text-danger">Uyarı</strong>
                                        </div>
                                        <div class="toast-body">
                                            Girilen bilgilere ait bir kullanıcı mevcut!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                ';
                break;
            case "basarilikayit":
                echo '
                    <div classs="container p-5">
                        <div class="row no-gutters fixed-bottom">
                            <div class="col-lg-5 col-md-12 ml-auto">
                                <div class="alert alert-gradient " role="alert">
                                    <div class="toast" data-autohide="false">
                                        <div class="toast-header">
                                            <strong class="mr-auto text-success">Başarılı</strong>
                                        </div>
                                        <div class="toast-body">
                                            Kayıt Başarılı!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                ';
                break;
        }

?>
