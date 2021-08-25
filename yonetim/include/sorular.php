<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sorular</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <?php $bilgi->sorular($kulad,$baglanti)?>
   
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  

  <?php

  @$secenek=$_GET["secenek"];
    switch($secenek):


            case "uyarı":
                echo' 
                

                    

                ';
                
                break;
                
    endswitch;

  ?>