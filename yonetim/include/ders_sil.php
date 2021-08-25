<?php
    @$id=$_GET["id"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 ml-3">Ders Kaldır</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Dersler</a></li>
              <li class="breadcrumb-item active">Ders kaldır</li>
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
              <form action="../yonlendir.php?sayfa=ders_sil&id=<?php echo $id;?>" method="post">
                <div class="card-body p-3">
                 

                  <div class="card-body">
                    <div class="row">
                     
                      <div class="col-md-6 col-5 float-left">
                        
                        <div class="form-group">
                          <label for="exampleInputEmail1">Ders Adı</label>
                            <input type="text" required class="form-control" name="d_adi" id="exampleInputEmail1" >
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
                  <button type="submit" class="btn btn-primary col-2 swalDefaultSuccess">Dersi Kaldır</button>
                </div>
              </form>
            
            <!-- /.card -->



        

        
        
      </div><!-- /.container-fluid -->

      
          <!--/.col (left) -->
          <!-- right column -->
          
            <!-- /.card -->
          </div>
       
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>