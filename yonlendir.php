<?php
    
    include("fonksiyon.php");
    $bilgi= new codeout;
    $bilgi->kontrolet("cot");
    $kulad=$bilgi->kuladial($baglanti);

    @$sayfa=$_GET["sayfa"];
    switch($sayfa):

        case "yazdır":
            $mail=htmlspecialchars($_POST["mail"]);
            if($mail!=null)
            {
                $sifre=htmlspecialchars($_POST["sifre"]);
                echo $mail;
            }
        break;

        case "giris":
            $mail=htmlspecialchars($_POST["mail"]);
            if($mail!=null)
            {
                $sifre=htmlspecialchars($_POST["sifre"]);
                $bilgi->giriskontrol($mail,$sifre,$baglanti);
            }
        break;

            case "exit":
                $bilgi->cikis($baglanti);
                header("Location:g-index.php");
            break;

            case "ders_duyuru":
                @$id=$_GET["id"];
                $baslik=htmlspecialchars($_POST["baslik"]);
                $mesaj=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);  
                 if($mesaj!=null){
                    $bilgi->d_duyuru($kulad,$id,$baslik,$mesaj,$baglanti);
                 }
                 header("Location:yonetim/index.php?sayfa=dersler");                
            break;
            
            case "ders_ekle":
                if($_POST["d_adi"]!=NULL){
                    $d_adi=htmlspecialchars($_POST["d_adi"]);
                    $kulad=$bilgi->kuladial($baglanti);
                    $d_fiyat=htmlspecialchars($_POST["d_fiyat"]);
                    $kategori=htmlspecialchars($_POST["kategori"]);
                    $bilgi->d_ekle($kulad,$d_adi,$d_fiyat,$kategori,$baglanti);
                    $id=$bilgi->d_id($kulad,$d_adi,$baglanti);
      
                      mkdir("dersler/".$id);
                      touch("dersler/".$id."/index.php");
                           
                      $oku = fopen('yonetim/main.php', 'r');
                      $yaz = fopen('dersler/'.$id.'/index.php', 'w');
                      $icerik = fread($oku, filesize('yonetim/main.php'));
                      fwrite($yaz, $icerik);    
                      fclose($oku);
                      fclose($yaz);
                  }
                  header("Location:yonetim/index.php?sayfa=dersler");     
            break;

            case "ders_ayar":
                $d_adi=htmlspecialchars($_POST["d_adi"]);
    
                if($d_adi!=NULL){
                  @$id=$_GET["id"];
                  $kulad=$bilgi->kuladial($baglanti);
                  $d_fiyat=htmlspecialchars($_POST["d_fiyat"]);
                  $kategori=htmlspecialchars($_POST["kategori"]);
                  $bilgi->d_ayar($kulad,$id,$d_adi,$d_fiyat,$kategori,$baglanti);
                  
                  header("Location:yonetim/index.php?sayfa=dersler");  
                }
            break;
            
            case "ders_sil":
                $d_adi=htmlspecialchars($_POST["d_adi"]);
        
                  @$id=$_GET["id"];
                  $kulad=$bilgi->kuladial($baglanti);        
                  header("Location:yonetim/index.php");           
                  $bilgi->ders_sil($kulad,$id,$d_adi,$baglanti);
                  if (file_exists("dersler/".$id))
                  { //dosyalar dizininin içerisinde resimler klasörü mevcut ise
                    array_map('unlink', glob("dersler/".$id."/*")); //bütün dosyalar siliniyor
                    $sonuc = rmdir("dersler/".$id); //klasör siliniyor         
                  }
              break;
            
            
              case "ders_git":
                
                  @$id=$_GET["id"];
                  $kulad=$bilgi->kuladial($baglanti);
                  $bilgi->d_ayar($kulad,$id,$d_adi,$d_fiyat,$kategori,$baglanti);

            break;  

            case "ders_aciklama":
                @$id=$_GET["id"];
                $mesaj=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);  
                if($mesaj!=null){
                    $bilgi->d_aciklama($kulad,$id,$mesaj,$baglanti);
                }
                header("Location:yonetim/index.php?sayfa=dersler");                
            break;

            case "ders_bildir":
                @$ders=$_GET["ders"];
                @$video=$_GET["video"];
                $rapor=htmlspecialchars($_POST["rapor"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->d_rapor($kulad,$ders,$video,$rapor,$baglanti);    
                header("Location:video?id=$ders&video=$video");

            break;

            case "t_ekle":
                @$id=$_GET["id"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->d_t_ekle($kulad,$id,$baglanti);
                header("Location:yonetim/index.php?sayfa=ders_edit&id=$id");  
            break;

            case "v_ekle":
                @$id=$_GET["id"];
                $kulad=$bilgi->kuladial($baglanti);
                $v_baslik=htmlspecialchars($_POST["v_baslik"]);
    
                if($v_baslik!=NULL){

                  $bilgi->v_ekle($kulad,$id,$v_baslik,$baglanti);
                  
                  header("Location:yonetim/index.php?sayfa=dersler");  
                }

            break;

            case "v_degis":
                @$id=$_GET["id"];
                @$video=$_GET["video"];
                $kulad=$bilgi->kuladial($baglanti);
                $v_baslik=htmlspecialchars($_POST["v_baslik"]);
                if($v_baslik!=NULL){

                    $bilgi->video_degis($kulad,$id,$video,$v_baslik,$baglanti);
                    
                    header("Location:yonetim/index.php?sayfa=ders_edit&id=$id");  
                  }
            break;

            case "v_sil":
                @$id=$_GET["id"];
                @$video=$_GET["video"];
                $kulad=$bilgi->kuladial($baglanti);
                $d_adi=htmlspecialchars($_POST["d_adi"]);
                if($d_adi!=NULL){

                    $bilgi->v_sil($kulad,$id,$video,$d_adi,$baglanti);
                    
                    header("Location:yonetim/index.php?sayfa=ders_edit&id=$id");  
                  }
            break;

            case "k_ekle":
                @$id=$_GET["id"];
                @$video=$_GET["video"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_ekle($kulad,$id,$video,$baglanti);    
                header("Location:yonetim/index.php?sayfa=ders_edit&id=$id");  
            break;
            
            case "aranan":
                $bul=htmlspecialchars($_POST["bul"]);
                header("Location:ara?aranan=$bul");

            break;        
            
            case "bildirim":
                $id=$_GET["mesaj"];
                $bilgi->b_okundu($id,$baglanti);
                header("Location:index.php");   
            break;
            case "bildirim_sil":
                $mesajid=$_GET["mesaj"];
                $bilgi->b_sil($mesajid,$baglanti);
                header("Location:index.php");  
            break;
            case "indir":
                $kaynak=$_GET["inecek"];
                header('Content-type: application/vnd.rar');
                header('Content-disposition: attachment; filename= dosya.rar');
                readfile($kaynak);
                  
            break;

            case "soru-cevap":
                @$d_id=$_GET["id"];
                @$hedef=$_GET["hedef"];
                @$s_id=$_GET["soru"];
                $cevap=htmlspecialchars($_POST["message"]);
                $kulad=$bilgi->kuladial($baglanti);
                if(!empty($cevap))
                {
                    $bilgi->s_cevapla($kulad,$d_id,$s_id,$hedef,$cevap,$baglanti);
                }        
                header("Location:yonetim/index.php?sayfa=sorular");
            break;
            case "soru_ekle":
                @$ders=$_GET["ders"];
                @$video=$_GET["video"];
                $soru=htmlspecialchars($_POST["soru"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->s_ekle($kulad,$ders,$video,$soru,$baglanti);    
                header("Location:video?id=$ders&video=$video");
            break;

            case "soru_sil":
                @$s_id=$_GET["id"];
                @$s_ders=$_GET["ders"];
                @$s_gönderen=$_GET["gonderen"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->s_sil($kulad,$s_id,$s_ders,$s_gönderen,$baglanti);    
                header("Location:yonetim/index.php?sayfa=sorular");
            break;

            case "d_uygun":
                @$rapor=$_GET["r"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->d_uygun($kulad,$rapor,$baglanti);    
                header("Location:admin/index");
            break;

            case "d_uyarı":
                @$rapor=$_GET["r"];
                @$ders=$_GET["d"];
                @$video=$_GET["v"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->d_uyarı($kulad,$rapor,$ders,$video,$baglanti);    
                header("Location:admin/index?sayfa=raporlar");
            break;

            case "d_v_y_kaldır":
                @$rapor=$_GET["r"];
                @$ders=$_GET["d"];
                @$video=$_GET["v"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->d_v_y_kaldır($kulad,$rapor,$ders,$video,$baglanti);    
                header("Location:admin/index?sayfa=raporlar");
            break;

            case "r_e_mesaj":
                @$rapor=$_GET["r"];
                @$ders=$_GET["d"];
                $mesaj=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                if($mesaj!=null){
                    $bilgi->r_e_mesaj($kulad,$rapor,$ders,$mesaj,$baglanti);  
                 }
                  
                header("Location:admin/index?sayfa=raporlar");
            break;

            case "r_r_mesaj":
                @$rapor=$_GET["r"];
                $mesaj=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                if($mesaj!=null){
                    $bilgi->r_r_mesaj($kulad,$rapor,$mesaj,$baglanti);  
                 }
                  
                header("Location:admin/index?sayfa=raporlar");
            break;

            case "a_k_yetkili":
                @$kisi=$_GET["g"];
                $bilgi->a_k_yetkili($kisi,$baglanti);    
                header("Location:admin/index?sayfa=kullanıcı_ayar&id=".$kisi);
            break;

            case "a_k_yetkial":
                @$kisi=$_GET["g"];
                $bilgi->a_k_yetkial($kisi,$baglanti);    
                header("Location:admin/index?sayfa=kullanıcı_ayar&id=".$kisi);
            break;

            case "a_k_mesaj":
                @$kisi=$_GET["g"];
                $mesaj=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                if($mesaj!=null){
                    $bilgi->a_k_mesaj($kulad,$kisi,$mesaj,$baglanti);  
                 }
                  
                header("Location:admin/index?sayfa=kullanıcı_ayar&id=".$kisi);
            break;
            
            case "a_k_banla":
                @$kisi=$_GET["g"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->a_k_banla($kulad,$kisi,$baglanti);  
                header("Location:admin/index?sayfa=kullanıcı_ayar&id=".$kisi);
            break;

            case "resim_ekle":
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->resim_ekle($kulad,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_s_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_s_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_m_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_m_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_a_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_a_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_y_degis":
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_y_degis($kulad,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_g_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_g_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_l_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_l_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "k_h_degis":
                $metin=htmlspecialchars($_POST["metin"]);
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->k_h_degis($kulad,$metin,$baglanti);    
                header("Location:kullanıcı");  
            break;

            case "yorum_ekle":
                @$id=$_GET["id"];
                $metin=htmlspecialchars($_POST["metin"]);
                $rating=htmlspecialchars($_POST["rating"]);
                $kulad=$bilgi->kuladial($baglanti);
                if($metin!=null && $rating != null){
                    $bilgi->yorum_ekle($kulad,$id,$metin,$rating,$baglanti);    
                }
                header("Location:video?id=$id&video=1.mp4");  
            break;

            case "yorum_b_a":
                @$ders=$_GET["ders"];
                @$id=$_GET["id"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->yorum_b_a($kulad,$id,$baglanti);    
                header("Location:video?id=$ders&video=1.mp4");  
            break;

            case "yorum_d_a":
                @$ders=$_GET["ders"];
                @$id=$_GET["id"];
                $kulad=$bilgi->kuladial($baglanti);
                $bilgi->yorum_d_a($kulad,$id,$baglanti);    
                header("Location:video?id=$ders&video=1.mp4");  
            break;

            case "a_d_s_mesaj":
                @$kisi=$_GET["g"];
                @$ders=$_GET["id"];
                $mesaj=htmlspecialchars($_POST["metin"]);
                if($mesaj!=null){
                    $bilgi->a_d_s_mesaj($kisi,$ders,$mesaj,$baglanti);  
                 }
                  
                header("Location:admin/index?sayfa=ders_ayar&id=$ders&s=$kisi");
            break;
            
            default:
                   
    endswitch;

?>