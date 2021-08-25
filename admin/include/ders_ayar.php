<?php
    @$id=$_GET["id"];
    @$sahibi=$_GET["s"];
   
?>

<div class="container-fluid" id="accordion">

    <!-- Ders adı -->
    <h1 class="pl-5 h3 mb-4 text-gray-800">Ders id: <?php echo $id;?></h1>

    <!-- Eğitmen Hakkında -->
    <div class="card shadow mb-4 border-bottom-success">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard1" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-success">Eğitmen Bilgileri</h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Eğitmen Hakkında </h6>
                                </div>
                                <div class="card-body">
                                        
                                        <?php $bilgi->a_e_bilgi($sahibi,$baglanti) ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Dersleri</h6>
                                </div>
                                <div class="card-body">
                                    <div id="accordion">
                                        <?php $bilgi->a_d_b($sahibi,$baglanti) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!--Ders bilgileri -->
        <div class="card shadow mb-4 border-bottom-info">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard3" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-info">Ders Bilgileri</h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-info shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-info">Ders Hakkında</h6>
                                </div>
                                <div class="card-body">

                                    <?php $bilgi->a_d_bilgi($kulad,$id,$baglanti) ?>
                                    

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                             <!-- Basic Card Example -->
                             <div class="card mb-4 border-left-danger shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-danger">İşlemler</h6>
                                </div>
                                <div class="card-body">
                                    <a class="btn btn-success" href="../ders?id=<?php echo $id;?>" role="button">Dersi Gör</a>

                                    <!-- Yayından Kaldır modal -->
                                        <button type="button" class="btn btn-light btn-icon-split" data-toggle="modal" data-target="#staticykaldır">
                                            <span class="icon text-gray-600">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                            <span class="text">Yayından Kaldır</span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticykaldır" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Videoyu Yayından Kaldır</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                Raporlanan videoyu yayından kaldırmak üzeresin. Yayından kaldırılan videolar düzeltildiği taktirde yayına tekrar koyulabilir.
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                <button type="button" class="btn btn-light"><a class="btn btn-sm btn-warning" href="">Onayla</a></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                    <!-- Eğitmene Yaz modal -->
                                        <button type="button" class="btn btn-primary btn-icon-split mt-1" data-toggle="modal" data-target="#staticegitmen">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="text ">Eğitemene Yaz</span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticegitmen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Eğitmene Mesaj Atılacak</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>

                                              <form action="../yonlendir?sayfa=a_d_s_mesaj&g=<?php echo $sahibi;?>&id=<?php echo $id;?>" method="post">
                                                <div class="modal-body">
                                                  <textarea name="metin" style="resize: none; height: 120px" class="form-control" placeholder="Yazılan mesajı yalnızca dersi veren kişi görecektir..." id="floatingTextarea2" ></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                  <button type="submit" class="btn btn-success">Gönder</button>
                                                </div>
                                              </form>

                                            </div>
                                          </div>
                                        </div>

                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>