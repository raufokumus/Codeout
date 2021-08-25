<?php
    try {

        $baglanti=new PDO("mysql:host=localhost;dbname=codeout;charset=utf8","root","");
        $baglanti->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        }catch(PDOException $e){
        die($e->getMessage());
    }

    class codeout{

        function __construct(){
            try {
    
                $baglanti=new PDO("mysql:host=localhost;dbname=codeout;charset=utf8","root","");
                $baglanti->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                
            }catch(PDOException $e){
                    die($e->getMessage());
                }
        }

        function g_i_dersler($kulad,$baglanti) {
            
            $dersler = $baglanti->prepare("select * from dersler where tip='0'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):
                
                echo '
                        <div class="icerik" onclick="location.href='.$sunucum["ders_adi"].'">
                        <br>
                        <h3>'.$sunucum["ders_adi"].'</h3>
                        <p> Ders Veren : '.$sunucum["sahibi"].'</p>
                        ';
                        if($sunucum["fiyat"]!='0'):
                            
                            echo '<p id="fiyat">Fiyat: '.$sunucum["fiyat"].'</p> ';
                        else:
                            $cevap=self::d_kontrol($kulad,$sunucum["id"],$baglanti);
                            if($cevap!=0):
                            echo '<br>
                                <h5><a href="dersler/'.$sunucum["id"].'/">Derse Git</a></h5>
                                </div>
                            ';
                            else:{
                                echo '<br>
                                <h5> <a href="dersler/'.$sunucum["id"].'?sayfa=basla&id='.$sunucum["id"].'&git='.$sunucum["ders_adi"].'">Kursa Git</a> </h5>
                                </div>
                            ';
                            }
                            endif;
                            
                        endif;

            endwhile;
            
        }

        function sira($ders,$vt){
            $sorgu = $vt->prepare("select id from dersler where ders_adi='$ders'");
            $sorgu->execute();
            $sonuc=$sorgu->fetch(PDO::FETCH_ASSOC);
            $id=$sonuc["id"];

            $dersler = $vt->prepare("select video_adi from ders$id where sira = '1'");
            $dersler->execute();
            if($dersler->rowCount()!=0){
                $video=$dersler->fetch(PDO::FETCH_ASSOC);
                $v_adi=$video["video_adi"];
                return $v_adi;
            }
        }

        function g_v_dersler($kulad,$vt) {
            
            $dersler = $vt->prepare("select * from dersler where tip=1");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):

                $v_adi=self::sira($sunucum["ders_adi"],$vt);
                $id=$sunucum["id"];
                echo '
                    <div class="col">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="white" dy=".3em">'.$sunucum["ders_adi"].'</text></svg>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                ';
                                
                                        $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);

                                    if($cevap!=0):
                                    echo '
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <h5><a class="btn btn-m btn-outline-primary " href="ders?id='.$sunucum["id"].'">Derse Git</a></h5>   
                                            </div>
                                            <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                            <small ><div class="align-items-center">
                                            <span >
                                            ';

                                                $puan=self::ders_puanı_ort($id,$vt);
                                          
                                                $a=0;
                                                if($puan!=0)
                                                {
                                                    while($a!=5)
                                                    {
                                                        if($a<$puan)
                                                        {
                                                            echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
    
                                                        }
                                                        else{
                                                            echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                        }
                                                        $a++;
                                                    }
                                                    echo' ('.$puan.')';
                                                }
    
                                            echo'
                                        </div>
                                        </small>
                                        </div>
                                    ';
                                    else:{
                                        echo '
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <h5> <a class="btn btn-m btn-outline-success" href="ders?id='.$sunucum["id"].'">Kursa Git</a> </h5>
                                            </div>
                                            <small class="text-muted">Ders veren : '.$sunucum["sahibi"].'</small>
                                            <small class="text-muted">Kayıtlı '.$sunucum["kayıtlı"].' Kullanıcı</small>
                                        </div>
                                    ';
                                    }
                                    endif;
                                echo '
                            </div>
                        </div>
                    </div>
                ';
            endwhile;
        }

        function d_kontrol($kulad,$ders,$baglanti){
            $dersler = $baglanti->prepare("select ders from alınan where alan='$kulad' and ders='$ders'");
            $dersler->execute();
            if($dersler->rowCount()==0){
                return 0;
            }
            else{return 1;}
        }

        function d_al($kulad,$ders,$vt){

            $cevap=self::d_kontrol($kulad,$ders,$vt);
            if($cevap==0){
                $dersler = $vt->prepare("insert into alınan (id,alan,ders) values (NULL,'$kulad','$ders')");
                $dersler->execute();
                $çek = $vt->prepare("select * from dersler where id='$ders'");
                $çek->execute();
                $sunucum=$çek->fetch(PDO::FETCH_ASSOC);
                $d_adı=$sunucum["ders_adi"];
                $sahibi=$sunucum["sahibi"];
                $deger= $sunucum["kayıtlı"];
                $yeni= $deger +1;
                $artır = $vt->prepare("update dersler set kayıtlı='$yeni' WHERE id='$ders'");
                $artır->execute();
                $bildir=$vt->prepare("insert into h_bildirim (id,alıcı,gonderen,ders,mesaj,okundu) values (NULL,'$sahibi','$kulad','$d_adı','$d_adı dersine kayıt oldu','0')");
                $bildir->execute();
                header("Location:ders?id=$ders&sayfa=basla");  

            } 
        }

        function dersler($vt) {
            
            $dersler = $vt->prepare("select * from dersler where tip='1'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):
                $id=$sunucum["id"];
                $v_adi=self::sira($sunucum["ders_adi"],$vt);

                echo '
                    <div class="col">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="true"><title>Ders Adı</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="white" dy=".3em">'.$sunucum["ders_adi"].'</text></svg>
                        <div class="card shadow-sm">
                            <div class="card-body">';
                                    echo '
                                        <div class="align-items-center">
                                            ';
                                            
                                            if($sunucum["fiyat"]!=0){
                                                echo'    
                                                    <p class="Fiyat">Fiyat: '.$sunucum["fiyat"].'</p>

                                                ';
                                            }
                                        echo'
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">';
                                                $id=$sunucum["id"];
                                                $sorgu2=$vt->prepare("select * from ders$id where aciklama='Tanıtım'");
                                                $sorgu2->execute();
                                                if($sorgu2->RowCount()!=0)
                                                {
                                                    echo '<h5> <a class="btn btn-sm btn-outline-primary" style="font-size:12px;" href="tanıtım?id='.$sunucum["id"].'">Tanıtım izle</a> </h5>';
                                                }
                                                
                                                echo '
                                                <h5> <a class="btn btn-sm btn-outline-success" style="font-size:12px;" href="index?sayfa=girisyap">Kursu gör</a> </h5>

                                            </div>
                                            <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                            <small >';
                                            $puan=self::ders_puanı_ort($id,$vt);
                                          
                                            $a=0;
                                            if($puan!=0)
                                            {
                                                while($a!=5)
                                                {
                                                    if($a<$puan)
                                                    {
                                                        echo '<small for="star1" class="bi bi-star-fill me-1"></small>';

                                                    }
                                                    else{
                                                        echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                    }
                                                    $a++;
                                                }
                                                echo' ('.$puan.')';
                                            }

                                            echo '</small>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                ';
            endwhile;
            
        }

        function sifrele($veri){
            return base64_encode(gzdeflate(gzcompress(serialize($veri))));
        }

        function coz($veri){
            return unserialize(gzuncompress(gzinflate(base64_decode($veri))));
        }

        function giriskontrol($mail,$sifre,$vt) {

            $sifrelihal=md5(sha1(md5($sifre)));

            $sor=$vt->prepare("select * from uye where mail='$mail' and sifre='$sifrelihal' and durum='0'");
            $sor->execute();
            $gelendeger=$sor->fetch();

            if($sor->rowCount()==0):
                header("refresh:0,url=index?sayfa=hataligiris");
            else:
                
                header("refresh:0,url=g-index");

                //cookie

                $id=self::sifrele($gelendeger["id"]);
                setcookie("kulbilgi",$id,time()+60*60*12);
                
            endif;

        }

        function kayitkontrol($kulad,$mail,$sifre,$vt){
            $s_gizle=md5(sha1(md5($sifre)));

            $sor=$vt->prepare("select * from uye where mail='$mail'");
            $sor->execute();

            if($sor->rowCount()!=0):
                
                header("refresh:0,url=index?sayfa=hatalikayit");
            else:

                //cookie
                $ekle=$vt->prepare("insert into uye (id,tamad,kulad,mail,sifre,seviye) values (NULL,'$kulad','$kulad','$mail','$s_gizle','Öğrenci')");
                $ekle->execute();
                header("refresh:0,url=index?sayfa=basarilikayit");
            endif;

        }

        function kuladial($baglanti){

            $cookid=$_COOKIE["kulbilgi"];

            $cozduk=self::coz($cookid);

            $al=$baglanti->prepare("select * from uye where id=$cozduk");
            $al->execute();
            $sorgusonuc=$al->fetch();

            return $sorgusonuc["kulad"];

        }

        function cikis($vt){
            
            $cookid=$_COOKIE["kulbilgi"];
            
            setcookie("kulbilgi",$cookid,time()-5);
            header("Location=index");

        }

        function kontrolet($sayfa){

            if(isset($_COOKIE["kulbilgi"])):
            
                if($sayfa=="ind"): header("Location:g-index"); endif;
                
            else:
                
                if($sayfa=="cot"): header("Location:index"); endif;

            endif;
        }

        function k_a_degis($k_adi,$kulad,$vt){
            $guncelle=$vt->prepare("update uye set tamad='$kulad' WHERE kulad='$k_adi'");
            $guncelle->execute();
        }

        function k_m_degis($kulad,$metin,$vt){
            $sor=$vt->prepare("select * from uye where mail='$metin'");
            $sor->execute();
            if($sor->rowCount()==0){
                $guncelle=$vt->prepare("update uye set mail='$metin' WHERE kulad='$kulad'");
                $guncelle->execute();
            }
        }

        function k_g_degis($kulad,$metin,$vt){
            $sor=$vt->prepare("select * from uye where github='$metin'");
            $sor->execute();
            if($sor->rowCount()==0){
                $guncelle=$vt->prepare("update uye set github='$metin' WHERE kulad='$kulad'");
                $guncelle->execute();
            }
        }

        function k_l_degis($kulad,$metin,$vt){
            $sor=$vt->prepare("select * from uye where linkedin='$metin'");
            $sor->execute();
            if($sor->rowCount()==0){
                $guncelle=$vt->prepare("update uye set linkedin='$metin' WHERE kulad='$kulad'");
                $guncelle->execute();
            }
        }

        function k_h_degis($kulad,$metin,$vt){
            $guncelle=$vt->prepare("update uye set hakkında='$metin' WHERE kulad='$kulad'");
            $guncelle->execute();
        }

        function k_s_degis($kulad,$sifre,$vt){
            $s_gizle=md5(sha1(md5($sifre)));
                
            $ekle=$vt->prepare("update uye set sifre='$s_gizle' WHERE kulad='$kulad'");
            $ekle->execute();
        }

        function k_y_degis($kulad,$vt){
            $ekle=$vt->prepare("update uye set seviye='Eğitmen' WHERE kulad='$kulad'");
            $ekle->execute();
        }

        function y_kontrol($kulad,$sayfa,$vt){

            $sor=$vt->prepare("select seviye from uye where kulad='$kulad'");
            $sor->execute();
            $sonuc=$sor->fetch();
            
            if($sonuc["seviye"]=="Yönetici"):
                if($sayfa=="pon"): header("Location:index"); endif;
                echo $sonuc["seviye"];
                
            elseif($sonuc["seviye"]=="Öğretmen"):

                if($sayfa=="yon"): header("Location:index"); endif;

            else:
                header("Location:../index");
            endif;
        }

        function kisiler($vt){

            $kisiler = $vt->prepare("select * from uye");
            $kisiler->execute();

            while($sunucum=$kisiler->fetch(PDO::FETCH_ASSOC)):
                echo '
                        <option value="'.$sunucum["kulad"].'">
                ';
            endwhile;
        }

        function seviye_degis($kulad,$seviye,$vt){
 
            //cookie
            $ekle=$vt->prepare("update uye set seviye='$seviye' WHERE kulad='$kulad'");
            $ekle->execute();
            header("refresh:0,url=yonetim-p");

        }

        function k_i_dersler($kulad,$baglanti) {
            
            $dersler = $baglanti->prepare("select * from dersler where tip='0' and sahibi='$kulad'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):
                $deger=$sunucum["kategori"];
                $id=$baglanti->prepare("select altkategori from altkategori where id='$deger' ");
                $id->execute();
                $ders_id=$id->fetch(PDO::FETCH_ASSOC);
                echo '

                        <div class="col-5 float-left">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                
                                </div>
                                <div class="card-body pt-0">
                                <div class="row">
                                
                                    <div class="col-8">
                                    <h5 class="lead"><b>'.$sunucum["ders_adi"].'</b></h5>
                                    <p class="text-muted text-sm"><b>Kategori: '.$ders_id["altkategori"].'</p>
                                    <h3 class="lead"><b>Dersi Alan: '.$sunucum["kayıtlı"].' kişi var</b></h3>
                                    </div>
                                    
                                </div>
                                </div>
                                <div class="card-footer">
                                <div class="text-right">
                                    
                                    <a href="index?sayfa=ders_aciklama&id='.$sunucum["id"].'" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-info"></i>
                                        Açıklama Ekle
                                    </a>
                                    
                                    <a href="index?sayfa=ders_duyuru&id='.$sunucum["id"].'" class="btn btn-sm btn-warning">
                                        <i class="fas fa-bullhorn"></i>
                                        Duyuru yayınla
                                    </a>
                                    
                                    <a href="index?sayfa=ders_sil&id='.$sunucum["id"].'" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Dersi Kaldır
                                    </a>

                                    <a href="index?sayfa=ders_ayar&id='.$sunucum["id"].'" class="btn btn-sm bg-teal">
                                        <i class="fas fa-cog"></i>
                                        Ders Ayarları
                                    </a>

                                    <a href="../dersler/'.$sunucum["id"].'/" class="btn btn-sm btn-primary">
                                    </i>Dersi Gör
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>

                ';
            endwhile;
        }

        function k_v_dersler($kulad,$baglanti) {
            
            $dersler = $baglanti->prepare("select * from dersler where tip='1' and sahibi='$kulad'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):

                $deger=$sunucum["kategori"];
                $id=$baglanti->prepare("select altkategori from altkategori where id='$deger' ");
                $id->execute();
                $ders_id=$id->fetch(PDO::FETCH_ASSOC);
                echo '
                <div class="col-5 float-left">
                <div class="card ">
                    <div class="card-header text-muted border-bottom-0">
                    
                    </div>
                    <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                        <h2 class="lead"><b>'.$sunucum["ders_adi"].'</b></h2>
                        <p class="text-muted text-sm"><b>Kategori: '.$ders_id["altkategori"].'</p>
                        <h3 class="lead"><b>Dersi Alan: '.$sunucum["kayıtlı"].' kişi var</b></h3>
                        
                        </div>
                        
                    </div>
                    </div>
                    <div class="card-footer">
                    <div class="text-right">
                    
                        

                        <a href="index?sayfa=ders_aciklama&id='.$sunucum["id"].'" class="btn btn-sm btn-outline-dark">
                            <i class="fas fa-info"></i>
                            Açıklama Ekle
                        </a>

                        <a href="index?sayfa=ders_duyuru&id='.$sunucum["id"].'" class="btn btn-sm btn-warning">
                            <i class="fas fa-bullhorn"></i>
                            Duyuru yayınla
                        </a>

                        <a href="index?sayfa=ders_sil&id='.$sunucum["id"].'" class="btn btn-sm btn-danger swalDefaultSuccess">
                            <i class="fas fa-trash"></i>
                            Dersi Kaldır
                        </a>

                        <a href="index?sayfa=ders_ayar&id='.$sunucum["id"].'" class="btn btn-sm bg-teal">
                            <i class="fas fa-cog"></i>
                            Ders Ayarları
                        </a>

                        <a href="index?sayfa=ders_edit&id='.$sunucum["id"].'" class="btn btn-sm btn-primary">
                        
                        Dersi Gör
                        </a>
                    </div>
                    </div>
                </div>
            </div>

                ';
            endwhile;
            
        }

        function k_v_ekle($kulad,$baglanti) {
            
            $dersler = $baglanti->prepare("select * from dersler where tip='1' and sahibi='$kulad'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):
                echo '
                        <div class="icerik" onclick="location.href='.$sunucum["ders_adi"].'">
                        <br> 
                        <h3>'.$sunucum["ders_adi"].'</h3>
                        <h3 >'.$sunucum["sahibi"].'</h3>
                        <h5 ><a href="../dersler/'.$sunucum["ders_adi"].'/">Dersi Gör</a></h5>
                        </div>
                ';
                
            endwhile;
            
        }

        function d_ekle($kulad,$d_adi,$d_fiyat,$kategori,$VT){

            $sor=$VT->prepare("select * from dersler where ders_adi='$d_adi'");
            $sor->execute();
            $sor2=$VT->prepare("select id from altkategori where altkategori='$kategori'");
            $sor2->execute();

            $sunucum=$sor2->fetch(PDO::FETCH_ASSOC);
            $id=$sunucum["id"];

            if($sor->rowCount()!=0):
                
                echo "<alert>*Bu ders adını kullanamazsın!</alert>";
                

            else:
                if($d_adi!=NULL):
                {
                    $ekle = $VT->prepare("insert into dersler (id,ders_adi,tip,sahibi,fiyat,kategori,kayıtlı) values (NULL,'$d_adi','1','$kulad','$d_fiyat','$id','0')");
                    $ekle->execute();
                    $bak = $VT->prepare("select id from dersler where ders_adi='$d_adi' and sahibi='$kulad'");
                    $bak->execute();
                    $sonuc=$bak->fetch(PDO::FETCH_ASSOC);
                    $ders=$sonuc["id"];

                    $ekle2 = $VT->prepare("
                    CREATE TABLE `ders$ders` (
                        `id` INT(250) NOT NULL AUTO_INCREMENT,
                        `video_adi` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
                        `aciklama` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
                        `sira` INT(255) NOT NULL,
                        `kaynak` VARCHAR(255) NULL DEFAULT '' COLLATE 'utf8_general_ci',
                        `durum` INT(2) NOT NULL DEFAULT '1',
                        PRIMARY KEY (`id`, `sira`) USING BTREE
                    )
                    COLLATE='utf8_general_ci'
                    ENGINE=InnoDB
                    ;
                    
                    ");
                    $ekle2->execute();
                }
                endif;
                
            endif;
        }

        function yazdir_index($d_adi,$vt){
            
            $oku = fopen('yonetim/main', 'r');
            $yaz = fopen('dersler/'.$d_adi.'/index', 'w');
            $icerik = fread($oku, filesize('yonetim/main'));
            fwrite($yaz, $icerik);
            echo $oku;

            fclose($oku);
            fclose($yaz);
        }

        function bildirim($kulad,$vt){

            $kontrol=$vt->prepare("select * from bildirim where alıcı='$kulad' and okundu='0'");
            $kontrol->execute();
            $kontrol1=$vt->prepare("select * from bildirim where alıcı='$kulad' order BY zaman desc");
            $kontrol1->execute(); 
            $sayac=0;
            if($kontrol1->rowCount()!=0){
                while($sunucum=$kontrol1->fetch(PDO::FETCH_ASSOC)):
                    if($sayac!=0)
                    {
                        echo '<hr class="dropdown-divider">';
                    }
                echo '
                        
                        <li class="dropdown-item dropdown-menu-right">

                          <div class="media">

                            <div class="media-body">
                                <h5 class="dropdown-item-title">
                                ';
                                    echo $sunucum["ders"].
                                ' - 
                                <p class="text-m">
                                ';
                                    echo $sunucum["baslik"].
                                '
                                </p>
                                </h5>
                                
                                <p class="text-sm">'.$sunucum["mesaj"].'</p>
                                <p style="font-size:12px;" class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$sunucum["zaman"].'</p>
                                ';
                                    if($sunucum["okundu"]==0)
                                    {
                                        echo '
                                        <a href="yonlendir?sayfa=bildirim&mesaj='.$sunucum["id"].'"><span style="font-size:15px; color:red;" class="float-left text-m text-muted"><i class="fas fa-check">okundu</i></span></a>
                                        ';
                                    }

                                echo '
                                
                                <a href="yonlendir?sayfa=bildirim_sil&mesaj='.$sunucum["id"].'"><span style="font-size:15px;" class="float-right text-m text-muted"><i class="fas fa-ban"> sil</i></span></a>
                            </div>
                          </div>
                          
                        </li>
                    ';
                    $sayac++;
                endwhile;
            } 
        }

        function o_bildirim($kulad,$vt){
            $kontrol=$vt->prepare("select * from bildirim where alıcı='$kulad' and okundu='0'");
            $kontrol->execute();

            $sayi=$kontrol->rowCount();
            echo $sayi;
        }

        function b_okundu($id,$vt){
            $kontrol=$vt->prepare("select * from bildirim where id='$id'");
            $kontrol->execute();

            $sunucum=$kontrol->fetch(PDO::FETCH_ASSOC);
                
            $deger= $sunucum["okundu"];

            echo $deger;

            if($deger==0){
                $oku=$vt->prepare("update bildirim set okundu='1' where id='$id'");
                $oku->execute();
            }
            else{
                $oku=$vt->prepare("update bildirim set okundu='0' where id='$id'");
                $oku->execute();
            }
            
        }

        function b_sil($id,$vt){
            $kontrol=$vt->prepare("delete from bildirim where id='$id'");
            $kontrol->execute();

        }

        function kategori($vt){
            $sırala= $vt->prepare("select distinct kategori from altkategori");
            $sırala->execute();
            
            while($sunucum=$sırala->fetch(PDO::FETCH_ASSOC)):
                echo '
                    <option>'.$sunucum["kategori"].'</option>
                ';
                
            endwhile;
        }

        function altkategori($vt){
            $sırala= $vt->prepare("select * from altkategori ");
            $sırala->execute();
            
            while($sunucum=$sırala->fetch(PDO::FETCH_ASSOC)):
                echo '
                    <option>'.$sunucum["altkategori"].'</option>
                ';
                
            endwhile;
        }

        function d_ayar($kulad,$id,$d_adi,$d_fiyat,$kategori,$vt){
            $eski=$vt->prepare("select * from dersler where id='$id'");
            $eski->execute();
            $eski_ad=$eski->fetch(PDO::FETCH_ASSOC);
            $degis = $vt->prepare("update dersler set ders_adi='$d_adi',fiyat='$d_fiyat',kategori='$kategori' where sahibi='$kulad' and id='$id'");
            $degis->execute();
            $sor2=$vt->prepare("select id from altkategori where altkategori='$kategori'");
            $sor2->execute();

            $sunucum=$sor2->fetch(PDO::FETCH_ASSOC);
            $d_id=$sunucum["id"];

            if($d_adi!=null && $d_fiyat!= null && $kategori!=null){
                $degis = $vt->prepare("update dersler set ders_adi='$d_adi',fiyat='$d_fiyat',kategori='$d_id' where sahibi='$kulad' and id='$id'");
                $degis->execute();
                rename('dersler/'.$eski_ad,'dersler/'.$d_adi);
            }
            elseif($d_adi!=null && $d_fiyat!= null ){
                $degis = $vt->prepare("update dersler set ders_adi='$d_adi',fiyat='$d_fiyat' where sahibi='$kulad' and id='$id'");
                $degis->execute();
                rename('dersler/'.$eski_ad,'dersler/'.$d_adi);
            }
            elseif($d_adi!=null && $kategori!=null){
                $degis = $vt->prepare("update dersler set ders_adi='$d_adi',kategori='$d_id' where sahibi='$kulad' and id='$id'");
                $degis->execute();
                rename('dersler/'.$eski_ad,'dersler/'.$d_adi);
            }
            elseif($d_fiyat!= null && $kategori!=null){
                $degis = $vt->prepare("update dersler set fiyat='$d_fiyat',kategori='$d_id' where sahibi='$kulad' and id='$id'");
                $degis->execute();
            }
            elseif( $d_fiyat!= null ){
                $degis = $vt->prepare("update dersler set fiyat='$d_fiyat' where sahibi='$kulad' and id='$id'");
                $degis->execute();
            }
            elseif($d_adi!=null ){
                $degis = $vt->prepare("update dersler set ders_adi='$d_adi' where sahibi='$kulad' and id='$id'");
                $degis->execute();
                rename('dersler/'.$eski_ad.'','dersler/'.$d_adi.'');
            }
            elseif( $kategori!=null){
                $degis = $vt->prepare("update dersler set kategori='$d_id' where sahibi='$kulad' and id='$id'");
                $degis->execute();
            }
        }

        function h_bildirim($kulad,$vt){
            
            $kontrol=$vt->prepare("select * from h_bildirim where alıcı='$kulad' order BY zaman desc");
            $kontrol->execute();  

            
            if($kontrol->rowCount()!=0):{

                while($sunucum=$kontrol->fetch(PDO::FETCH_ASSOC)):
                    $kisi=$sunucum["gonderen"];
                    $kul=$vt->prepare("select resim from uye where kulad= '$kisi'");
                    $kul->execute();
                    $kullanıcı=$kul->fetch(PDO::FETCH_ASSOC);
                    echo '
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      
                      <div class="media">
                        <img src="';
                        if($kullanıcı["resim"]!=NULL):{
                            echo $kullanıcı["resim"];
                        }
                        else:{
                            echo "dist/img/avatar5.png";
                        }
                        endif;
                        
                        
                        echo '" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                          <h3 class="dropdown-item-title">
                            ';
                                echo $sunucum["gonderen"].
                            '
                            
                            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                          </h3>
                          <p class="text-sm">'.$sunucum["mesaj"].'</p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$sunucum["zaman"].'</p>
                        </div>
                      </div>
                      
                    </a>
                    <div class="dropdown-divider"></div>
                    ';
                    
                endwhile;
 
                
            }
            endif;
                
        }

        function bilgial($kulad,$vt){
            $kul=$vt->prepare("select * from uye where kulad= '$kulad'");
            $kul->execute();
            $kullanıcı=$kul->fetch(PDO::FETCH_ASSOC);

            echo '
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                      <img src="';

                        if($kullanıcı["resim"]!=NULL):{
                            echo "../".$kullanıcı["resim"];
                        }
                        else:{
                            echo "dist/img/avatar5.png";
                        }
                        endif;
                    
                      echo '" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                      <a href="../kullanıcı" class="d-block">'.$kullanıcı["kulad"].' ('.$kullanıcı["seviye"].')</a>
                    </div>
                </div>
            ';

        }

        function toplam_izleyici($kulad,$vt){
            $izlenen= $vt->prepare("select SUM(kayıtlı) FROM dersler WHERE sahibi='$kulad'");
            $izlenen->execute();
            $kullanıcı=$izlenen->fetch(PDO::FETCH_ASSOC);
            return $kullanıcı["SUM(kayıtlı)"];
        }

        function toplam_ders($kulad,$vt){
            $izlenen= $vt->prepare("select Count(ders_adi) FROM dersler WHERE sahibi='$kulad'");
            $izlenen->execute();
            $kullanıcı=$izlenen->fetch(PDO::FETCH_ASSOC);
            return $kullanıcı["Count(ders_adi)"];

        }

        function toplam_gelir($kulad,$vt){
            $sorgu= $vt->prepare("select * FROM dersler WHERE sahibi='$kulad' AND fiyat!='0'");
            $sorgu->execute();
            
            $tut=0;
            $deger=0;
            if($sorgu->rowCount()!=0){
                while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)){
                    $id=$sunucum["id"];
                    $sorgu2= $vt->prepare("select * FROM odeme WHERE ders='$id'");
                    $sorgu2->execute();
                    while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                        $deger=$sunucum2["fiyat"]+$deger;
                    }
                }
                return $deger;
            }
            else{
                return $deger;
            }
            
        }

        function izlenen_ders($kulad,$vt){
            $izlenen= $vt->prepare("select Count(ders) FROM alınan WHERE alan='$kulad'");
            $izlenen->execute();
            $kullanıcı=$izlenen->fetch(PDO::FETCH_ASSOC);
            return $kullanıcı["Count(ders)"];

        }

        function d_duyuru($kulad,$id,$baslik,$mesaj,$vt){
            $izlenen= $vt->prepare("select * FROM alınan WHERE ders='$id'");
            $izlenen->execute();
            $ders= $vt->prepare("select * FROM dersler WHERE id='$id'");
            $ders->execute();
            $ders_adi=$ders->fetch(PDO::FETCH_ASSOC);
            if($izlenen->rowCount()!=0):{
                $ders=$ders_adi["ders_adi"];
                while($sunucum=$izlenen->fetch(PDO::FETCH_ASSOC)):
                    $alan=$sunucum["alan"];
                    $ekle = $vt->prepare("insert into bildirim (id,ders,gönderen,alıcı,baslik,mesaj,okundu) values (NULL,'$ders','$kulad','$alan','$baslik','$mesaj','0')");
                    $ekle->execute();
                endwhile;
            }
            endif;
        }

        function d_aciklama($kulad,$id,$mesaj,$vt){
            $ders= $vt->prepare("select * FROM dersler WHERE id='$id'");
            $ders->execute();
            $ders_adi=$ders->fetch(PDO::FETCH_ASSOC);
            $ders=$ders_adi["ders_adi"];
            $ekle = $vt->prepare("update dersler set aciklama='$mesaj' where ders_adi='$ders'");
            $ekle->execute();
        }

        function y_panel($kulad,$vt){
            $sorgu=$vt->prepare("select seviye from uye where kulad='$kulad'");
            $sorgu->execute();
            $seviye=$sorgu->fetch(PDO::FETCH_ASSOC);
            
            if($seviye["seviye"]=="Eğitmen" ):{
                echo '
                        <li><a class="dropdown-item" href="yonetim/index">Eğitmen Paneli</a></li>
                        <li><hr class="dropdown-divider"></li>
                    ';
            }
            elseif($seviye["seviye"]=="Yonetici"):{
                echo '<li><a class="dropdown-item" href="admin/index">Yönetici Paneli</a></li>';
                echo '
                        <li><a class="dropdown-item" href="yonetim/index">Eğitmen Paneli</a></li>
                        <li><hr class="dropdown-divider"></li>
                ';
            }
            endif;
        }

        function ders_sil($kulad,$ders,$kontrol,$vt){
            $çek = $vt->prepare("select ders_adi from dersler where id='$ders'");
            $çek->execute();
            $sorgucek=$çek->fetch(PDO::FETCH_ASSOC);
            $ders_adi=$sorgucek["ders_adi"];
            if($ders_adi==$kontrol){
                $çalıştır=self::d_duyuru($kulad,$ders,"Kaldırılan Ders","$ders_adi yayından kaldırılmıştır.",$vt);
                $sorgu=$vt->prepare("delete from dersler where ders_adi='$ders_adi' and sahibi='$kulad'");
                $sorgu->execute();
                $sorgu2=$vt->prepare("delete from alınan where ders='$ders'");
                $sorgu2->execute();
                $sorgu3=$vt->prepare("DROP TABLE $ders_adi;");
                $sorgu3->execute();
            }         
        }

        function ders_puanı_ort($id,$vt){
            $sorgu = $vt->prepare("select AVG(puan) FROM yorumlar where ders='$id'");
            $sorgu->execute();
            $sonucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            $ort= $sonucum["AVG(puan)"];
            return $ort;
        }

        function d_bilgi($kulad,$id,$video,$vt){
            $çek = $vt->prepare("select * from dersler where id='$id'");
            $çek->execute();
            while($sorgucek=$çek->fetch(PDO::FETCH_ASSOC)):
                $ders_adi=$sorgucek["ders_adi"];
                $aciklama=$sorgucek["aciklama"];
                $sahibi=$sorgucek["sahibi"];

                $sorgu=$vt->prepare("select * from uye where kulad='$sahibi'");
                $sorgu->execute();
                while($sonuc=$sorgu->fetch(PDO::FETCH_ASSOC)):
                    $hakkında=$sonuc["hakkında"];
                    $linkedin=$sonuc["linkedin"];
                    $github=$sonuc["github"];
                endwhile;
                $izlenen=self::k_d_takip($kulad,$id,$vt);
                echo '
                <div class="shadow p-3 mb-5 bg-white rounded-bottom">
                
                        <nav>
                                
                            <div class="nav nav-tabs container-fluid" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Ders Hakkında</button>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Eğitmen</button>
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Eğitmene Sor</button>
                                <button class="nav-link" style="color:red;" id="nav-rapor-tab" data-bs-toggle="tab" data-bs-target="#nav-rapor" type="button" role="tab" aria-controls="nav-rapor" aria-selected="false"><i class="fas fa-exclamation-triangle"></i> Raporla</button>
                                
                                    
                                
                            </div>
                            
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header text-center"><h5 class="card-title">'.$ders_adi.'</h5></div>
                                                <div class="card-body text-dark">
                                                    <p class="card-text">'.$aciklama.'</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header text-center"><h5 class="card-title"> Ders puanı: '; echo self::ders_puanı_ort($id,$vt);
                                                
                                                echo '</h5>
                                                </div>
                                                <div class="card-body text-dark">

                                                
                                                      

                                                                <div class="card border-0 shadow mb-3">
                                                                    <div class="card-body">

                                                                        <form action="yonlendir?sayfa=yorum_ekle&id='.$id.'" method="post">

                                                                            <h4 class="mb-3">Dersi Değerlendirin</h4>

                                                                            <div class="form-floating mb-3">
                                                                                <textarea name="metin" class="form-control" placeholder="Yorumunuzu girin" id="floatingTextarea" style="resize:none; height: 100px;" required></textarea>
                                                                                <label for="floatingTextarea">Yorumunuz</label>
                                                                            </div>

                                                                            <div class="rate fs-5 rate-yellow mb-3">
                                                                                <input name="rating" type="radio" id="star1" value="1" required>
                                                                                <input name="rating" type="radio" id="star2" value="2" required>
                                                                                <input name="rating" type="radio" id="star3" value="3" required>
                                                                                <input name="rating" type="radio" id="star4" value="4" required>
                                                                                <input name="rating" type="radio" id="star5" value="5" required>

                                                                                <label for="star1" class="bi bi-star"></label>
                                                                                <label for="star2" class="bi bi-star"></label>
                                                                                <label for="star3" class="bi bi-star"></label>
                                                                                <label for="star4" class="bi bi-star"></label>
                                                                                <label for="star5" class="bi bi-star"></label>
                                                                            </div>

                                                                            <input type="submit" class="btn btn-dark" value="Gönder">
                                                                        </form>

                                                                    </div>
                                                                </div>';

                                                                $sorgu2=$vt->prepare("select * from yorumlar where ders='$id' AND puan >=3 ORDER BY RAND() LIMIT 3");
                                                                $sorgu2->execute();
                                                                while($sonuc2=$sorgu2->fetch(PDO::FETCH_ASSOC)):
                                                                    $y_id=$sonuc2["id"];
                                                                    $yorum_yapan=$sonuc2["yorum_yapan"];
                                                                    $yorum=$sonuc2["yorum"];
                                                                    $puan=$sonuc2["puan"];
                                                                    $begeni=$sonuc2["begeni"];
                                                                    $dislike=$sonuc2["dislike"];
                                                                    $tarih=$sonuc2["tarih"];
                                                                    $i=0;
                                                                    $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                                                                    $sorgu4->execute();
                                                                    while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                                                        $kisi=$sonuc4["tamad"];
                                                                    }

                                                                    echo '
                                                                        <div class="card border-0 shadow mb-3">
                                                                            <div class="card-body">
                                                                                <span class="rate-yellow">
                                                                                ';
                                                                                while($i!=5)
                                                                                {
                                                                                    if($i<$puan)
                                                                                    {
                                                                                        echo '<small for="star1" class="bi bi-star-fill"></small>';
                                                                                        
                                                                                    }
                                                                                    else{
                                                                                        echo'<small for="star5" class="bi bi-star"></small>';
                                                                                    }
                                                                                    $i++;
                                                                                }
                                                                                    
                                                                                echo '
                                                                                </span>
                                                                                <p>'.$yorum.' </p>
                                                                                <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                                                                <ul class="list-inline fs-5">
                                                                                    <li class="list-inline-item me-4">
                                                                                        <a href="yonlendir?sayfa=yorum_b_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-up"></i></a> '.$begeni.'
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <a href="yonlendir?sayfa=yorum_d_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-down"></i></a> '.$dislike.'
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                    
                                                                endwhile;

                                                                $sorgu3=$vt->prepare("select * from yorumlar where ders='$id' AND puan <3 ORDER BY RAND() LIMIT 2");
                                                                $sorgu3->execute();
                                                                while($sonuc3=$sorgu3->fetch(PDO::FETCH_ASSOC)):
                                                                    $y_id=$sonuc3["id"];
                                                                    $yorum_yapan=$sonuc3["yorum_yapan"];
                                                                    $yorum=$sonuc3["yorum"];
                                                                    $puan=$sonuc3["puan"];
                                                                    $begeni=$sonuc3["begeni"];
                                                                    $dislike=$sonuc3["dislike"];
                                                                    $tarih=$sonuc3["tarih"];
                                                                    $i=0;
                                                                    $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                                                                    $sorgu4->execute();
                                                                    while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                                                        $kisi=$sonuc4["tamad"];
                                                                    }


                                                                    echo '
                                                                        <div class="card border-0 shadow mb-3">
                                                                            <div class="card-body">
                                                                                <span class="rate-yellow">
                                                                                ';
                                                                                while($i!=5)
                                                                                {
                                                                                    if($i<$puan)
                                                                                    {
                                                                                        echo '<small for="star1" class="bi bi-star-fill"></small>';
                                                                                        
                                                                                    }
                                                                                    else{
                                                                                        echo'<small for="star5" class="bi bi-star"></small>';
                                                                                    }
                                                                                    $i++;
                                                                                }
                                                                                    
                                                                                echo '
                                                                                </span>
                                                                                <p>'.$yorum.' </p>
                                                                                <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                                                                <ul class="list-inline fs-5">
                                                                                    <li class="list-inline-item me-4">
                                                                                        <a href="yonlendir?sayfa=yorum_b_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-up"></i></a> '.$begeni.'
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <a href="yonlendir?sayfa=yorum_d_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-down"></i></a> '.$dislike.'
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                    
                                                                endwhile;

                                                            echo '
                                                </div>
                                            </div>
                                        </div>            
                                    </div>
                                </div>     
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" >
                                <div class="container">
                                    <div class="row">

                                        <div class="col-7">
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header text-center d-flex">
                                                    <h5 class="card-title col-8">'.$sahibi.'</h5>
                                                    <div class="justify-content-end col-4">

                                                ';
                                                if($linkedin!=NULL){
                                                    echo'
                                                        <a class ="float-right;"href="'.$linkedin.'" style="color:#212121; font-size:35px; margin-right:5px;"><i class="fab fa-linkedin"></i></i></a></h4>
                                                    ';
                                                }
                                                if($github!=NULL){
                                                    echo'
                                                        <a href="'.$github.'" style="color:#212121; font-size:35px; margin-right:5px;"><i class="fab fa-github-square"></i></i></a></h4>
                                                    ';
                                                }
                                                echo'
                                                </div>
                                                </div>
                                                <div class="card-body text-dark">
                                                    <p class="card-text">'.$hakkında.'</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-5"> 
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header">
                                                    Tüm Dersleri
                                                </div>
                                                <ul class="list-group list-group-flush">

                                                ';

                                                $sorgu3=$vt->prepare("select * from dersler where sahibi='$sahibi'");
                                                $sorgu3->execute();
                                                while($sonuc2=$sorgu3->fetch(PDO::FETCH_ASSOC)):
                                                    $ders_adi=$sonuc2["ders_adi"];
                                                    $id=$sonuc2["id"];
                                                
                                                        echo '<li class="list-group-item "><a class="dropdown-item" href="?id='.$id.'&video=1.mp4">'.$ders_adi.'</a></li>';

                                                endwhile;
                                                    echo'
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="card text-white bg-dark mb-3 mt-2" >
                                    <div class="text-center  card-header"><h5><strong>Soru Sor</strong></h5></div>
                                    <div class="card-body">
                                        <form action="yonlendir?sayfa=soru_ekle&ders='.$id.'&video='.$video.'" method="post">
                                            <div class="form-group text-center"> 
                                                <textarea style="resize: none;"class="form-control" name="soru" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                <button type="submit" class="btn btn-lg btn-outline-light mt-3">sor</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-rapor" role="tabpanel" aria-labelledby="nav-rapor-tab">
                                <div class="card text-white bg-danger mb-3 mt-2" >
                                    <div class="text-center  card-header"><h5><strong style="color:black;">Raporla</strong></h5></div>
                                    <div class="card-body">
                                        <form action="yonlendir?sayfa=ders_bildir&ders='.$id.'&video='.$video.'" method="post">
                                            <div class="form-group text-center"> 
                                                <textarea style="resize: none; background:black;color:white;" class="form-control" name="rapor" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                <p style="color:black;">*Ders ile ilgili şikayetin varsa dersi raporlayarak incelenmesini sağlayabilirsin.</p>
                                                <button type="submit" class="btn btn-lg btn-outline-dark mt-3">Bildir</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                </div>
                ';
            endwhile;
        }

        function d_liste($kulad,$ders,$vt){
            $sorgu = $vt->prepare("select * from ders$ders where sira != '0'");
            $sorgu ->execute();
            
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $kaynak = $sunucum["kaynak"];
                $v_adi=$sunucum["video_adi"];
                echo '
                    
                    <div class="card mb-2" style="max-width: 420px; height:100px;">
                        <div class="row g-0">
                            <div class="col-md-3">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="100px" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["sira"].'</text></svg>
                            </div>
                            <div class="col-md-9">
                            <div class="card-body">
                            
                                <div class="form-check form-switch">
                                ';
                                $sorgu2 = $vt->prepare("select durum from izlenen where kullanıcı = '$kulad' and ders='$ders' and video='$v_adi'");
                                $sorgu2 ->execute();
                                $durum=$sorgu2->fetch(PDO::FETCH_ASSOC);
                                if($durum==0)
                                {
                                    echo 
                                    '
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <h5 class="card-title"><a class="dropdown-item"  href="video?id='.$ders.'&video='.$sunucum["video_adi"].'&1=1" class="yazı"> <bold>'.$sunucum["aciklama"].'</bold></a></h5>
                                        </label>
                                    ';
                                }
                                    
                                    else
                                    {
                                        echo 
                                        '
                                            <input class="form-check-input" type="checkbox" value="" id="flexSwitchCheckCheckedDisabled" checked disabled>
                                            <label class="form-check-label" for="flexSwitchCheckCheckedDisabled" enabled>
                                                <h5 class="card-title"><a class="dropdown-item"  href="video?id='.$ders.'&video='.$sunucum["video_adi"].'&1=1" class="yazı"> <bold>'.$sunucum["aciklama"].'</bold></a></h5>
                                            </label>
                                        ';
                                    }
                                    
                                echo '
                                </div>';
                                if($kaynak!=NULL)
                                {
                                    echo '
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <a href="dersler/'.$ders.'/'.$kaynak.'" download="Codeout">
                                                    <button class="btn btn-outline-dark" type="submit">Ek dosya</button>
                                                </a>
                                            </small>
                                        </p>
                                    ';
                                }
                                echo'
                                </div>
                            </div>
                        </div>
                    </div>       
                ';
            endwhile;       
        }
        
        function d_video($kulad,$ders,$video,$vt){
            $sorgu = $vt->prepare("select * from  dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                echo '
                    
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="dersler/'.$sunucum["id"].'/'.$video.'"></iframe>
                    </div>
                ';
            endwhile;
        }

        function k_d_dersler($kulad,$vt) {
            $idler = $vt->prepare("select * from alınan where alan='$kulad'");
            $idler->execute();
            while($id=$idler->fetch(PDO::FETCH_ASSOC)):{
                $cek=$id["ders"];
                $dersler = $vt->prepare("select * from dersler where id='$cek'");
                $dersler->execute();

                while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):
                
                        $v_adi=self::sira($sunucum["ders_adi"],$vt);
                        $id=$sunucum["id"];
                        $ders_adi=$sunucum["ders_adi"];
                        $izlenen=self::k_d_takip($kulad,$cek,$vt);
                        echo '
                            <div class="col">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["ders_adi"].'</text></svg>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark float-left" role="progressbar" aria-valuenow="'; echo $izlenen; echo '" aria-valuemin="0" aria-valuemax="100" style="width: '; echo $izlenen; echo '%">Tamamlanan: %'; echo $izlenen; echo '</div>
                                        </div>
                                        
                                        ';
                                        
                                            $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);
                                            if($cevap!=0):
                                            echo '
        
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <h5><a class="btn btn-m btn-outline-primary " href="video?id='.$sunucum["id"].'&video='.$v_adi.'">Derse Git</a></h5>   
                                                    </div>
                                                    <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                                    <small class="text-muted ">
                
                                                    <div class="align-items-center">
                                                        ';
            
                                                        $puan=self::ders_puanı_ort($id,$vt);
                                              
                                                    $a=0;
                                                    if($puan!=0)
                                                    {
                                                        while($a!=5)
                                                        {
                                                            if($a<$puan)
                                                            {
                                                                echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
        
                                                            }
                                                            else{
                                                                echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                            }
                                                            $a++;
                                                        }
                                                        echo' ('.$puan.')';
                                                    }
        
                                                echo'
                                                    </div>
                                                    </small>
                                                </div>
                                            ';
                                            else:{
                                                echo '
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <h5> <a class="btn btn-m btn-outline-success" href="video?id='.$sunucum["id"].'&video='.$v_adi.'&sayfa=basla&git='.$sunucum["ders_adi"].'">Kursa Git</a> </h5>
                                                    </div>
                                                    <small class="text-muted">Ders veren : '.$sunucum["sahibi"].'</small>
                                                    <small class="text-muted ">
                
                                                    <div class="align-items-center">
                                                        ';
            
                                                        $puan=self::ders_puanı_ort($id,$vt);
                                              
                                                    $a=0;
                                                    if($puan!=0)
                                                    {
                                                        while($a!=5)
                                                        {
                                                            if($a<$puan)
                                                            {
                                                                echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
        
                                                            }
                                                            else{
                                                                echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                            }
                                                            $a++;
                                                        }
                                                        echo' ('.$puan.')';
                                                    }
        
                                                echo'
                                                    </div>
                                                    </small>
                                                </div>
                                            ';
                                            }
                                            endif;
                                        echo '
                                    </div>
                                </div>
                            </div>
                        ';
                endwhile;    
            }
            endwhile;          
        }

        function d_id($kulad,$d_adi,$vt){

            $idler = $vt->prepare("select id from dersler where sahibi='$kulad' and ders_adi='$d_adi'");
            $idler->execute();
            $id = $idler->fetch(PDO::FETCH_ASSOC);
            return $id["id"];
        }

        function d_rapor($kulad,$ders,$video,$rapor,$vt){
            $ekle = $vt->prepare("insert into rapor (id,ders,video,raporlayan,rapor,görüldü,zaman) values (NULL,'$ders','$video','$kulad','$rapor','0',NULL)");
            $ekle->execute();
        }

        function bul($kulad,$bul,$vt){
            $dersler = $vt->prepare("select * from dersler where ders_adi like '%$bul%'");
            $dersler->execute();

            if($dersler->rowCount()!=0){
                while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):

                    $id=$sunucum["id"];
                    $v_adi=self::sira($sunucum["ders_adi"],$vt);

                    echo '
                        <div class="col">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["ders_adi"].'</text></svg>
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="text-center">'.$sunucum["ders_adi"].'</h5>';
                                    
                                    if($sunucum["fiyat"]!='0'):
                                        echo '
                                            <p class="Fiyat">Fiyat: '.$sunucum["fiyat"].'</p>
                                            ';
                                            echo '
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Tanıtım izle</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Satın Al</button>
                                                </div>
                                                <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                                <small class="text-muted ">
                                                <div class="align-items-center">
                                                ';
    
                                                $puan=self::ders_puanı_ort($id,$vt);
                                              
                                                $a=0;
                                                if($puan!=0)
                                                {
                                                    while($a!=5)
                                                    {
                                                        if($a<$puan)
                                                        {
                                                            echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
    
                                                        }
                                                        else{
                                                            echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                        }
                                                        $a++;
                                                    }
                                                    echo' ('.$puan.')';
                                                }
    
                                            echo'
                                            </div>
                                                </small>
                                            </div>';
            
                                    else:
                                            $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);
    
                                        if($cevap!=0):
                                        echo '
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <h5><a class="btn btn-m btn-outline-primary " href="ders?id='.$sunucum["id"].'">Derse Git</a></h5>   
                                                </div>
                                                <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                                <small ><div class="align-items-center">
                                                <span >
                                                ';
    
                                                    $puan=self::ders_puanı_ort($id,$vt);
                                              
                                                    $a=0;
                                                    if($puan!=0)
                                                    {
                                                        while($a!=5)
                                                        {
                                                            if($a<$puan)
                                                            {
                                                                echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
        
                                                            }
                                                            else{
                                                                echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                            }
                                                            $a++;
                                                        }
                                                        echo' ('.$puan.')';
                                                    }
        
                                                echo'
                                            </div>
                                            </small>
                                            </div>
                                        ';
                                        else:{
                                            echo '
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <h5> <a class="btn btn-m btn-outline-success" href="ders?id='.$sunucum["id"].'">Kursa Git</a> </h5>
                                                </div>
                                                <small class="text-muted">Ders veren : '.$sunucum["sahibi"].'</small>
                                                <small class="text-muted">Kayıtlı '.$sunucum["kayıtlı"].' Kullanıcı</small>
                                            </div>
                                        ';
                                        }
                                        endif;
                                    endif;
                                    echo '
                                </div>
                            </div>
                        </div>
                    ';
                endwhile;
            }
                     
        }

        function v_ekle($kulad,$id,$v_baslik,$vt){
            $kontrol = $vt->prepare("select MAX(sira) FROM ders$id");
            $kontrol->execute();
            $sonuc = $kontrol->fetch(PDO::FETCH_ASSOC);
            $sira= $sonuc["MAX(sira)"] + 1;
            if(isset($_POST["SubmiteFile"])){
                $Orgname      = $_FILES["video"]["name"];
                $ImageType    = $_FILES["video"]["type"];
                $ImageSize    = $_FILES["video"]["size"];
                $TmpName      = $_FILES["video"]["tmp_name"];
                $ImageError   = $_FILES["video"]["error"];
                $UploadFolder = "dersler/$id/";
                $v_name       = "video".rand(0,9999);
    
                $MaxSize      = 1024*1024*1000;
                $FileExt      = substr($_FILES["video"]["name"],-4,4);
                
                if($sonuc["MAX(sira)"]== NULL):     
                    $v_adi = "1".$FileExt;
                    $ekle = $vt->prepare("insert into ders$id (id,video_adi,aciklama,sira) values (NULL,'$v_adi','$v_baslik','$sira')");
                    $ekle->execute();    
                    $NewFileName  = $UploadFolder."1".$FileExt;         
                    
                    
                else:        
                    $NewFileName  = $UploadFolder.$v_name.$FileExt;
                    $v_adi = $v_name.$FileExt;
                    $ekle = $vt->prepare("insert into ders$id (id,video_adi,aciklama,sira) values (NULL,'$v_adi','$v_baslik','$sira')");
                    $ekle->execute(); 
                endif;
                
                if($_FILES["video"]["size"]> $MaxSize)
                {
                    echo "Dosya boyutu en fazla 100MB olabilir!";
                }
                else
                {
                    $file=$_FILES["video"]["type"];
                   
                    if(is_uploaded_file($TmpName))
                    {
                        $move = move_uploaded_file($TmpName,$NewFileName);
                        if($move){
                            echo "Dosya yükleme işlemi başarılı";
                        }
                        else
                        {
                            echo "hata var";
                        }
                    }  
                }
            }
        }

        function d_edit($kulad,$id,$vt){
            $kontrol1 = $vt->prepare("select ders_adi from dersler where id ='$id' and sahibi='$kulad'");
            $kontrol1->execute();
            while($sonuc1 = $kontrol1->fetch(PDO::FETCH_ASSOC)):
                $d_adi = $sonuc1["ders_adi"];
                $kontrol = $vt->prepare("select * FROM ders$id where sira != '0'");
                $kontrol->execute();
            
                while($sunucum=$kontrol->fetch(PDO::FETCH_ASSOC)):
                echo '
                <div class="col-4 float-left">
                <div class="card ">
                    <div class="card-header text-muted border-bottom-0">
                    
                    </div>
                    <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                        <h2 class="lead"> <b> Video Sırası : '.$sunucum["sira"].'</b></h2>
                        <h3 class="lead"><b>Video Başlığı : </b>'.$sunucum["aciklama"].'</h3>
                        </div>
                        
                    </div>
                    </div>
                    <div class="card-footer">
                    <div class="text-right">

                        <a href="index?sayfa=video_sil&id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-danger swalDefaultSuccess">
                            <i class="fas fa-trash"></i>
                            Video Kaldır
                        </a>

                         <a href="index?sayfa=video_kaynak&id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-info">
                            <i class="fas fa-file-pdf"></i>
                            Kaynak Ekle
                        </a>

                        <a href="index?sayfa=video_degis&id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-warning">
                            <i class="fas fa-exchange-alt"></i>
                            Video Değiştir
                        </a>

                        <a href="../video?id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-primary">
                            <i class="fas fa-video"></i>
                            Videoyu Gör
                        </a>
                    </div>
                    </div>
                </div>
            </div>
                ';
                endwhile;
            endwhile;
        }

        function d_tanıtım($kulad,$id,$vt){
            $kontrol1 = $vt->prepare("select ders_adi from dersler where id ='$id' and sahibi='$kulad'");
            $kontrol1->execute();
            while($sonuc1 = $kontrol1->fetch(PDO::FETCH_ASSOC)):
                $d_adi = $sonuc1["ders_adi"];
                $kontrol = $vt->prepare("select * FROM ders$id where aciklama='tanıtım'");
                $kontrol->execute();

                if($kontrol->RowCount()==0)
                {
                    echo '
                        <div class="col-3 ">
                            <div class="card ">
                                <div class="card-header text-muted border-bottom-0">

                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"> <b> Tanıtım Videosu</b></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                      
                                        <a href="index?sayfa=d_tanıtım&id='.$id.'" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus"></i>
                                            Video Ekle
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
            
                while($sunucum=$kontrol->fetch(PDO::FETCH_ASSOC)):
                echo '
                <div class="col-4">
                <div class="card ">
                    <div class="card-header text-muted border-bottom-0">
                    
                    </div>
                    <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                        <h2 class="lead"> <b> Tanıtım Videosu</b></h2>
                        </div>
                        
                    </div>
                    </div>
                    <div class="card-footer">
                    <div class="text-right">

                        <a href="index?sayfa=video_sil&id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-danger swalDefaultSuccess">
                            <i class="fas fa-trash"></i>
                            Video Kaldır
                        </a>

                        <a href="index?sayfa=video_degis&id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-warning">
                            <i class="fas fa-exchange-alt"></i>
                            Video Değiştir
                        </a>

                        <a href="../video?id='.$id.'&video='.$sunucum["video_adi"].'" class="btn btn-sm btn-primary">
                            <i class="fas fa-video"></i>
                            Videoyu Gör
                        </a>
                    </div>
                    </div>
                </div>
            </div>
                ';
                endwhile;
            endwhile;
        }

        function d_t_ekle($kulad,$id,$vt){
           
            if(isset($_POST["SubmiteFile"])){
                $Orgname      = $_FILES["video"]["name"];
                $ImageType    = $_FILES["video"]["type"];
                $ImageSize    = $_FILES["video"]["size"];
                $TmpName      = $_FILES["video"]["tmp_name"];
                $ImageError   = $_FILES["video"]["error"];
                $UploadFolder = "dersler/$id/";
                $v_name       = "video".rand(0,9999);
    
                $MaxSize      = 1024*1024*1000;
                $FileExt      = substr($_FILES["video"]["name"],-4,4);
                
                    $v_adi = "tanıtım".$FileExt;
                    $ekle = $vt->prepare("insert into ders$id (id,video_adi,aciklama,sira) values (NULL,'$v_adi','Tanıtım','0')");
                    $ekle->execute();    
                    $NewFileName  = $UploadFolder."tanıtım".$FileExt;         
                    
                if($_FILES["video"]["size"]> $MaxSize)
                {
                    echo "Dosya boyutu en fazla 100MB olabilir!";
                }
                else
                {
                    $file=$_FILES["video"]["type"];
                   
                    if(is_uploaded_file($TmpName))
                    {
                        $move = move_uploaded_file($TmpName,$NewFileName);
                        if($move){
                            echo "Dosya yükleme işlemi başarılı";
                        }
                        else
                        {
                            echo "hata var";
                        }
                    }  
                }
            }
        }

        function video_degis($kulad,$id,$video,$v_baslik,$vt){

            $kontrol = $vt->prepare("select sira from ders$id where video_adi ='$video'");
            $kontrol->execute();
            $sonuc = $kontrol->fetch(PDO::FETCH_ASSOC);
            if(isset($_POST["SubmiteFile"])){
                $Orgname      = $_FILES["video"]["name"];
                $ImageType    = $_FILES["video"]["type"];
                $ImageSize    = $_FILES["video"]["size"];
                $TmpName      = $_FILES["video"]["tmp_name"];
                $ImageError   = $_FILES["video"]["error"];
                $UploadFolder = "dersler/$id/";
                $v_name       = "video".rand(0,9999);

                $MaxSize      = 1024*1024*1000;
                $FileExt      = substr($_FILES["video"]["name"],-4,4);

                if($sonuc["sira"]=="1"):
                    if (file_exists("dersler/".$id."/".$video))
                    { //dosyalar dizininin içerisinde resimler klasörü mevcut ise
                        array_map('unlink', glob("dersler/".$id."/".$video)); //bütün dosyalar siliniyor
                    }
                    $v_adi = "1".$FileExt;
                    $degis = $vt->prepare("update ders$id set video_adi='$v_adi',aciklama='$v_baslik' where video_adi='$video'");
                    $degis->execute();

                    $NewFileName  = $UploadFolder."1".$FileExt;
                else:   
                    if (file_exists("dersler/".$id."/".$video))
                    { //dosyalar dizininin içerisinde resimler klasörü mevcut ise
                        array_map('unlink', glob("dersler/".$id."/".$video)); //bütün dosyalar siliniyor
                    }       
                    $v_adi = $v_name.$FileExt;
                    $degis = $vt->prepare("update ders$id set video_adi='$v_adi',aciklama='$v_baslik' where video_adi='$video'");
                    $degis->execute();
                    $NewFileName  = $UploadFolder.$v_name.$FileExt;

                endif;
                
                if($_FILES["video"]["size"]> $MaxSize)
                {
                    echo "Dosya boyutu en fazla 100MB olabilir!";
                }
                else
                {
                    $file=$_FILES["video"]["type"];
                   
                    if(is_uploaded_file($TmpName))
                    {
                        $move = move_uploaded_file($TmpName,$NewFileName);
                        if($move){
                            echo "Dosya yükleme işlemi başarılı";
                        }
                        else
                        {
                            echo "hata var";
                        }
                    }  
                }
            }
        }

        function v_sil($kulad,$id,$video,$d_adi,$vt){
            $sorgu=$vt->prepare("select ders_adi from dersler where id='$id'");
            $sorgu->execute();
            $sunucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            $ders_adi=$sunucum["ders_adi"];
            if($ders_adi==$d_adi){
                $sorgu2=$vt->prepare("delete from ders$id where video_adi='$video'");
                $sorgu2->execute();
                if (file_exists("dersler/".$id."/".$video))
                  { //dosyalar dizininin içerisinde resimler klasörü mevcut ise
                    array_map('unlink', glob("dersler/".$id."/".$video)); //bütün dosyalar siliniyor
                  }
            } 
        }

        function k_ekle($kulad,$id,$video,$vt){
            if(isset($_POST["SubmiteFile"])){
                $Orgname      = $_FILES["video"]["name"];
                $ImageType    = $_FILES["video"]["type"];
                $ImageSize    = $_FILES["video"]["size"];
                $TmpName      = $_FILES["video"]["tmp_name"];
                $ImageError   = $_FILES["video"]["error"];
                $UploadFolder = "dersler/$id/";
                $v_name       = "dosya".rand(0,9999);
    
                $MaxSize      = 1024*1024*1000;
                $FileExt      = substr($_FILES["video"]["name"],-4,4);

                $NewFileName  = $UploadFolder.$v_name.$FileExt;
                $k_adi = $v_name.$FileExt;
                $degis = $vt->prepare("update ders$id set kaynak='$k_adi' where video_adi='$video'");
                $degis->execute();

                if($_FILES["video"]["size"]> $MaxSize)
                {
                    echo "Dosya boyutu en fazla 100MB olabilir!";
                }
                else
                {
                    $file=$_FILES["video"]["type"];
                   
                    if(is_uploaded_file($TmpName))
                    {
                        $move = move_uploaded_file($TmpName,$NewFileName);
                        if($move){
                            echo "Dosya yükleme işlemi başarılı";
                        }
                        else
                        {
                            echo "hata var";
                        }
                    }  
                }
            }
        }

        function sorular($kulad,$vt){
            
            $sorgu = $vt->prepare("select * from dersler where sahibi='$kulad'");
            $sorgu->execute();

            $kul=$vt->prepare("select resim from uye where kulad= '$kulad'");
            $kul->execute();
            $kullanıcı=$kul->fetch(PDO::FETCH_ASSOC);
            $resim=$kullanıcı["resim"];

            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $d_id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                
                $sorgu2= $vt->prepare("select * from ders_soru where  alıcı='$kulad' and durum='0'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)):
                    
                    $s_id=$sunucum2["id"];
                    $ders=$sunucum2["ders"];
                    $gönderen=$sunucum2["gönderen"];
                    $alıcı=$sunucum2["alıcı"];
                    $mesaj=$sunucum2["mesaj"];
                    $okundu=$sunucum2["okundu"];
                    $zaman=$sunucum2["zaman"];

                    echo'
                    <div class="col-md-3 float-left">
                    <!-- DIRECT CHAT DANGER -->';
                    if($okundu==0){
                        echo '<div class="card card-danger direct-chat direct-chat-danger shadow-lg">';
                    }
                    else{
                        echo '<div class="card card-success direct-chat direct-chat-success shadow-lg">';
                    }
                        echo '
                          <div class="card-header">
                            <h3 class="card-title">Gelen Soru | '.$ders_adi.'</h3>

                            <div class="card-tools">
                              <span title="3 New Messages" class="badge">
                                ';
                                if($okundu==0){
                                    $sayı=$vt->prepare("select count(*) from ders_soru where alıcı='$kulad' and gönderen='$gönderen'");
                                    $sayı->execute();
                                    $bil_sayı=$sayı->fetch(PDO::FETCH_ASSOC);
                                    $bildirim=$bil_sayı["count(*)"];
                                    echo $bildirim;
                                }
                                echo'
                              </span>
                              <a href="../yonlendir?sayfa=soru_sil&id='.$s_id.'&ders='.$d_id.'&gonderen='.$gönderen.'" class="btn btn-tool">
                              <i class="fas fa-trash"></i>
                              </a>
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                              <!-- Message. Default to the left -->
                              <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-left">'.$gönderen.'</span>
                                  <span class="direct-chat-timestamp float-right">'.$zaman.'</span>
                                </div>
                                <!-- /.direct-chat-infos -->
                                <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="Message User Image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                '.$mesaj.'
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
                              ';
                              $bak=$vt->prepare("select * from ders_soru WHERE gönderen='$kulad' and alıcı='$gönderen' and durum='0' and cevap='$s_id'");
                                $bak->execute();
                                while($sunuc=$bak->fetch(PDO::FETCH_ASSOC)):
                                    $c_id=$sunuc["id"];
                                    $c_ders=$sunuc["ders"];
                                    $c_gönderen=$sunuc["gönderen"];
                                    $c_alıcı=$sunuc["alıcı"];
                                    $c_mesaj=$sunuc["mesaj"];
                                    $c_okundu=$sunuc["okundu"];
                                    $c_zaman=$sunuc["zaman"];
                                    if($bak->rowCount()!=0 && $c_id>$s_id):
                                            echo '
                                                <!-- Message to the right -->
                                                <div class="direct-chat-msg right">
                                                  <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">'.$c_gönderen.'</span>
                                                    
                                                  </div>
                                                  <!-- /.direct-chat-infos -->
                                                  <img class="direct-chat-img" src="../'.$resim.'" alt="Message User Image">
                                                  <!-- /.direct-chat-img -->
                                                  <div class="direct-chat-text">
                                                    '.$c_mesaj.'
                                                  </div>
                                                  <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                            ';
                                        
                                    endif;
                                endwhile;
                        echo '
                            </div>
                            <!--/.direct-chat-messages-->

                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                              <ul class="contacts-list">
                                <li>
                                  <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Avatar">

                                    <div class="contacts-list-info">
                                      <span class="contacts-list-name">
                                        Count Dracula
                                        <small class="contacts-list-date float-right">2/28/2015</small>
                                      </span>
                                      <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                  </a>
                                </li>
                                <!-- End Contact Item -->
                              </ul>
                              <!-- /.contatcts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                            <form action="../yonlendir?sayfa=soru-cevap&id='.$ders.'&hedef='.$gönderen.'&soru='.$s_id.'" method="post">
                              <div class="input-group">
                                <input type="text" name="message" placeholder="Cevap ..." class="form-control">
                                <span class="input-group-append">
                                  <button type="submit" class="btn btn-block btn-outline-primary">Gönder</button>
                                </span>
                              </div>
                            </form>
                          </div>
                          <!-- /.card-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                    <!-- /.col -->
                ';
                endwhile;
            endwhile;

        }

        function s_ekle($kulad,$id,$video,$soru,$vt){
            $kim= $vt->prepare("select sahibi from dersler where id='$id'");
            $kim->execute();
            $sonuc=$kim->fetch(PDO::FETCH_ASSOC);
            $hedef=$sonuc["sahibi"];
            $ekle = $vt->prepare("insert into ders_soru (id,ders,gönderen,alıcı,mesaj,okundu,zaman) values (NULL,'$id','$kulad','$hedef','$soru','0',NULL)");
            $ekle->execute();
        }

        function s_cevapla($kulad,$id,$s_id,$hedef,$cevap,$vt){  
            $ekle = $vt->prepare("insert into ders_soru (id,ders,gönderen,alıcı,mesaj,okundu,durum,cevap,zaman) values (NULL,'$id','$kulad','$hedef','$cevap','0','0','$s_id',NULL)");
            $ekle->execute();
            $guncelle=$vt->prepare("update ders_soru set okundu='1' WHERE id='$s_id'");
            $guncelle->execute();
        }

        function s_sil($kulad,$id,$ders,$kisi,$vt){
            $guncelle=$vt->prepare("update ders_soru set durum='1' WHERE id='$id'");
            $guncelle->execute();
            $sorgu = $vt->prepare("select * from ders_soru where ders='$ders' and alıcı='$kisi' and durum='0'");
            $sorgu->execute();

            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $c_id=$sunucum["id"];
                $guncelle2=$vt->prepare("update ders_soru set durum='1' WHERE id='$c_id'");
                $guncelle2->execute();
            endwhile;
        }

        function y_a_bilgi($kulad,$vt){

            $sorgu = $vt->prepare("select * from uye where kulad='$kulad'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $kulad=$sunucum["kulad"];
                $resim=$sunucum["resim"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];

                echo '
                <div class="col-md-4">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">'.$kulad.'</h3>
                        <h5 class="widget-user-desc">Founder & CEO</h5>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="'.$resim.'" alt="User Avatar">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <a href="'.$linkedin.'" style="color:#212121;"><span class="description-text"><i class="fab fa-linkedin-in"></i></span></a>
                              <p class="description"><a href="" style="color:#212121;">Değiştir</a></p>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">13,000</h5>
                              <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4">
                            <div class="description-block">
                                <a href="'.$github.'" style="color:#212121;"><span class="description-text"><i class="fab fa-github"></i></span></a>
                                <p class="description"><a href="" style="color:#212121;">Değiştir</a></p>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
                <!-- /.col -->
            ';
            endwhile;
            
        }

        function sorulanlar($kulad,$vt){
            $sorgu=$vt->prepare("select DISTINCT(gönderen) from ders_soru where alıcı='$kulad'");
            $sorgu->execute();

            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $gönderen=$sunucum["gönderen"];
                $sorgu2=$vt->prepare("select * from ders_soru where alıcı='$kulad' and gönderen='$gönderen' and ö_okundu='0'");
                $sorgu2->execute();
                $yeni=$sorgu2->rowCount();
                $sorgu3=$vt->prepare("select resim,tamad from uye where kulad='$gönderen'");
                $sorgu3->execute();
                while($sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC))
                {
                    $resim2=$sunucum3["resim"];
                    $tamad=$sunucum3["tamad"];
                }
                echo '
                    <a href="?g='.$gönderen.'" class="list-group-item list-group-item-action border-0 ">
                        <div class="d-flex align-items-start">
                            <img src="'.$resim2.'" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
                            <div class="flex-grow-1 p-2">
                                '.$tamad;
                                if($yeni!=0){
                                    echo '<div class="badge bg-success float-right rounded-circle ">'.$yeni.'</div>';
                                }
                                    
                            echo '
                            </div>
                        </div>
                    </a>
                ';
            }
           
        }

        function soru_bak($kulad,$gonderen,$vt){
            $sorgu=$vt->prepare("select * from ders_soru where alıcı='$gonderen' and gönderen='$kulad' and ö_durum='0' and cevap is null");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $d_id=$sunucum["ders"];
                $id=$sunucum["id"];
                $sorgu2=$vt->prepare("select resim from uye where kulad='$kulad'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
                {
                    $resim1=$sunucum2["resim"];
                }
                $sorgu3=$vt->prepare("select resim from uye where kulad='$gonderen'");
                $sorgu3->execute();
                while($sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC))
                {
                    $resim2=$sunucum3["resim"];
                }
                    $mesaj=$sunucum["mesaj"];
                    $zaman=$sunucum["zaman"];
                    echo'
                    <div class="chat-message-right mb-4">
                        <div>
                            <img src="'.$resim1.'" class="rounded-circle mr-1" alt="" width="40" height="40">
                        </div>
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                            <div class="font-weight-bold mb-1">You</div>
                            '.$sunucum["mesaj"].'
                        </div>
                    </div>
                ';
                $sorgu4=$vt->prepare("select * from ders_soru where cevap='$id'");
                $sorgu4->execute();

                while($sunucum4=$sorgu4->fetch(PDO::FETCH_ASSOC))
                {
                    echo '
                        <div class="chat-message-left pb-4" >
                            <div>
                                <img src="'.$resim2.'" class="rounded-circle mr-1" alt="" width="40" height="40">
                            </div>
                            <div class="flex-shrink-1 bg-dark rounded py-2 px-3 ml-3">
                                <div class="font-weight-bold text-light mb-1">'.$sunucum4["mesaj"].'</div>
                                
                            </div>
                        </div>
                    ';
                }
            }

            
            echo'
            </div>
            </div>
                      <div class="flex-grow-0 py-3 px-4 border-top">
                <form action="?g='.$gonderen.'&sayfa=s_sor" method="post">
                                <div class="input-group">
                                      <input type="text" class="form-control" name="soru" placeholder="Sorunuzu yazın">
                                      <button class="btn btn-primary">Gönder</button>
                                </div>
                </form>
                      </div>
            ';
        }

        function kategoriler($vt){
            $sorgu=$vt->prepare("select DISTINCT(kategori) from altkategori");
            $sorgu->execute();

            echo '
                <nav class="navbar-expand navbar-dark " style="right:70%; position: absolute;">
                    <div>
                      <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown" >
                            <a class="nav-link dropdown-toggle" href="#" style="color:white;"id="dropdowndarkMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                              Kategoriler
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark"  aria-labelledby="navbarDarkDropdownMenuLink">
            ';
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                
                $anakategori=$sunucum["kategori"];
                
            echo '
                
                            <li class="dropdown-item">
                              <div class="btn-group dropend">
                                <button type="button" class="btn" style="width:150px;color:white;"id="dropdowndarkMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                  '.$anakategori.'
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark " style="margin-left:15px;">

                                ';
                                $sorgu2=$vt->prepare("select * from altkategori where kategori='$anakategori'");
                                $sorgu2->execute();
                                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)):
                                    $altkategori=$sunucum2["altkategori"];
                                    $id=$sunucum2["id"];
                                    echo '
                                        <li ><a class="dropdown-item" href="kategori?tür='.$id.'">'.$altkategori.'</a></li>
                                    ';
                                endwhile;
                                echo'
                                </ul>
                              </div>
                            </li>
                          ';
                       
            endwhile;
            echo'
                        </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </nav>
            ';
        }

        function türliste($kulad,$kategori,$vt) {
            
            $dersler = $vt->prepare("select * from dersler where kategori='$kategori'");
            $dersler->execute();

            while($sunucum=$dersler->fetch(PDO::FETCH_ASSOC)):

                $v_adi=self::sira($sunucum["ders_adi"],$vt);
                $id=$sunucum["id"];
                echo '
                    <div class="col">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["ders_adi"].'</text></svg>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="text-center">'.$sunucum["ders_adi"].'</h5>';
                                
                                
                                    $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);

                                    if($cevap!=0):
                                    echo '
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <h5><a class="btn btn-m btn-outline-primary " href="ders?id='.$sunucum["id"].'">Derse Git</a></h5>   
                                            </div>
                                            <small class="text-muted ">Ders veren : '.$sunucum["sahibi"].'</small>
                                            <small ><div class="align-items-center">
                                            <span >
                                            ';

                                                $puan=self::ders_puanı_ort($id,$vt);
                                          
                                                $a=0;
                                                if($puan!=0)
                                                {
                                                    while($a!=5)
                                                    {
                                                        if($a<$puan)
                                                        {
                                                            echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
    
                                                        }
                                                        else{
                                                            echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                        }
                                                        $a++;
                                                    }
                                                    echo' ('.$puan.')';
                                                }
    
                                            echo'
                                        </div>
                                        </small>
                                        </div>
                                    ';
                                    else:{
                                        echo '
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <h5> <a class="btn btn-m btn-outline-success" href="ders?id='.$sunucum["id"].'">Kursa Git</a> </h5>
                                            </div>
                                            <small class="text-muted">Ders veren : '.$sunucum["sahibi"].'</small>
                                            <small ><div class="align-items-center">
                                            <span >
                                            ';

                                                $puan=self::ders_puanı_ort($id,$vt);
                                          
                                                $a=0;
                                                if($puan!=0)
                                                {
                                                    while($a!=5)
                                                    {
                                                        if($a<$puan)
                                                        {
                                                            echo '<small for="star1" class="bi bi-star-fill me-1"></small>';
    
                                                        }
                                                        else{
                                                            echo'<small for="star5" class="bi bi-star me-1"></small>';
                                                        }
                                                        $a++;
                                                    }
                                                    echo' ('.$puan.')';
                                                }
    
                                            echo'
                                        </div>
                                        </small>
                                        </div>
                                    ';
                                    }
                                    endif;
                                echo '
                            </div>
                        </div>
                    </div>
                ';
            endwhile;
        }

        function giris_carosel($vt){
            $sorgu=$vt->prepare("select * FROM dersler ORDER BY puan >'2'and  RAND() LIMIT 2");
            $sorgu->execute();
            
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)){

                $id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                $sahibi=$sunucum["sahibi"];
                $aciklama=$sunucum["aciklama"];

                echo '
                <div class="carousel-item" style="height:200px;">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#212529"/></svg>

                    <div class="container">
                        <div class="col" style="position: absolute ;bottom: 2.25rem; padding-top: 1.25rem; padding-left:25.30rem;  padding-bottom: 1.25rem;color: #fff;text-align: center;">
                            <p >'.$aciklama.'</p>
                        </div>
                        <div class=" col-4" style="position: absolute;bottom: 1.00rem; padding-top: 1.25rem; padding-left:10.30rem;  padding-bottom: 1.25rem;color: #fff;text-align: center;">
                            <h1 class="float-left">'.$ders_adi.'</h1>
                            <p>Ders veren: '.$sahibi.'</p>
                            <p><a class="btn btn-m btn-dark" href="?sayfa=girisyap">Dersi Gör</a></p>
                        </div>
                    </div>
                </div>
                ';
            }
        }

        function carosel($vt){
            $sorgu=$vt->prepare("select * FROM dersler ORDER BY RAND() LIMIT 2");
            $sorgu->execute();
            
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)){

                $id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                $sahibi=$sunucum["sahibi"];
                $aciklama=$sunucum["aciklama"];
                $sorgu2=$vt->prepare("select video_adi from ders$id where sira='1'");
                $sorgu2->execute();
                $sonuc=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $v_adi=$sonuc["video_adi"];
                
                echo '
                <div class="carousel-item" style="height:200px;">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#212529"/></svg>

                    <div class="container ">
                        <div class="row ">
                            
                            <div class="col" style="position: absolute ;bottom: 2.25rem; padding-top: 1.25rem; padding-left:25.30rem;  padding-bottom: 1.25rem;color: #fff;text-align: center;">
                                <p >'; if($aciklama!=null){
                                    echo $aciklama;
                                }
                                echo'</p>
                            </div>
                            <div class=" col-4" style="position: absolute;bottom: 1.00rem; padding-top: 1.25rem; padding-left:10.30rem;  padding-bottom: 1.25rem;color: #fff;text-align: center;">
                                <h1 class="float-left">'.$ders_adi.'</h1>
                                <p>Ders veren: '.$sahibi.'</p>
                                <p><a class="btn btn-m btn-dark" href="video?id='.$id.'&video='.$v_adi.'">Dersi Gör</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }

        function d_gör($kulad,$ders,$video,$vt){

            $sorgu = $vt->prepare("select * from izlenen where kullanıcı='$kulad' and ders='$ders' and video='$video' and durum='1'");
            $sorgu->execute();
            if($sorgu->rowCount()==0)
            {
                $dersler = $vt->prepare("insert into izlenen (kullanıcı,ders,video,durum) values ('$kulad','$ders','$video','1')");
                $dersler->execute();
            }
            $sorgu2 = $vt->prepare("select * from izlenen where kullanıcı='$kulad' and ders='$ders' and video='$video' and durum='0'");
            $sorgu2->execute();
            if($sorgu2->rowCount()!=0)
            {
                $ekle=$vt->prepare("update izlenen set durum='1' WHERE kullanıcı='$kulad'and ders='$ders' and video='$video'");
                $ekle->execute();
            }
        }
        
        function k_d_takip($kulad,$d_id,$vt){
            $sonuc=0;
            $sorgu2 = $vt->prepare("select * from ders$d_id");
            $sorgu2->execute();
            if($sorgu2->rowCount()!=0)
            {
                $sorgu = $vt->prepare("select * from izlenen where kullanıcı='$kulad' and ders='$d_id'");
                $sorgu->execute();
                $izlenen=$sorgu->rowCount();
                $toplam=$sorgu2->rowCount();
                $toplam=$toplam-1;
                if($sorgu->rowCount()!=0){
                    $sonuc=($izlenen*100)/$toplam;
                }
                 return number_format($sonuc, 2);
            }
            else{
                $sorgu = $vt->prepare("select * from izlenen where kullanıcı='$kulad' and ders='$d_id'");
                $sorgu->execute();
                $izlenen=$sorgu->rowCount();
                $sorgu2 = $vt->prepare("select * from ders$d_id");
                $sorgu2->execute();
    
                $toplam=$sorgu2->rowCount();
                $sonuc=($izlenen*100)/$toplam;
                return number_format($sonuc, 2);
            }
            
           
        }

        function d_k_durum($kulad,$id,$vt){
            $sorgu3 = $vt->prepare("select * from ders$d_id where aciklama ='Tanıtım'");
            $sorgu3->execute();
        }

        function a_kullanıcılar($vt){
            $sorgu = $vt->prepare("select * from uye");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                echo '
                    <tr>
                        <td>'.$sunucum["kulad"].'</td>
                        <td>'.$sunucum["mail"].'</td>
                        <td>'.$sunucum["seviye"].'</td>
                        <td>
                            <a href="?sayfa=kullanıcı_ayar&id='.$sunucum["id"].'" class="btn btn-success btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-cog"></i>
                                </span>
                                <span class="text">Kullanıcı işlemleri</span>
                            </a>
                           
                        </td>
                    </tr>
                ';
            }
        }

        function a_dersler($kulad,$vt){
            $sorgu = $vt->prepare("select * from dersler");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                $sahibi=$sunucum["sahibi"];
                $fiyat=$sunucum["fiyat"];
                $kategori=$sunucum["kategori"];
                $kayıtlı=$sunucum["kayıtlı"];
                $aciklama=$sunucum["aciklama"];
                $durum=$sunucum["durum"];

                $kategori=$sunucum["kategori"];
                $sorgu2 = $vt->prepare("select * from altkategori where id='$kategori'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    $anakategori=$sunucum2["kategori"];
                    $altkategori=$sunucum2["altkategori"];
                }
                echo '
                    <tr>
                        <td>'.$ders_adi.'</td>
                        <td>'.$sahibi.'</td>
                        <td>'.$fiyat.'</td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 180px;">
                            '.$altkategori.'
                            </span>
                        </td>
                        <td>'.$kayıtlı.'</td>
                        <td>'.$aciklama.'</td>
                        <td>'.$durum.'</td>
                        <td>

                            <a href="../ders?id='.$id.'" class="btn btn-sm btn-success btn-icon-split mt-1">
                                <span class="icon text-white-50">
                                    <i class="fas fa-play"></i>
                                </span>
                                <span class="text">Video</span>
                            </a>

                            <a href="?sayfa=ders_ayar&id='.$id.'&s='.$sahibi.'" class="btn btn-sm btn-info btn-icon-split mt-1">
                                <span class="icon text-white-50">
                                    <i class="fas fa-sliders-h"></i>
                                </span>
                                <span class="text">İşlemler</span>
                            </a>

                        </td>
                    </tr>
                ';
            }
        }

        function a_raporlar($kulad,$vt){
            $sorgu = $vt->prepare("select * from rapor where görüldü='0'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders_id=$sunucum["ders"];
                $sorgu2 = $vt->prepare("select * from dersler where id='$ders_id'");
                $sorgu2->execute();
                $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $ders=$sunucum2["ders_adi"];
                echo '
                    <tr>
                        <td>'.$ders.'</td>
                        <td>'.$sunucum["video"].'</td>
                        <td>'.$sunucum["raporlayan"].'</td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 180px;">
                            '.$sunucum["rapor"].'
                            </span>
                        </td>
                        <td>'.$sunucum["zaman"].'</td>
                        <td>

                            <a href="../video?id='.$sunucum["ders"].'&video='.$sunucum["video"].'" class="btn btn-sm btn-success btn-icon-split mt-1">
                                <span class="icon text-white-50">
                                    <i class="fas fa-play"></i>
                                </span>
                                <span class="text">Video</span>
                            </a>

                            <a href="?sayfa=r_ayar&id='.$ders.'&video='.$sunucum["video"].'&r='.$sunucum["id"].'" class="btn btn-sm btn-info btn-icon-split mt-1">
                                <span class="icon text-white-50">
                                    <i class="fas fa-sliders-h"></i>
                                </span>
                                <span class="text">İşlemler</span>
                            </a>

                        </td>
                    </tr>
                ';
            }
        }

        function a_r_d_bilgi($kulad,$ders,$vt){
            $sorgu = $vt->prepare("select * from dersler where ders_adi='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kategori=$sunucum["kategori"];
                $sorgu2 = $vt->prepare("select * from altkategori where id='$kategori'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    $anakategori=$sunucum2["kategori"];
                    $altkategori=$sunucum2["altkategori"];
                }
                echo '
                    <h3 class="h5">Ders adı: '.$sunucum["ders_adi"].'</h3>
                    <h3 class="h5">Ders sahibi: '.$sunucum["sahibi"].'</h3>
                    <h3 class="h5">Ders fiyatı: '.$sunucum["fiyat"].'</h3>
                    <h3 class="h5">Ders kategorisi: '.$anakategori.' | '.$altkategori.'</h3>
                    <h3 class="h5">Derse kayıtlı kişi sayısı: '.$sunucum["kayıtlı"].'</h3>
                    <h3 class="h5">Ders durumu: ';
                    if($sunucum["durum"]==1){
                        echo 'Yayında';
                    }
                    else{
                        echo 'Yayında değil';
                    }
                    echo '
                    </h3>
                    <h3 class="h5">Ders açıklaması: '.$sunucum["aciklama"].'</h3>
                ';
            }
        }

        function a_r_v_bilgi($kulad,$ders,$video,$vt){
            $sorgu3 = $vt->prepare("select * from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            while($sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum3["id"];
            }
            $sorgu = $vt->prepare("select * from ders$id where video_adi='$video'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                echo '
                    <h3 class="h5">Video adı: '.$sunucum["video_adi"].'</h3>
                    <h3 class="h5">Video açıklaması: '.$sunucum["aciklama"].'</h3>
                    <h3 class="h5">Video sırası: '.$sunucum["sira"].'</h3>
                    <h3 class="h5">Video kaynağı: '.$sunucum["kaynak"].'</h3>
                    <h3 class="h5">Video uyarı sayısı: '.$sunucum["uyarı"].'</h3>
                    <h3 class="h5">Video durumu: ';
                        if($sunucum["durum"]==1){
                            echo'Yayında';
                        }
                        else{
                            echo 'Yayında değil';
                        }
                    
                    echo'
                    </h3>
                ';
            }
        }

        function a_r_sayısı($kulad,$ders,$vt){
            $sorgu3 = $vt->prepare("select * from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            while($sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum3["id"];
            }
            $sorgu = $vt->prepare("select * from rapor where ders='$id'");
            $sorgu->execute();
            echo $sorgu->rowCount();
        }

        function a_r_v_sayısı($kulad,$ders,$video,$vt){
            $sorgu3 = $vt->prepare("select * from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            while($sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum3["id"];
            }
            $sorgu = $vt->prepare("select * from rapor where ders='$id' and video='$video'");
            $sorgu->execute();
            echo $sorgu->rowCount();
            
        }

        function a_r_e_bilgi($kulad,$ders,$vt){
            $sorgu3 = $vt->prepare("select sahibi from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            $sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC);
            
                $sahibi=$sunucum3["sahibi"];
            
            $sorgu = $vt->prepare("select * from uye where kulad='$sahibi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kulad=$sunucum["kulad"];
                $mail=$sunucum["mail"];
                $seviye=$sunucum["seviye"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];
                echo '
                <h3 class="h5">Kullanıcı adı: '.$kulad.'</h3>
                <h3 class="h5">Kullanıcı mail: '.$mail.'</h3>
                <h3 class="h5">Kullanıcı seviye: '.$seviye.'</h3>
                <h3 class="h5">Kullanıcı hakkında: '.$hakkında.'</h3>
                <h3 class="h5">Kullanıcı linkedin: '.$linkedin.'</h3>
                <h3 class="h5">Kullanıcı github: '.$github.'</h3>
                ';
            }
        }

        function a_r_b_ders($kulad,$ders,$vt){
            $sorgu3 = $vt->prepare("select sahibi from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            $sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC);
            $sahibi=$sunucum3["sahibi"];
            $sorgu = $vt->prepare("select * from dersler where sahibi='$sahibi'");
            $sorgu->execute();
            echo $sorgu->rowCount();
        }

        function a_r_d_b($kulad,$ders,$vt){
            $sorgu3 = $vt->prepare("select sahibi from dersler where ders_adi='$ders'");
            $sorgu3->execute();
            $sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC);
            $sahibi=$sunucum3["sahibi"];
            $sorgu = $vt->prepare("select * from dersler where sahibi='$sahibi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kategori=$sunucum["kategori"];
                $sorgu2 = $vt->prepare("select * from altkategori where id='$kategori'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    $anakategori=$sunucum2["kategori"];
                    $altkategori=$sunucum2["altkategori"];
                }
                $id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                $fiyat=$sunucum["fiyat"];
                $hakkında=$sunucum["kayıtlı"];
                $linkedin=$sunucum["aciklama"];

                $sorgu4 = $vt->prepare("select * from rapor where ders='$id'");
                $sorgu4->execute();
                $sayi=$sorgu4->rowCount();
                
                echo '
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapse'.$id.'">
                            <h6 class="m-0 font-weight-bold text-success">'.$sunucum["ders_adi"].' </h6>
                            </a>
                        </div>
                        <div id="collapse'.$id.'" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                            <h3 class="h5">Ders rapor sayısı: '.$sayi.'</h3>
                            <h3 class="h5">Ders fiyatı: '.$sunucum["fiyat"].'</h3>
                            <h3 class="h5">Ders kategorisi: '.$anakategori.' | '.$altkategori.'</h3>
                            <h3 class="h5">Derse kayıtlı kişi sayısı: '.$sunucum["kayıtlı"].'</h3>
                            <h3 class="h5">Ders durumu: ';
                    if($sunucum["durum"]==1){
                        echo 'Yayında';
                    }
                    else{
                        echo 'Yayında değil';
                    }
                    echo '
                    </h3>
                            <h3 class="h5">Ders açıklaması: '.$sunucum["aciklama"].'</h3>
                            </div>
                        </div>
                    </div>
                ';

            }
        }

        function a_r_bilgi($kulad,$rapor,$vt){
            $sorgu = $vt->prepare("select * from rapor where id='$rapor'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $video=$sunucum["video"];
                $raporlayan=$sunucum["raporlayan"];
                $mesaj=$sunucum["rapor"];
                $görüldü=$sunucum["görüldü"];
                $zaman=$sunucum["zaman"];
                echo '
                <h3 class="h5">Video: '.$video.'</h3>
                <h3 class="h5">Raporlayan kullanıcı: '.$raporlayan.'</h3>
                <h3 class="h5">Rapor sebebi: '.$mesaj.'</h3>
                <h3 class="h5">Rapor durumu: ';
                if($görüldü==0){
                    echo 'İncelenmedi';
                }
                else{
                    echo 'İncelendi';
                }
                    
                echo
                '</h3>
                <h3 class="h5">Rapor Tarihi: '.$zaman.'</h3>
                ';
            }
        }

        function d_uygun($kulad,$rapor,$vt){
            $guncelle=$vt->prepare("update rapor set görüldü='1'WHERE id='$rapor'");
            $guncelle->execute();
            $guncelle2=$vt->prepare("update rapor set admin='$kulad'WHERE id='$rapor'");
            $guncelle2->execute();
            
        }

        function d_uyarı($kulad,$rapor,$ders,$video,$vt){
            $sorgu = $vt->prepare("select id from dersler where ders_adi='$ders'");
            $sorgu->execute();
            $sunucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            $id=$sunucum["id"];
            $sorgu2 = $vt->prepare("select uyarı from ders$id where video_adi='$video'");
            $sorgu2->execute();
            $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
            $uyarı=$sunucum2["uyarı"];
            $uyarı=$uyarı+1;

            $guncelle=$vt->prepare("update ders$id set uyarı='$uyarı' WHERE video_adi='$video'");
            $guncelle->execute();

            $guncelle2=$vt->prepare("update rapor set görüldü='1'WHERE id='$rapor'");
            $guncelle2->execute();

            $guncelle3=$vt->prepare("update rapor set admin='$kulad'WHERE id='$rapor'");
            $guncelle3->execute();
        }

        function d_v_y_kaldır($kulad,$rapor,$ders,$video,$vt){
            $sorgu = $vt->prepare("select id from dersler where ders_adi='$ders'");
            $sorgu->execute();
            $sunucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            $id=$sunucum["id"];

            $guncelle=$vt->prepare("update ders$id set durum='0' WHERE video_adi='$video'");
            $guncelle->execute();

            $guncelle2=$vt->prepare("update rapor set görüldü='1'WHERE id='$rapor'");
            $guncelle2->execute();

            $guncelle3=$vt->prepare("update rapor set admin='$kulad'WHERE id='$rapor'");
            $guncelle3->execute();
        }

        function r_e_mesaj($kulad,$rapor,$ders,$mesaj,$vt){
            $sorgu = $vt->prepare("select * from dersler where ders_adi='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum["id"];
                $sahibi=$sunucum["sahibi"];
                $bildir=$vt->prepare("insert into h_bildirim (id,alıcı,gonderen,ders,mesaj,okundu) values (NULL,'$sahibi','ADMİN','$ders','$mesaj','0')");
                $bildir->execute();
                $bildir=$vt->prepare("insert into bildirim (id,alıcı,gönderen,baslik,ders,mesaj,okundu) values (NULL,'$sahibi','ADMİN','Bilgilendirme','$ders','$mesaj','0')");
                $bildir->execute();
            }
        }

        function r_r_mesaj($kulad,$rapor,$mesaj,$vt){
            $sorgu = $vt->prepare("select * from rapor where id='$rapor'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders=$sunucum["ders"];
                $video=$sunucum["video"];
                $raporlayan=$sunucum["raporlayan"];

                $sorgu2 = $vt->prepare("select ders_adi from dersler where id='$ders'");
                $sorgu2->execute();
                $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $ders_adi=$sunucum2["ders_adi"];
                $bildir=$vt->prepare("insert into bildirim (id,alıcı,gönderen,baslik,ders,mesaj,okundu) values (NULL,'$raporlayan','Yetkili','$video raporunuz için bilgilendirme','$ders_adi','$mesaj','0')");
                $bildir->execute();
            }

        }

        function s_gor($kulad,$vt){
            $sorgu=$vt->prepare("select seviye from uye where kulad='$kulad'");
            $sorgu->execute();
            $seviye=$sorgu->fetch(PDO::FETCH_ASSOC);
            
            if($seviye["seviye"]=="Öğrenci" ):{
                echo '
                        <li><a class="dropdown-item" href="sorular">Sorularım</a></li>
                        <li><hr class="dropdown-divider"></li>
                    ';
            }
            endif;
        }

        function o_s_sil($kulad,$gonderen,$vt){
            $sorgu=$vt->prepare("select id from ders_soru where alıcı='$kulad' and gönderen='$gonderen' or gönderen='$kulad' and alıcı='$gonderen'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum["id"];
                $guncelle=$vt->prepare("update ders_soru set ö_durum='1' WHERE id='$id'");
                $guncelle->execute();
            }
        }

        function o_s_oku($kulad,$gonderen,$vt){
            $sorgu=$vt->prepare("select id from ders_soru where alıcı='$kulad' and gönderen='$gonderen' or gönderen='$kulad' and alıcı='$gonderen'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum["id"];
                $guncelle=$vt->prepare("update ders_soru set ö_okundu='1' WHERE id='$id'");
                $guncelle->execute();
            }
        }

        function o_s_sor($kulad,$gonderen,$soru,$vt){
            $ekle = $vt->prepare("insert into ders_soru (gönderen,alıcı,mesaj) values ('$kulad','$gonderen','$soru')");
            $ekle->execute();
        }

        function a_r_k_bilgi($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from uye where id='$id'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kulad=$sunucum["kulad"];
                $mail=$sunucum["mail"];
                $seviye=$sunucum["seviye"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];
                echo '
                <h3 class="h5">Kullanıcı adı: '.$kulad.'</h3>
                <h3 class="h5">Kullanıcı mail: '.$mail.'</h3>
                <h3 class="h5">Kullanıcı seviye: '.$seviye.'</h3>
                <h3 class="h5">Kullanıcı hakkında: '.$hakkında.'</h3>
                <h3 class="h5">Kullanıcı linkedin: '.$linkedin.'</h3>
                <h3 class="h5">Kullanıcı github: '.$github.'</h3>
                ';
            }
        }

        function a_r_k_d_b($kulad,$id,$vt){
            $sorguad = $vt->prepare("select kulad from uye where id='$id'");
            $sorguad->execute();
            $sunucumad=$sorguad->fetch(PDO::FETCH_ASSOC);
            $k_ad=$sunucumad["kulad"];

            $sorgu = $vt->prepare("select * from alınan where alan='$k_ad'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders_id=$sunucum["ders"];
                $sorgu2 = $vt->prepare("select ders_adi from dersler where id='$ders_id'");
                $sorgu2->execute();
                $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $d_adi=$sunucum2["ders_adi"];
                $izlenen=self::k_d_takip($k_ad,$ders_id,$vt);
                echo '
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapse'.$ders_id.'">
                                <h6 class="m-0 font-weight-bold text-success">'.$d_adi.' </h6>
                            </a>
                        </div>
                        <div id="collapse'.$ders_id.'" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <h3 class="h5">Ders ilerlemesi: 
                                    <div class="progress  mb-2" style="width:96%; height:22px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark p-1" role="progressbar" aria-valuenow="'.$izlenen.'" aria-valuemin="0" aria-valuemax="100" style=" width:'.$izlenen.'%">Tamamlanan: %'.$izlenen.'</div>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        function a_r_v_d_b($kulad,$id,$vt){
            $sorguad = $vt->prepare("select kulad from uye where id='$id'");
            $sorguad->execute();
            $sunucumad=$sorguad->fetch(PDO::FETCH_ASSOC);
            $k_ad=$sunucumad["kulad"];

            $sorgu = $vt->prepare("select * from dersler where sahibi='$k_ad'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders_id=$sunucum["id"];
                $d_adi=$sunucum["ders_adi"];
                $kayıtlı=$sunucum["kayıtlı"];
                $sorgu2 = $vt->prepare("select * from ders$ders_id where durum='1'");
                $sorgu2->execute();
                $v_sayisi=$sorgu2->rowCount();
                $izlenen=self::k_d_takip($k_ad,$ders_id,$vt);
                echo '
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapse'.$ders_id.'x">
                                <h6 class="m-0 font-weight-bold text-success">'.$d_adi.' </h6>
                            </a>
                        </div>
                        <div id="collapse'.$ders_id.'x" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <h3 class="h5">Kayıtlı kullanıcı: '.$kayıtlı.' 
                                    <a href="?sayfa=alanlar&id='.$ders_id.'" class="btn btn-success btn-circle btn-sm">
                                        <i class="fas fa-list-ul"></i>
                                    </a></h3>
                                <h3 class="h5">Video sayısı: '.$v_sayisi.'</h3>
                                <h3 class="h5">Uyarı sayısı: '.$sunucum["uyarı"].'</h3>
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        function d_a_kullanıcılar($id,$vt){
            $sorgu = $vt->prepare("select alan from alınan where ders='$id'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $k_ad=$sunucum["alan"];
                $sorgu2 = $vt->prepare("select id from uye where kulad='$k_ad'");
                $sorgu2->execute();
                $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $kisi_id=$sunucum2["id"];
                $izlenen=self::k_d_takip($k_ad,$id,$vt);
                echo '
                    <tr>
                        <td>'.$k_ad.'</td>
                        <td>
                        <div class="progress  mb-2" style="width:96%; height:22px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark p-1" role="progressbar" aria-valuenow="'.$izlenen.'" aria-valuemin="0" aria-valuemax="100" style=" width:'.$izlenen.'%">Tamamlanan: %'.$izlenen.'</div>
                        </div>
                        </td>
                        <td><a class="btn btn-outline-dark btn-sm" href="index?sayfa=kullanıcı_ayar&id='.$kisi_id.'">Kullanıcıyı Gör</a></td>
                    </tr>
                ';
            }
        }

        function a_k_yetkili($kisi,$vt){
            $sorgu = $vt->prepare("update uye set seviye='Yonetici' WHERE id='$kisi'");
            $sorgu->execute();
        }

        function a_k_yetkial($kisi,$vt){
            $sorgu = $vt->prepare("update uye set seviye='Eğitmen' WHERE id='$kisi'");
            $sorgu->execute();
        }

        function a_k_mesaj($kulad,$kisi,$mesaj,$vt){
            $sorgu = $vt->prepare("select * from uye where id='$kisi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $k_ad=$sunucum["kulad"];
            }
            
            $bildir=$vt->prepare("insert into bildirim (id,alıcı,gönderen,baslik,ders,mesaj,okundu) values (NULL,'$k_ad','Yetkili','Kişiye özel mesaj','Yetkili','$mesaj','0')");
            $bildir->execute();
        }
        
        function a_k_banla($kulad,$kisi,$vt){
                $sorgu = $vt->prepare("update uye set durum='1' WHERE id='$kisi'");
                $sorgu->execute();
        }

        function a_k_b_durum($kulad,$id,$vt){
            $sorgu = $vt->prepare("select durum from uye where id='$id'");
            $sorgu->execute();
            $sunucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            $durum=$sunucum["durum"];
            if($durum==1)
            {
                echo '  |  Durumu: Kullanıcı Banlı  |';
            }
        }

        function user_info($kisi,$vt){
            $sorgu = $vt->prepare("select * from uye where kulad='$kisi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $tamad=$sunucum["tamad"];
                $mail=$sunucum["mail"];
                $seviye=$sunucum["seviye"];
                $resim=$sunucum["resim"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];
                echo '
                    <div class="container">
                        <div class="main-body">
                            <div class="row ">
                              <div class="col-md-4">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="d-flex flex-column align-items-center ">
                                    ';
                                    if($resim!=NULL)
                                    {
                                        echo '
                                            <img src="'.$resim.'" alt="Admin" class="rounded-circle" width="150">
                                        ';
                                    }
                                    else{
                                        echo '
                                            <img src="yonetim/dist/img/boxed-bg.jpg" alt="Admin" class="rounded-circle" width="150">
                                        ';
                                    }
                                    
                                    echo '
                                      <div class="mt-3">
                                        <h4>'.$tamad.'</h4>
                                        <p class="text-secondary mb-1  text-center ">'.$seviye.'</p>
                                        <p class="text-muted font-size-sm  text-center ">'.$hakkında.'</p>
                                        <div class="d-flex text-center align-items-center flex-wrap ">
                                            <h6 class=" ml-2"><a class="text-secondary p-4" href="'.$linkedin.'"><i class="fab fa-linkedin-in"></i></a></h6>
                                            <h6 class=" ml-2"><a class="text-secondary p-4" href="'.$github.'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg></a></h6>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="card mb-3">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-3">
                                        <h6 class="mb-0">Tam Ad</h6>
                                      </div>
                                      <div class="col-sm-9 text-secondary">
                                        '.$tamad.'
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                      </div>
                                      <div class="col-sm-9 text-secondary">
                                        '.$mail.'
                                      </div>
                                    </div>
                                  </div>
                                </div>';

                                if($seviye='Eğitmen')
                                {
                                    echo '
                                    <div class="row ">
                                    <div class=" mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3">Verdiği Dersler</h6>
                                                    <div class="row">
                                ';

                                                $sorgu2 = $vt->prepare("select * from dersler where sahibi='$kisi'");
                                                $sorgu2->execute();
                                                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
                                                {
                                                        $d_id=$sunucum2["id"];
                                                        $ders_adi=$sunucum2["ders_adi"];
                                                        $kategori=$sunucum2["kategori"];
                                                        $aciklama=$sunucum2["aciklama"];
                                                        $sorgu3 = $vt->prepare("select altkategori from altkategori where id='$kategori'");
                                                        $sorgu3->execute();
                                                        $sunucum3=$sorgu3->fetch(PDO::FETCH_ASSOC);
                                                        $altkategori=$sunucum3["altkategori"];
                                                        echo '
                                                        
                                                        <div class="col-sm-6">
                                                          <div class="card">
                                                            <div class="card-body">
                                                              <h5 class="card-title">Ders Adı: '.$ders_adi.'</h5>
                                                              <p class="card-text">'.$altkategori.'</p>
                                                              <p class="card-text">'.$aciklama.'</p>
                                                              <a href="ders?id='.$d_id.'" class="btn btn-dark">Gör</a>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        ';
                                                }
                                        echo'
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                    ';
                                }
                            echo'
                              </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        function user_set($kisi,$vt){

            $sorgu = $vt->prepare("select * from uye where kulad='$kisi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $tamad=$sunucum["tamad"];
                $mail=$sunucum["mail"];
                $seviye=$sunucum["seviye"];
                $resim=$sunucum["resim"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];

                echo '
                    <div class="container">
                        <div class="main-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">';
                                            if($resim!=NULL)
                                            {
                                                echo '
                                                    <img src="'.$resim.'" alt="Admin" class="rounded-circle" width="150">
                                                ';
                                            }
                                            else{
                                                echo '
                                                    <img src="yonetim/dist/img/boxed-bg.jpg" alt="Admin" class="rounded-circle" width="150">
                                                ';
                                            }
                                            
                                            echo '
                                                <div class="mt-3">
                                                    <h4>'.$tamad.'</h4>
                                                    <p class="text-secondary mb-1  text-center ">'.$seviye.'</p>
                                                    <p class="text-muted font-size-sm  text-center ">'.$hakkında.'</p>
                                                  
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                            <ul class="list-group list-group-flush">
                                                
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github me-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                                                    <span class="text-secondary">'.$github.'</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0 ml-2"><i class="fab fa-linkedin-in"></i> Linkedin</h6>
                                                    <span class="text-secondary">'.$linkedin.'</span>
                                                </li>
                                              
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Tam Ad</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_a_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="metin" required value="'.$tamad.'" aria-describedby="ad">
                                                            <button class="btn btn-outline-dark" type="submit" id="ad">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Email</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_m_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">    
                                                            <input type="mail" class="form-control"  name="metin" required value="'.$mail.'" aria-describedby="mail">
                                                            <button class="btn btn-outline-dark" type="submit" id="mail">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Şifre</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_s_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">
                                                            <input type="password" name="metin" required class="form-control" aria-describedby="sifre">
                                                            <button class="btn btn-outline-dark" type="submit" id="sifre">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Github</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_g_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">    
                                                            <input type="mail" class="form-control"  name="metin" required value="'.$github.'" aria-describedby="mail">
                                                            <button class="btn btn-outline-dark" type="submit" id="mail">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Linkedin</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_l_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">    
                                                            <input type="mail" class="form-control"  name="metin" required value="'.$linkedin.'" aria-describedby="mail">
                                                            <button class="btn btn-outline-dark" type="submit" id="mail">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Hakkında</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=k_h_degis" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">    
                                                            <textarea style="resize:none;" class="form-control" name="metin" required aria-describedby="mail" value="'.$hakkında.'"></textarea>
                                                            <button class="btn btn-outline-dark" type="submit" id="mail">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Profil Resmi</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <form action="yonlendir.php?sayfa=resim_ekle" method="post" enctype="multipart/form-data">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" name="resim" required id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                            <button class="btn btn-outline-dark" type="submit" name="SubmiteFile" id="inputGroupFileAddon04">Kaydet</button>
                                                        </div>
                                                    </form>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        function resim_ekle($kulad,$vt){
            if(isset($_POST["SubmiteFile"])){
                $Orgname      = $_FILES["resim"]["name"];
                $ImageType    = $_FILES["resim"]["type"];
                $ImageSize    = $_FILES["resim"]["size"];
                $TmpName      = $_FILES["resim"]["tmp_name"];
                $ImageError   = $_FILES["resim"]["error"];
                $UploadFolder = "resim/";
                $v_name       = $kulad;
    
                $MaxSize      = 1024*1024*1000;
                $FileExt      = substr($_FILES["resim"]["name"],-4,4);

                $NewFileName  = $UploadFolder.$v_name.$FileExt;
                $degis = $vt->prepare("update uye set resim='$NewFileName' where kulad='$kulad'");
                $degis->execute();

                if($_FILES["resim"]["size"]> $MaxSize)
                {
                    echo "Dosya boyutu en fazla 100MB olabilir!";
                }
                else
                {
                    $file=$_FILES["resim"]["type"];
                   
                    if(is_uploaded_file($TmpName))
                    {
                        $move = move_uploaded_file($TmpName,$NewFileName);
                        if($move){
                            echo "Dosya yükleme işlemi başarılı";
                        }
                        else
                        {
                            echo "hata var";
                        }
                    }  
                }
            }
        }

        function user_yetki($kulad,$vt){
            $sorgu= $vt->prepare("select seviye from uye where kulad='$kulad'");
            $sorgu->execute();
            $sunucum=$sorgu->fetch(PDO::FETCH_ASSOC);
            if($sunucum["seviye"]=='Öğrenci'){
                echo '<a class="nav-link" href="yonlendir?sayfa=k_y_degis">Eğitmen Ol</a>';
            }
           
        }

        function d_s_bilgi($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$id'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders_adi=$sunucum["ders_adi"];
                $sahibi=$sunucum["sahibi"];
                $fiyat=$sunucum["fiyat"];
                $kategori=$sunucum["kategori"];
                $kayıtlı=$sunucum["kayıtlı"];
                $aciklama=$sunucum["aciklama"];
                $sorgu2 = $vt->prepare("select altkategori from altkategori where id='$kategori'");
                $sorgu2->execute();
                $sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC);
                $altkategori=$sunucum2["altkategori"];
                echo'
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center ">';
                            if($fiyat!=0){
                                echo '
                                    <div class="mt-3">
                                        <h4 class="text-center" >'.$ders_adi.'</h4>
                                        <p class="text-secondary mb-1 text-center ">Kategorisi: '.$altkategori.'</p>
                                        <p class="text-secondary mb-1 text-center ">Derse kayıtlı kullanıcı: '.$kayıtlı.'</p>
                                        <p class="text-secondary mb-1 text-center ">Ders açıklaması: '.$aciklama.'</p>
                                    </div>
                                ';
                                $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);
                                if($cevap==0){
                                    echo '
                                        <a class="btn btn-outline-dark" href="ödeme?id='.$sunucum["id"].'" role="button">Satın al:  '.$fiyat.'<i class="fas fa-lira-sign fa-sm"></i></a>
                                    ';
                                }
                            }
                            else{
                                echo '
                                    <div class="mt-3">
                                        <h4 class="text-center" >'.$ders_adi.'</h4>
                                        <p class="text-secondary mb-1 text-center ">Fiyatı: '.$fiyat.'</p>
                                        <p class="text-secondary mb-1 text-center ">Kategorisi: '.$altkategori.'</p>
                                        <p class="text-secondary mb-1 text-center ">Derse kayıtlı kullanıcı: '.$kayıtlı.'</p>
                                        <p class="text-secondary mb-1 text-center ">Ders açıklaması: '.$aciklama.'</p>
                                    </div>
                                ';
                                $cevap=self::d_kontrol($kulad,$sunucum["id"],$vt);
                                if($cevap==0){
                                    echo '
                                        <a class="btn btn-outline-dark" href="ders?id='.$sunucum["id"].'&sayfa=basla" role="button">Derse Kaydol</a>
                                    ';
                                }
                              }
                             
                            echo '
                            </div>
                        </div>
                    </div>
            ';
            }
            $sorgu2 = $vt->prepare("select * from uye where kulad='$sahibi'");
            $sorgu2->execute();
            while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
            {
                $tamad=$sunucum2["tamad"];
                $hakkında=$sunucum2["hakkında"];
                $resim=$sunucum2["resim"];
                echo'
                    <div class="card mt-3">
                        <div class="card-body">
                          <div class="d-flex flex-column align-items-center ">
                            <div class="mt-3">
                            ';

                                if($resim!=NULL)
                                    {
                                        echo '
                                        <div class="d-flex flex-column align-items-center ">
                                            <img src="'.$resim.'" alt="Admin" class="rounded-circle" width="150">
                                            </div>
                                        ';
                                    }

                                echo'
                                <h4 class="text-center" >Eğitmen</h4>
                                
                                <h4 class="h5 text-center" >'.$tamad.'</h4>
                                ';
                                if($hakkında!=NULL)
                                {
                                    echo '
                                        <p class="text-secondary mb-1 text-center ">'.$hakkında.'</p>
                                    ';
                                }
                                echo '
                            </div>
                          </div>
                        </div>
                    </div>
            ';
            }
            echo'
                <div class="card border col-md-12 mt-2" >
                    <div class="card-header text-center">
                        <h5 class="card-title"> Ders puanı: '; echo self::ders_puanı_ort($id,$vt);
                        echo '
                        </h5>
                    </div>
                    <div class="card-body text-dark">
                       ';
                        $sorgu2=$vt->prepare("select * from yorumlar where ders='$id' AND puan >=3 ORDER BY RAND() LIMIT 3");
                        $sorgu2->execute();
                        while($sonuc2=$sorgu2->fetch(PDO::FETCH_ASSOC)):
                            $y_id=$sonuc2["id"];
                            $yorum_yapan=$sonuc2["yorum_yapan"];
                            $yorum=$sonuc2["yorum"];
                            $puan=$sonuc2["puan"];
                            $begeni=$sonuc2["begeni"];
                            $dislike=$sonuc2["dislike"];
                            $tarih=$sonuc2["tarih"];
                            $i=0;
                            $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                            $sorgu4->execute();
                            while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                $kisi=$sonuc4["tamad"];
                            }

                            echo '
                                <div class="card border-0 shadow mb-3">
                                    <div class="card-body">
                                        <span class="rate-yellow">
                                        ';
                                        while($i!=5)
                                        {
                                            if($i<$puan)
                                            {
                                                echo '<small for="star1" class="bi bi-star-fill"></small>';

                                            }
                                            else{
                                                echo'<small for="star5" class="bi bi-star"></small>';
                                            }
                                            $i++;
                                        }

                                        echo '
                                        </span>
                                        <p>'.$yorum.' </p>
                                        <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                        <ul class="list-inline fs-5">
                                            <li class="list-inline-item me-4">
                                                <i class="bi bi-hand-thumbs-up"></i> '.$begeni.'
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="bi bi-hand-thumbs-down"></i> '.$dislike.'
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            ';
                                    
                        endwhile;

                        $sorgu3=$vt->prepare("select * from yorumlar where ders='$id' AND puan <3 ORDER BY RAND() LIMIT 2");
                        $sorgu3->execute();
                        while($sonuc3=$sorgu3->fetch(PDO::FETCH_ASSOC)):
                            $y_id=$sonuc3["id"];
                            $yorum_yapan=$sonuc3["yorum_yapan"];
                            $yorum=$sonuc3["yorum"];
                            $puan=$sonuc3["puan"];
                            $begeni=$sonuc3["begeni"];
                            $dislike=$sonuc3["dislike"];
                            $tarih=$sonuc3["tarih"];
                            $i=0;
                            $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                            $sorgu4->execute();
                            while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                $kisi=$sonuc4["tamad"];
                            }


                            echo '
                                <div class="card border-0 shadow mb-3">
                                    <div class="card-body">
                                        <span class="rate-yellow">
                                        ';
                                        while($i!=5)
                                        {
                                            if($i<$puan)
                                            {
                                                echo '<small for="star1" class="bi bi-star-fill"></small>';

                                            }
                                            else{
                                                echo'<small for="star5" class="bi bi-star"></small>';
                                            }
                                            $i++;
                                        }

                                        echo '
                                        </span>
                                        <p>'.$yorum.' </p>
                                        <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                        <ul class="list-inline fs-5">
                                            <li class="list-inline-item me-4">
                                                <a href="yonlendir?sayfa=yorum_b_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-up"></i></a> '.$begeni.'
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="yonlendir?sayfa=yorum_d_a&ders='.$id.'&id='.$y_id.'"><i class="bi bi-hand-thumbs-down"></i></a> '.$dislike.'
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            ';
                                    
                        endwhile;

                    echo '
                    </div>
                </div>
            ';

        }

        function d_s_dersler($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from ders$id order by sira");
            $sorgu->execute();
            $v_sayisi=$sorgu->RowCount();

            echo'
            <div class="content d-flexflex-wrap">
            <div class="list bg-white py-3">
                <div class="row m-0 px-2 pb-1 border-bottom">
                    <div class="col-lg-6 d-flex align-items-center flex-wrap">
                        <div class="title mx-lg-2 mx-1">Ders Videoları </div>
                        <div class="pink-label mx-1">| '.$v_sayisi.' Video</div>
                    </div>
                </div>
            ';
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $video_adi=$sunucum["video_adi"];
                $aciklama=$sunucum["aciklama"];
                $sira=$sunucum["sira"];

                echo '
                
                    <div class="table-responsive-lg mx-3">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">'.$sira.'</th>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fs-08">'.$aciklama.'</div>
                                        </div>
                                    </td>
                                   
                                    <td>';
                                    if($sira!=0)
                                    {
                                        echo'
                                            <div class="d-flex flex-column text-end">
                                                <div class="fas fa-eye blue-label"><a class="text-dark" href="video?id='.$id.'&video='.$video_adi.'&1=1"> Dersi Gör</a></div>
                                            </div>
                                        ';
                                    }   
                                    else{
                                        echo'
                                            <div class="d-flex flex-column text-end">
                                                <div class="fas fa-eye blue-label"><a class="text-dark" href="video?id='.$id.'&video='.$video_adi.'"> Dersi Gör</a></div>
                                            </div>
                                        ';
                                    }
                                    echo '
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
              
                ';
            }
            echo '
                </div>
            </div>
            ';
        }

        function d_k_dersler($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from ders$id order by sira");
            $sorgu->execute();
            $v_sayisi=$sorgu->RowCount();

            echo'
            <div class="content d-flexflex-wrap">
            <div class="list bg-white py-3">
                <div class="row m-0 px-2 pb-1 border-bottom">
                    <div class="col-lg-6 d-flex align-items-center flex-wrap">
                        <div class="title mx-lg-2 mx-1">Ders Videoları </div>
                        <div class="pink-label mx-1">| '.$v_sayisi.' Video</div>
                    </div>
                </div>
            ';
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $video_adi=$sunucum["video_adi"];
                $aciklama=$sunucum["aciklama"];
                $sira=$sunucum["sira"];

                echo '
                
                    <div class="table-responsive-lg mx-3">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">'.$sira.'</th>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fs-08">'.$aciklama.'</div>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="d-flex flex-column text-end">
                                        ';
                                            if($sira==0)
                                            {
                                                echo '
                                                    <div class="fas fa-eye blue-label"><a class="text-dark" href="ders_tanıtım?id='.$id.'"> Dersi Gör</a></div>
                                                ';
                                            }
                                            else{
                                                echo '
                                                    <div class="fas fa-eye blue-label"><a class="text-dark" href="ders?id='.$id.'&sayfa=kaydol"> Dersi Gör</a></div>
                                                ';
                                            }
                                                
                                            echo '
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
              
                ';
            }
            echo '
                </div>
            </div>
            ';
        }

        function t_ders($vt){
            $sorgu = $vt->prepare("select * from dersler");
            $sorgu->execute();
            $v_sayisi=$sorgu->RowCount();
            echo $v_sayisi;
        }

        function t_uye($vt){
            $sorgu = $vt->prepare("select * from uye");
            $sorgu->execute();
            $v_sayisi=$sorgu->RowCount();
            echo $v_sayisi;
        }

        function t_egitimci($vt){
            $sorgu = $vt->prepare("select * from uye where seviye='Eğitmen'");
            $sorgu->execute();
            $v_sayisi=$sorgu->RowCount();
            echo $v_sayisi;
        }

        function a_d_bilgi($kulad,$ders,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kategori=$sunucum["kategori"];
                $sorgu2 = $vt->prepare("select * from altkategori where id='$kategori'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    $anakategori=$sunucum2["kategori"];
                    $altkategori=$sunucum2["altkategori"];
                }
                $sorgu3 = $vt->prepare("select * from rapor where ders='$ders'");
                $sorgu3->execute();
                $rapor=$sorgu3->RowCount();
                echo '
                    <h3 class="h5">Ders adı: '.$sunucum["ders_adi"].'</h3>
                    <h3 class="h5">Ders sahibi: '.$sunucum["sahibi"].'</h3>
                    <h3 class="h5">Ders fiyatı: '.$sunucum["fiyat"].'</h3>
                    <h3 class="h5">Ders kategorisi: '.$anakategori.' | '.$altkategori.'</h3>
                    <h3 class="h5">Derse kayıtlı kişi sayısı: '.$sunucum["kayıtlı"].'</h3>
                    <h3 class="h5">Ders durumu: ';
                    if($sunucum["durum"]==1){
                        echo 'Yayında';
                    }
                    else{
                        echo 'Yayında değil';
                    }
                    echo '
                    </h3>
                    <h3 class="h5">Ders açıklaması: '.$sunucum["aciklama"].'</h3>
                    <h3 class="h5">Rapor Sayısı: '.$rapor.'</h3>
                ';
            }
        }

        function d_t_bilgi($id,$vt){
            $çek = $vt->prepare("select * from dersler where id='$id'");
            $çek->execute();
            while($sorgucek=$çek->fetch(PDO::FETCH_ASSOC)):
                $ders_adi=$sorgucek["ders_adi"];
                $aciklama=$sorgucek["aciklama"];
                $sahibi=$sorgucek["sahibi"];
                $puan=self::ders_puanı_ort($id,$vt);
                $sorgu=$vt->prepare("select * from uye where kulad='$sahibi'");
                $sorgu->execute();
                while($sonuc=$sorgu->fetch(PDO::FETCH_ASSOC)):
                    $hakkında=$sonuc["hakkında"];
                    $linkedin=$sonuc["linkedin"];
                    $github=$sonuc["github"];
                endwhile;
                echo '
                <div class="shadow p-3 mb-5 bg-white rounded-bottom">
                
                        <nav>
                                
                            <div class="nav nav-tabs container-fluid" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Ders Hakkında</button>
                            </div>
                            
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header text-center"><h5 class="card-title">'.$ders_adi.'</h5></div>
                                                <div class="card-body text-dark">
                                                    <p class="card-text">'.$aciklama.'</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="card border col-md-12 mt-2" >
                                                <div class="card-header text-center"><h5 class="card-title"> Ders puanı: '; echo self::ders_puanı_ort($id,$vt);
                                                
                                                echo '</h5>
                                                </div>
                                                <div class="card-body text-dark">';

                                                                $sorgu2=$vt->prepare("select * from yorumlar where ders='$id' AND puan >=3 ORDER BY RAND() LIMIT 3");
                                                                $sorgu2->execute();
                                                                while($sonuc2=$sorgu2->fetch(PDO::FETCH_ASSOC)):
                                                                    $y_id=$sonuc2["id"];
                                                                    $yorum_yapan=$sonuc2["yorum_yapan"];
                                                                    $yorum=$sonuc2["yorum"];
                                                                    $puan=$sonuc2["puan"];
                                                                    $begeni=$sonuc2["begeni"];
                                                                    $dislike=$sonuc2["dislike"];
                                                                    $tarih=$sonuc2["tarih"];
                                                                    $i=0;
                                                                    $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                                                                    $sorgu4->execute();
                                                                    while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                                                        $kisi=$sonuc4["tamad"];
                                                                    }

                                                                    echo '
                                                                        <div class="card border-0 shadow mb-3">
                                                                            <div class="card-body">
                                                                                <span class="rate-yellow">
                                                                                ';
                                                                                while($i!=5)
                                                                                {
                                                                                    if($i<$puan)
                                                                                    {
                                                                                        echo '<small for="star1" class="bi bi-star-fill"></small>';
                                                                                        
                                                                                    }
                                                                                    else{
                                                                                        echo'<small for="star5" class="bi bi-star"></small>';
                                                                                    }
                                                                                    $i++;
                                                                                }
                                                                                    
                                                                                echo '
                                                                                </span>
                                                                                <p>'.$yorum.' </p>
                                                                                <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                                                                <ul class="list-inline fs-5">
                                                                                    <li class="list-inline-item me-4">
                                                                                        <a><i class="bi bi-hand-thumbs-up"></i></a> '.$begeni.'
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <a><i class="bi bi-hand-thumbs-down"></i></a> '.$dislike.'
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                    
                                                                endwhile;

                                                                $sorgu3=$vt->prepare("select * from yorumlar where ders='$id' AND puan <3 ORDER BY RAND() LIMIT 2");
                                                                $sorgu3->execute();
                                                                while($sonuc3=$sorgu3->fetch(PDO::FETCH_ASSOC)):
                                                                    $y_id=$sonuc3["id"];
                                                                    $yorum_yapan=$sonuc3["yorum_yapan"];
                                                                    $yorum=$sonuc3["yorum"];
                                                                    $puan=$sonuc3["puan"];
                                                                    $begeni=$sonuc3["begeni"];
                                                                    $dislike=$sonuc3["dislike"];
                                                                    $tarih=$sonuc3["tarih"];
                                                                    $i=0;
                                                                    $sorgu4=$vt->prepare("select * from uye where kulad='$yorum_yapan'");
                                                                    $sorgu4->execute();
                                                                    while($sonuc4=$sorgu4->fetch(PDO::FETCH_ASSOC)){
                                                                        $kisi=$sonuc4["tamad"];
                                                                    }


                                                                    echo '
                                                                        <div class="card border-0 shadow mb-3">
                                                                            <div class="card-body">
                                                                                <span class="rate-yellow">
                                                                                ';
                                                                                while($i!=5)
                                                                                {
                                                                                    if($i<$puan)
                                                                                    {
                                                                                        echo '<small for="star1" class="bi bi-star-fill"></small>';
                                                                                        
                                                                                    }
                                                                                    else{
                                                                                        echo'<small for="star5" class="bi bi-star"></small>';
                                                                                    }
                                                                                    $i++;
                                                                                }
                                                                                    
                                                                                echo '
                                                                                </span>
                                                                                <p>'.$yorum.' </p>
                                                                                <div class="text-muted fs-6 mb-3">'.$kisi.' , '.$tarih.'</div>
                                                                                <ul class="list-inline fs-5">
                                                                                    <li class="list-inline-item me-4">
                                                                                        <a><i class="bi bi-hand-thumbs-up"></i></a> '.$begeni.'
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <a><i class="bi bi-hand-thumbs-down"></i></a> '.$dislike.'
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                    
                                                                endwhile;

                                                            echo '
                                                </div>
                                            </div>
                                        </div>            
                                    </div>
                                </div>     
                            </div>
                        </div>  
                </div>
                ';
            endwhile;
        }

        function d_t_liste($ders,$vt){
            $sorgu = $vt->prepare("select * from ders$ders where sira != '0'");
            $sorgu ->execute();
            
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $kaynak = $sunucum["kaynak"];
                $v_adi=$sunucum["video_adi"];
                echo '
                    
                    <div class="card mb-2" style="max-width: 420px; height:100px;">
                        <div class="row g-0">
                            <div class="col-md-3">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="100px" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["sira"].'</text></svg>
                            </div>
                            <div class="col-md-9">
                            <div class="card-body">
                            
                                <div class="form-check form-switch">
                               
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckdisabled">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <h5 class="card-title"><a class="dropdown-item" href="ders_tanıtım?id='.$ders.'&sayfa=kayıt" class="yazı"> <bold>'.$sunucum["aciklama"].'</bold></a></h5>
                                        </label>
                               
                                </div>
                            </div>
                        </div>
                    </div>       
                ';
            endwhile;       
        }

        function t_liste($ders,$vt){
            $sorgu = $vt->prepare("select * from ders$ders where sira != '0'");
            $sorgu ->execute();
            
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $kaynak = $sunucum["kaynak"];
                $v_adi=$sunucum["video_adi"];
                echo '
                    
                    <div class="card mb-2" style="max-width: 420px; height:100px;">
                        <div class="row g-0">
                            <div class="col-md-3">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="100px" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: deneme" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#212529"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$sunucum["sira"].'</text></svg>
                            </div>
                            <div class="col-md-9">
                            <div class="card-body">
                            
                                <div class="form-check form-switch">
                               
                                        <input class="form-check-input" type="checkbox" value="" id="flexSwitchCheckDisabled">
                                        <label class="form-check-label" for="flexSwitchCheckDisabled">
                                            <h5 class="card-title"><a class="dropdown-item" href="tanıtım?id='.$ders.'&sayfa=kayıt" class="yazı"> <bold>'.$sunucum["aciklama"].'</bold></a></h5>
                                        </label>
                               
                                </div>
                            </div>
                        </div>
                    </div>       
                ';
            endwhile;       
        }
        
        function d_t_video($ders,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)):
                $sorgu2 = $vt->prepare("select * from ders$ders where sira='0'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    echo '
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="dersler/'.$sunucum["id"].'/'.$sunucum2["video_adi"].'"></iframe>
                        </div>
                    ';
                }
               
            endwhile;
        }

        function yorum_ekle($kulad,$id,$metin,$rating,$vt){
            $dersler = $vt->prepare("insert into yorumlar (ders,yorum_yapan,yorum,puan) values ('$id','$kulad','$metin','$rating')");
            $dersler->execute();
        }
        
        function yorum_b_a($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from yorumlar where id='$id'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $begeni=$sunucum["begeni"];
                $dislike=$sunucum["dislike"];
            }
           
            $sorgu2 = $vt->prepare("select * from y_begeni where kulad='$kulad' and y_id='$id'");
            $sorgu2->execute();
            if($sorgu2->RowCount()!=null)
            {
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
                {
                    $yid=$sunucum["id"];
                    $durum=$sunucum["durum"];
                    if($durum==-1)
                    {
                        $yeni=$begeni+1;
                        $yeni2=$dislike-1;
                        $artır = $vt->prepare("update y_begeni set durum='1' WHERE id='$yid'");
                        $artır->execute();
                        $artır2 = $vt->prepare("update yorumlar set begeni='$yeni' and dislike='$yeni2' WHERE id='$id'");
                        $artır2->execute();
                    }
                }
            }
            else{
                $yeni=$begeni+1;
                $dersler = $vt->prepare("insert into y_begeni (y_id,kulad,durum) values ('$id','$kulad','1')");
                $dersler->execute();
                $artır7 = $vt->prepare("update yorumlar set begeni='$yeni' WHERE id='$id'");
                $artır7->execute();
            }
            
        }

        function yorum_d_a($kulad,$id,$vt){
            $sorgu = $vt->prepare("select * from yorumlar where id='$id'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $begeni=$sunucum["begeni"];
                $dislike=$sunucum["dislike"];

                $sorgu2 = $vt->prepare("select * from y_begeni where kulad='$kulad' and y_id='$id'");
                $sorgu2->execute();
                if($sorgu2->RowCount()!=null)
                {
                    while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
                    {
                        $yid=$sunucum["id"];
                        $durum=$sunucum["durum"];

                        if($durum==1)
                        {
                            $yeni=$begeni-1;
                            $yeni2=$dislike+1;
                            $artır = $vt->prepare("update y_begeni set durum='1' WHERE y_id='$id'");
                            $artır->execute();
                            $artır2 = $vt->prepare("update yorumlar set begeni='$yeni' WHERE id='$id'");
                            $artır2->execute();
                            $artır4 = $vt->prepare("update yorumlar set dislike='$yeni2' WHERE id='$id'");
                            $artır4->execute();
                            
                        }
                    }
                }
                else{
                    $yeni2=$dislike+1;
                    $dersler = $vt->prepare("insert into y_begeni (y_id,kulad,durum) values ('$id','$kulad','1')");
                    $dersler->execute();
                    $artır3 = $vt->prepare("update yorumlar set dislike='$yeni2' WHERE id='$id'");
                    $artır3->execute();
                }
            }
            
           
           
            
        }

        function tamad($kisi,$vt){
            $sorgu= $vt->prepare("select tamad from uye where kulad='$kisi'");
            $sorgu->execute();
            while($sonucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $tamad=$sonucum["tamad"];
            }
            return $tamad;
        }

        function a_e_bilgi($sahibi,$vt){
            
            $sorgu = $vt->prepare("select * from uye where kulad='$sahibi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $tamad=$sunucum["tamad"];
                $kulad=$sunucum["kulad"];
                $mail=$sunucum["mail"];
                $seviye=$sunucum["seviye"];
                $hakkında=$sunucum["hakkında"];
                $linkedin=$sunucum["linkedin"];
                $github=$sunucum["github"];
                $durum=$sunucum["durum"];
                echo '
                <h3 class="h5">Tam adı: '.$tamad.'</h3>
                <h3 class="h5">Kullanıcı adı: '.$kulad.'</h3>
                <h3 class="h5">Kullanıcı mail: '.$mail.'</h3>
                <h3 class="h5">Kullanıcı seviye: '.$seviye.'</h3>
                <h3 class="h5">Kullanıcı hakkında: '.$hakkında.'</h3>
                <h3 class="h5">Kullanıcı linkedin: '.$linkedin.'</h3>
                <h3 class="h5">Kullanıcı github: '.$github.'</h3>
                ';
                if($durum!=0){
                    echo '
                        <h3 class="h5">Kullanıcı durumu: Yasaklanmış Kullanıcı</h3>
                    ';
                }
                else{
                    echo '
                        <h3 class="h5">Kullanıcı durumu: Aktif Kullanıcı</h3>
                    ';
                }
            }
        }

        function a_d_b($sahibi,$vt){
            $sorgu = $vt->prepare("select * from dersler where sahibi='$sahibi'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $kategori=$sunucum["kategori"];
                $sorgu2 = $vt->prepare("select * from altkategori where id='$kategori'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC)){
                    $anakategori=$sunucum2["kategori"];
                    $altkategori=$sunucum2["altkategori"];
                }
                $id=$sunucum["id"];
                $ders_adi=$sunucum["ders_adi"];
                $fiyat=$sunucum["fiyat"];
                $hakkında=$sunucum["kayıtlı"];
                $linkedin=$sunucum["aciklama"];

                $sorgu4 = $vt->prepare("select * from rapor where ders='$id'");
                $sorgu4->execute();
                $sayi=$sorgu4->rowCount();
                
                echo '
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapse'.$id.'">
                                <h6 class="m-0 font-weight-bold text-success">'.$sunucum["ders_adi"].' </h6>
                            </a>
                        </div>
                        <div id="collapse'.$id.'" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                            <h3 class="h5">Ders rapor sayısı: '.$sayi.'</h3>
                            <h3 class="h5">Ders fiyatı: '.$sunucum["fiyat"].'</h3>
                            <h3 class="h5">Ders kategorisi: '.$anakategori.' | '.$altkategori.'</h3>
                            <h3 class="h5">Derse kayıtlı kişi sayısı: '.$sunucum["kayıtlı"].'</h3>
                            <h3 class="h5">Ders durumu: ';
                    if($sunucum["durum"]==1){
                        echo 'Yayında';
                    }
                    else{
                        echo 'Yayında değil';
                    }
                    echo '
                    </h3>
                            <h3 class="h5">Ders açıklaması: '.$sunucum["aciklama"].'</h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-sm btn-success" href="../ders?id='.$id.'" role="button">Derse Git</a>
                        </div>
                    </div>
                ';

            }
        }

        function a_d_s_mesaj($kisi,$ders,$mesaj,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $ders_adi=$sunucum["ders_adi"];
            }
            
            $bildir=$vt->prepare("insert into bildirim (id,alıcı,gönderen,baslik,ders,mesaj,okundu) values (NULL,'$kisi','Yetkili','$ders_adi için özel mesaj','Yetkili','$mesaj','0')");
            $bildir->execute();
        }

        function odeme($kisi,$ders,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC)){
                $ders_adi=$sunucum["ders_adi"];
                $fiyat=$sunucum["fiyat"];
            }
            echo '
                <div class="row g-5">

                    <div class="col-5 order-md-last">
                      <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-dark">Sepet</span>
                      </h4>

                      <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                          <div>
                            <h6 class="my-0">'.$ders_adi.'</h6>
                          </div>
                          <span class="text-muted">'.$fiyat.' <i class="fas fa-lira-sign fa-sm"></i></span>
                        </li>
                      </ul>

                      <form class="card p-2">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Kupon" disabled>
                          <button type="submit" class="btn btn-dark">Kullan</button>
                        </div>
                      </form>
                    </div>

                    <div class="col-7">
                        <h4 class="mb-3">Ödeme Adresi</h4>
                        <form action="ödeme.php?id='.$ders.'&sayfa=basarili" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">İsim</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="" disabled>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label">Soyisim</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="" value="" disabled>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Adres</label>
                                    <input type="text" class="form-control" id="address" disabled>
                                    <div class="invalid-feedback">
                                        Lütfen adres girin.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="address2" class="form-label">Adres 2 <span class="text-muted">(Opsiyonel)</span></label>
                                    <input type="text" class="form-control" id="address2" disabled>
                                </div>
                            </div>
            
                            <hr class="my-4">
            
                            <h4 class="mb-3">Ödeme</h4>
            
                            <div class="my-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="flexRadioDisabled" disabled>
                                    <label class="form-check-label" for="flexRadioDisabled">Kredi kartı</label>
                                </div>
                                <div class="form-check">
                                    <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" disabled>
                                    <label class="form-check-label" for="paypal">PayPal</label>
                                </div>
                            </div>
            
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <label for="cc-name" class="form-label">Kart üzerindeki isim</label>
                                    <input type="text" class="form-control" id="cc-name" placeholder="" disabled>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="cc-number" class="form-label">Kart Numarası</label>
                                    <input type="text" class="form-control" id="cc-number" placeholder="" disabled>

                                </div>

                                <div class="col-md-4">
                                    <label for="cc-expiration" class="form-label">Son kullanma tarihi</label>
                                    <input type="text" class="form-control" id="cc-expiration" placeholder="**/****" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label for="cc-cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cc-cvv" placeholder="***" disabled>

                                </div>
                            </div>
            
                            <hr class="my-4">
            
                            <button class="w-100 btn btn-dark btn-lg" type="submit">Ödemeyi Tamamla</button>
                        </form>
                    </div>
                </div>
            ';
        }

        function d_odeme($kulad,$ders,$vt){
            $sorgu = $vt->prepare("select * from dersler where id='$ders'");
            $sorgu->execute();
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $fiyat=$sunucum["fiyat"];
            }

            $cevap=self::d_kontrol($kulad,$ders,$vt);
            if($cevap==0){
                $dersler = $vt->prepare("insert into odeme (kulad,ders,fiyat) values ('$kulad','$ders','$fiyat')");
                $dersler->execute();
            } 
        }

        function user_odeme($kulad,$vt){
            
            $sorgu = $vt->prepare("select * from odeme where kulad='$kulad'");
            $sorgu->execute();
            $i=0;
            while($sunucum=$sorgu->fetch(PDO::FETCH_ASSOC))
            {
                $id=$sunucum["ders"];
                $sorgu2 = $vt->prepare("select * from dersler where id='$id'");
                $sorgu2->execute();
                while($sunucum2=$sorgu2->fetch(PDO::FETCH_ASSOC))
                {
                    $ders_adi=$sunucum2["ders_adi"];
                }
                $ders=$sunucum["ders"];
                $fiyat=$sunucum["fiyat"];
                $tarih=$sunucum["tarih"];
                $i++;
                echo'
                    <tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$ders_adi.'</td>
                        <td>'.$fiyat.' <i class="fas fa-lira-sign fa-sm"></i></td>
                        <td>'.$tarih.'</td>
                        <td><a href="ders?id='.$id.'"><button class="btn btn-success btn-sm">Gör</button></a></td>
                    </tr>
                ';
            }
        }
    }
?>