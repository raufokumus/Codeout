<?php
    @$id=$_GET["id"];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 ml-3">Ders Açıklaması</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=dersler">Dersler</a></li>
              <li class="breadcrumb-item active">Ders açıklama</li>
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
                <h3 class="card-title">Açıklama </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="../yonlendir.php?sayfa=ders_aciklama&id=<?php echo $id;?>" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Açıklama</label>
                    <textarea name="metin" class="form-control" required  style="resize: none; " id="" cols="30" rows="10" placeholder="*Videoların alt kısmında yazacak dersin açıklamasını girin."></textarea>
                  </div>

                  <div class="form-check">
                    <input type="checkbox"  required class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Bilgileri onaylıyorum</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary col-2 ">Kaydet</button>
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