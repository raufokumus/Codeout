<?php
    @$id=$_GET["id"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 ml-3">Ders Duyurusu</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Dersler</a></li>
              <li class="breadcrumb-item active">Ders duyuru</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      
      <div class="col-md-11 ml-5 pl-5">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Duyuru </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=ders_duyuru&id=<?php echo $id;?>" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Başlık</label>
                    <input type="text" class="form-control" required id="exampleInputEmail1" name="baslik" placeholder="Yeni video / Hatırlatma/ Videoda değişiklik">
                    <textarea name="metin" class="form-control" required  style="resize: none; " id="" cols="30" rows="10" placeholder="*Duyuru girin'"></textarea>
                  </div>

                  <div class="form-check">
                    <input type="checkbox"  required class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Bilgileri onaylıyorum</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary col-2 ">Ekle</button>
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