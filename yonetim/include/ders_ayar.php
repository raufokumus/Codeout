<?php
    @$id=$_GET["id"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 ml-3">Ders Ayarları</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Dersler</a></li>
              <li class="breadcrumb-item active">Ders ayar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-6 float-left">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header ">
                <h3 class="card-title ">Ders Ayarları</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=ders_ayar&id=<?php echo $id;?>" method="post">
                <div class="card-body p-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Ders Adı</label>
                    <input type="text" required class="form-control" name="d_adi" id="exampleInputEmail1" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ders Ücreti</label>
                    <input type="number" class="form-control" name="d_fiyat" id="exampleInputPassword1" >
                  </div>

                  <div class="card-body">
                    <div class="row">
                     
                      <div class="col-md-6 col-5 float-left">
                        <div class="form-group">
                          <label>Dersin Kategorisi</label>
                          <select class="form-control select2bs4" name="kategori" style="width: 100%;">
                            <?php $bilgi->altkategori($baglanti); ?>
                          </select>
                          
                        </div>
                        <!-- /.form-group -->
                        
                    </div>
                      <!-- /.col -->
                        <div class="form-check col-6 pt-4 text-center ">
                            <input type="checkbox"  required class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Bilgileri onaylıyorum</label>
                        </div>
                        
                      </div>
                      <!-- /.col -->
                      
                      
                    </div>
                    
                    <!-- /.row -->
                  </div>
                  
                
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary col-2">Değiştir</button>
                </div>
              </form>
            </div>
            <!-- /.card -->



        

        
        
      </div><!-- /.container-fluid -->

      <div class="col-md-6 float-right">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Video Ekle</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=v_ekle&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="exampleInputPassword1">Video başlığı</label>
                    <input type="text" class="form-control" name="v_baslik" id="exampleInputPassword1" placeholder="Başlık Girin">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Video seç</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="video" required id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile"></label>
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox"  required class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Bilgileri onaylıyorum</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button type="submit" name="SubmiteFile" class="btn btn-primary col-2">Ekle</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            

            

            

      </div>
          <!--/.col (left) -->
          <!-- right column -->
          
            <!-- /.card -->
          </div>
       
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>