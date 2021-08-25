<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dersler</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Derslerim</a></li>
              <li class="breadcrumb-item active">Tüm dersler</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php $bilgi->k_i_dersler($kulad,$baglanti) ?>
        <?php $bilgi->k_v_dersler($kulad,$baglanti) ?>
       
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
