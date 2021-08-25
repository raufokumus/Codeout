<?php
    @$id=$_GET["id"];
    @$video=$_GET["video"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 ml-3">Kaynak Ekleme</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Dersler</a></li>
              <li class="breadcrumb-item active">Kaynak</li>
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
            

        
        
      </div><!-- /.container-fluid -->

      <div class="col-md-6 ">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Video Ekle</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=k_ekle&id=<?php echo $id;?>&video=<?php echo $video;?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="exampleInputFile">Kaynak seç</label>
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