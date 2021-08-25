 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Dersler</h1>
<p class="mb-4">Tüm derslere buradan ulaşabilirsiniz.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ders Listesi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ders Adı</th>
                        <th>Sahibi</th>
                        <th>Fiyat</th>
                        <th>Kategori</th>
                        <th>Kayıtlı kullanıcı</th>
                        <th>Ders açıklaması</th>
                        <th>Durum</th>
                        <th>Seçenekler</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ders Adı</th>
                        <th>Sahibi</th>
                        <th>Fiyat</th>
                        <th>Kategori</th>
                        <th>Kayıtlı kullanıcı</th>
                        <th>Ders açıklaması</th>
                        <th>Durum</th>
                        <th>Seçenekler</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php $bilgi->a_dersler($kulad,$baglanti) ?>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->