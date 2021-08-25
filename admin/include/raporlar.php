 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Raporlar</h1>
<p class="mb-4">Kullanıcı raporlarına buradan ulaşabilirsiniz.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Rapor Listesi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ders</th>
                        <th>Video</th>
                        <th>Raporcu Adı</th>
                        <th>Rapor Nedeni</th>
                        <th>Rapor Tarihi</th>
                        <th>Seçenekler</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ders</th>
                        <th>Video</th>
                        <th>Raporcu Adı</th>
                        <th>Rapor Nedeni</th>
                        <th>Rapor Tarihi</th>
                        <th>Seçenekler</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php $bilgi->a_raporlar($kulad,$baglanti) ?>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->