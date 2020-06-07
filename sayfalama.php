$Sayfa   = @ceil($_GET['q']); //5,2 girilirse eğer get o zaman onu tam sayı yapar yanı 5 yapıyoruz bu kod ile
if ($Sayfa < 1) { $Sayfa = 1;} //eğer get değeri yerine girilen sayi 1 den küçükse sayfa değerini 1 yapıyoruz yani 1. sayfaya atıyoruz

$Say   = $db->query("SELECT * FROM icerikler ORDER BY icerik_id DESC"); //makale sayısını çekiyoruz
$ToplamVeri   = $Say->rowCount(); //makale sayısını saydırıyoruz
$Limit	= 3; //bir sayfada kaç içerik çıkacağını belirtiyoruz. 
$Sayfa_Sayisi	= ceil($ToplamVeri/$Limit); //toplam veri ile limiti bölerek her toplam sayfa sayısını buluyoruz

if($Sayfa > $Sayfa_Sayisi){$Sayfa = $Sayfa_Sayisi;} //eğer yazılan sayı büyükse eğer toplam sayfa sayısından en son sayfaya atıyoruz kullanıcıyı

$Goster   = $Sayfa * $Limit - $Limit; // sayfa= 2 olsun limit=3 olsun 2*3=6 6-3=3 buranın değeri 2. sayfada 3'dür 3-4-5-6... sayfalarda da aynı işlem yapılıp değer bulunur
$GorunenSayfa   = 5; //altta kaç tane sayfa sayısı görüneceğini belirtiyoruz.

$cek	= $db->query("SELECT * FROM icerikler ORDER BY icerik_id DESC LIMIT $Goster,$Limit"); //yukarda göstere attıgımız değer diyelim ki 3 o zaman 3.'id den başlayarak limit kadar veri ceker.
$_row = $cek->fetchAll(PDO::FETCH_ASSOC);

foreach($_row as $row){
       echo $row["icerik_baslik"];
    }
    
    if($Sayfa > 1){
        echo '<a href="?q=1">İlk</a>
        <a href="?q='; echo $Sayfa - 1; '">Önceki</a>';
    }

    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ // i kaç ise o sayıdan başlar 1-2-3-4-5 yazmaya. mesela sayfa 7deyiz 7 - 5 = 2'dir 2 sayfadan sonra sayfalamaya başlar yani 2-3-4-5-6-7 gibi bu aynı mantıkla devam eder.
      if($i > 0 and $i <= $Sayfa_Sayisi){
             if($i == $Sayfa){
                echo '<span class="say_aktif">'.$i.'</span>'; //eğer i ile sayfa değerleri aynıysa o zaman onu aktif css'si ekle
         }else{
                echo '<a class="say_a" href="?q='.$i.'">'.$i.'</a>'; //eğer aynı değilse normal listele
         }
      }
   }
   
   if($Sayfa != $Sayfa_Sayisi){
   echo '<a href="?q='; echo $Sayfa + 1; echo '">Sonraki</a>';
   echo '<a href="?q='; echo $Sayfa_Sayisi; echo '">Son</a>';
   }
