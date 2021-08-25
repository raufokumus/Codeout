 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Kullanıcılar</h1>
<p class="mb-4">Tüm kullanıcıların bilgilerine buradan ulaşabilirsiniz.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Üye Listesi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Mail</th>
                        <th>Seviye</th>
                        <th>Seçenekler</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Mail</th>
                        <th>Seviye</th>
                        <th>Seçenekler</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php $bilgi->a_kullanıcılar($baglanti) ?>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->