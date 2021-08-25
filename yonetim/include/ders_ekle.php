<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ders Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Derslerim</a></li>
              <li class="breadcrumb-item active">Ders ekle</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ders Ayarları</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=ders_ekle" method="post">
                <div class="card-body p-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Ders Adı</label>
                    <input type="text" required class="form-control" name="d_adi" id="exampleInputEmail1" placeholder="Ders Adı Girin">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Ders Ücreti</label>
                      
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">₺</span>
                        </div>
                        <input type="number" class="form-control" name="d_fiyat" id="exampleInputPassword1" >
                        <div class="input-group-append">
                          <span class="input-group-text">.00</span>
                        </div>
                      </div>
                    
                  </div>

                  <div class="card-body">
                    <div class="row">
                     
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Dersin Kategorisi</label>
                          <select class="form-control select2bs4" name="kategori" style="width: 100%;">
                            <?php $bilgi->altkategori($baglanti); ?>
                          </select>
                        </div>
                        <!-- /.form-group -->
                      </div>
                      <!-- /.col -->
                    
                        
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Oluştur</button>
                </div>
              </form>
            </div>
            <!-- /.card -->           
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>