<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#212529;">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
      <img src="../icon.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CodeOut</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      
          <?php $bilgi->bilgial($kulad,$baglanti);?>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
            <li class="nav-item">
              <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Anasayfa</p>
              </a>
            </li>

            

          <li class="nav-item">
            <a href="index.php?sayfa=dersler" class="nav-link ">
              <i class="nav-icon fas fa-book nav-icon"></i>
              <p>Derslerim</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="index.php?sayfa=ders_ekle" class="nav-link">
              <i class="nav-icon fas fa-folder-plus nav-icon"></i>
              <p>Ders Ekle</p>
            </a>
          </li>

          <li class="nav-item">
              <a href="index?sayfa=sorular" class="nav-link">
              <i class="nav-icon fas fa-question"></i>
              <p>Sorular</p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>