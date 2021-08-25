<?php
    @$id=$_GET["id"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tanıtım Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Derslerim</a></li>
              <li class="breadcrumb-item active">Tanıtım ekle</li>
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
                <h3 class="card-title">Tanıtım Videosu Ekle</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=t_ekle&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>