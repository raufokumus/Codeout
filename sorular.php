<?php
    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);
    @$gonderen=$_GET["g"];

    @$sayfa=$_GET["sayfa"];
    switch($sayfa):
            case "s_sil":
                $bilgi->o_s_sil($kulad,$gonderen,$baglanti);
              
                header("sorular");
            break;
            case "s_oku":
                $bilgi->o_s_oku($kulad,$gonderen,$baglanti);
              
                header("sorular");
            break;
            case "s_sor":
                $soru=htmlspecialchars($_POST["soru"]);
                if($soru!=null){
                    $bilgi->o_s_sor($kulad,$gonderen,$soru,$baglanti);
                }
                header("sorular");
            break;
    endswitch;
?>


<!DOCTYPE html>
<html lang="en">
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
    <style type="text/css">
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

        .chat-messages {
            display: flex;
            flex-direction: column;
            height: 700px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }
        .py-3 {
            padding-top: 1rem!important;
            padding-bottom: 1rem!important;
        }
        .px-4 {
            padding-right: 1.5rem!important;
            padding-left: 1.5rem!important;
        }
        .flex-grow-0 {
            flex-grow: 0!important;
        }
        .border-top {
            border-top: 1px solid #dee2e6!important;
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
                    <div class="dropdown dropdown-menu-end">

                        <button class="btn dropdown-toggle"  style="color:white;" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-user"></i>
                            <?php echo $kulad; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
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

<main class="content">

    <div class="container p-0">
		    <div class="card mt-3">
			      <div class="row g-0">
				        <div class="col-12 col-lg-5 col-xl-3 border-right position-relative">
                    <h1 class="h3 text-center mt-3">Soru - Cevap</h1>

                    <?php $bilgi->sorulanlar($kulad,$baglanti) ?>

					          <hr class="d-block d-lg-none mt-1 mb-0">
				        </div>
				        <div class="col-12 col-lg-7 col-xl-9">
                    <div class="py-2 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1">
                            <div class="position-relative">
                            </div>
                            <div class="flex-grow-1 p-3">
                                <strong><?php echo $bilgi->tamad($gonderen,$baglanti);?></strong>
                            </div>
                            <div>

                                <button type="button" class="btn btn-light btn-icon-split" data-toggle="modal" data-target="#staticoku">
                                    <span class="icon text-gray-600">
                                        <i class="far fa-envelope-open"></i>
                                    </span>
                                    <span class="text">Okundu</span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="staticoku"data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Okundu işaretle</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Bu sohbet okundu işaretlenecek.
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                        <button type="button" class="btn btn-light"><a class="btn btn-sm btn-light" href="?g=<?php echo $gonderen;?>&sayfa=s_oku">Onayla</a></button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <button type="button" class="btn btn-danger btn-icon-split" data-toggle="modal" data-target="#staticsil">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Sil</span>
                                </button>

                                <!-- Modal -->
                              <div class="modal fade" id="staticsil"data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Sohbeti sil</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                              Bu sohbeti sildiğinizde soru ve cevapları tekrar göremezsiniz.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                <button type="button" class="btn btn-danger"><a class="btn btn-sm btn-danger" href="?g=<?php echo $gonderen;?>&sayfa=s_sil">Onayla</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="chat-messages p-4">
                    
                            <?php $bilgi->soru_bak($kulad,$gonderen,$baglanti) ?>

                        
				        </div>
			      </div>
		    </div>
	  </div>
</main>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script type="text/javascript">
	
    $(document).ready(function() {
    $("#MyModal").modal();
  });
</script>
</body>
</html>

