<?php
    @$ders=$_GET["id"];
    @$video=$_GET["video"];
    @$rapor=$_GET["r"];
?>

<div class="container-fluid" id="accordion">

    <!-- Ders adı -->
    <h1 class="pl-5 h3 mb-4 text-gray-800">Ders: <?php echo $ders;?></h1>

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
                                        
                                        <?php $bilgi->a_r_e_bilgi($kulad,$ders,$baglanti) ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Dersleri Hakkında | <?php $bilgi->a_r_b_ders($kulad,$ders,$baglanti); ?> dersi mevcut</h6>
                                </div>
                                <div class="card-body">
                                    <div id="accordion">
                                        <?php $bilgi->a_r_d_b($kulad,$ders,$baglanti) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Video| Ders bilgileri -->
        <div class="card shadow mb-4 border-bottom-info">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard3" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-info">Ders | Video Bilgileri</h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-info shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-info">Ders Hakkında | <?php $bilgi->a_r_sayısı($kulad,$ders,$baglanti) ?> rapor mevcut</h6>
                                </div>
                                <div class="card-body">

                                    <?php $bilgi->a_r_d_bilgi($kulad,$ders,$baglanti) ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-info shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-info">Video Hakkında | <?php $bilgi->a_r_v_sayısı($kulad,$ders,$video,$baglanti) ?> rapor mevcut</h6>
                                </div>
                                <div class="card-body">

                                    <?php $bilgi->a_r_v_bilgi($kulad,$ders,$video,$baglanti) ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Rapor Bilgi | İşlemleri -->
    <div class="card shadow mb-4 border-bottom-danger">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard4" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-danger">Rapor Bilgileri | İşlemler</h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-danger shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-danger">Rapor Hakkında</h6>
                                </div>
                                <div class="card-body">

                                    <?php $bilgi->a_r_bilgi($kulad,$rapor,$baglanti)?>

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
                                    
                                    <!-- Video Uygun modal -->
                                        <button type="button" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#staticuygun">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Ders Uygun</span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticuygun" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Video Uygun</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                Raporlanan videonun bir sorunu olmadığını düşünüyorsanız onaylayın. Onaylanan raporları tekrar görüntüleyemezsiniz.
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                <button type="button" class="btn btn-success"><a class="btn btn-sm btn-success" href="../yonlendir?sayfa=d_uygun&r=<?php echo $rapor; ?>">Onayla</a></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    <!-- Uyarı modal -->
                                        <button type="button" class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#staticuyarı">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Uyarı Ekle</span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticuyarı" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Videoya Uyarı Ekle</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                Raporlanan derse uyarı eklemek üzeresin. Eklenen uyarılar geri kaldırılmamaktadır.
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                <button type="button" class="btn btn-warning"><a class="btn btn-sm btn-warning" href="../yonlendir?sayfa=d_uyarı&r=<?php echo $rapor; ?>&d=<?php echo $ders; ?>&v=<?php echo $video; ?>">Onayla</a></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

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
                                                <button type="button" class="btn btn-light"><a class="btn btn-sm btn-warning" href="../yonlendir?sayfa=d_v_y_kaldır&r=<?php echo $rapor; ?>&d=<?php echo $ders; ?>&v=<?php echo $video; ?>">Onayla</a></button>
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

                                              <form action="../yonlendir?sayfa=r_e_mesaj&r=<?php echo $rapor; ?>&d=<?php echo $ders; ?>" method="post">
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

                                    <!-- Kullanıcıya Yaz modal -->
                                        <button type="button" class="btn btn-secondary btn-icon-split mt-1" data-toggle="modal" data-target="#staticraporter">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="text ">Kullanıcıya Yaz</span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticraporter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Rapolayan kullanıcıya mesaj gönderilecek</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>

                                              <form action="../yonlendir?sayfa=r_r_mesaj&r=<?php echo $rapor; ?>" method="post">
                                                  <div class="modal-body">
                                                    <textarea name="metin" style="resize: none; height: 120px" class="form-control" placeholder="Yazılan mesajı yalnızca raporu gönderen kişi görecektir..." id="floatingTextarea2" ></textarea>
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
</div>