<?php
    @$id=$_GET["id"];
   
?>

<div class="container-fluid" id="accordion">

    <!-- Ders adı -->
    <h1 class="pl-5 h3 mb-4 text-gray-800">Kullanıcı id: <?php echo $id;?></h1>

    <!-- Eğitmen Hakkında -->
        <div class="card shadow mb-4 border-bottom-success">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard1" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-success">Kullanıcı Hakkında</h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Kullanıcı Bilgileri</h6>
                                </div>
                                <div class="card-body">
                                        
                                        <?php $bilgi->a_r_k_bilgi($kulad,$id,$baglanti) ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Verdiği dersler</h6>
                                </div>
                                <div class="card-body">
                                    <div id="accordion">

                                        <?php $bilgi->a_r_v_d_b($kulad,$id,$baglanti) ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Basic Card Example -->
                            <div class="card mb-4 border-left-success shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Kayıtlı dersler</h6>
                                </div>
                                <div class="card-body">
                                    <div id="accordion">

                                        <?php $bilgi->a_r_k_d_b($kulad,$id,$baglanti) ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- İşlemler -->
        <div class="card shadow mb-4 border-bottom-danger">
            <!-- Card Header - Açıklama -->
            <a href="#collapseCard2" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-danger">Kullanıcı İşlemleri<?php $bilgi->a_k_b_durum($kulad,$id,$baglanti) ?></h6>
            </a>
            <!-- Card Content - İçerik -->
            <div class="collapse" id="collapseCard2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">

                        

                            <!-- yetkili modal -->
                                <button type="button" class="btn btn-success  btn-icon-split" data-toggle="modal" data-target="#yver">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-chevron-up"></i>
                                        </span>
                                        <span class="text">Yetkili Yap</span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="yver" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Yetkili yap</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            
                                            <form action="../yonlendir?sayfa=a_k_yetkili&g=<?php echo $id;?>" method="post">
                                                <div class="modal-body">
                                                    Kullanıcıya Admin Yetkisi verilecek.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                    <button type="submit" class="btn btn-success">Onayla</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <!-- Egitmen modal -->
                                <button type="button" class="btn btn-secondary  btn-icon-split" data-toggle="modal" data-target="#yal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                        <span class="text">Eğitmen Yap</span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="yal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Eğitmen yap</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            
                                            <form action="../yonlendir?sayfa=a_k_yetkial&g=<?php echo $id;?>" method="post">
                                                <div class="modal-body">
                                                    Site admininden adminlik yetkisi alınıp sadece Eğitmen yetkisi verilecek.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                    <button type="submit" class="btn btn-secondary">Onayla</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            
                            <!-- Mesaj Gönder modal -->
                                <button type="button" class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#mesajat">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-inbox"></i>
                                        </span>
                                        <span class="text">Mesaj Gönder</span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="mesajat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Mesaj Gönder</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="../yonlendir?sayfa=a_k_mesaj&g=<?php echo $id;?>" method="post">
                                                <div class="modal-body">
                                                    <textarea style="resize: none;" name="metin" class="form-control" placeholder="Yazılan mesajı yalnızca gönderilen kişi görecektir..." id="floatingTextarea2" ></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                    <button type="submit" class="btn btn-info">Onayla</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <!-- Banla modal -->
                                <button type="button" class="btn btn-danger  btn-icon-split" data-toggle="modal" data-target="#banla">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                        <span class="text">Banla</span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="banla" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Kişiyi Banla</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            
                                            <form action="../yonlendir?sayfa=a_k_banla&g=<?php echo $id;?>" method="post">
                                                <div class="modal-body">
                                                    Banlanan kullanıcıya ait TÜM bilgiler SİLİNECEK. BU İŞLEMİ YAPMADAN ÖNCE BİRKEZ DAHA DÜŞÜNÜN.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                                    <button type="submit" class="btn btn-danger">Onayla</button>
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