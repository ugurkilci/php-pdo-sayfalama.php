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

echo '<div class="col-sm-12"><nav><ul class="pagination">';

if($Sayfa > 1){
   echo '
   <li class="page-item"><a href="?q=1" class="page-link">İlk</a></li>
   <li class="page-item"><a href="?q='; echo $Sayfa - 1; '" class="page-link">Önceki</a></li>';
}

for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ // i kaç ise o sayıdan başlar 1-2-3-4-5 yazmaya. mesela sayfa 7deyiz 7 - 5 = 2'dir 2 sayfadan sonra sayfalamaya başlar yani 2-3-4-5-6-7 gibi bu aynı mantıkla devam eder.
   if($i > 0 and $i <= $Sayfa_Sayisi){
           if($i == $Sayfa){
               echo '<li class="page-item active"><a href="" class="page-link">'.$i.'</a></li>'; //eğer i ile sayfa değerleri aynıysa o zaman onu aktif css'si ekle
       }else{
               echo '<li class="page-item"><a href="?q='.$i.'" class="page-link">'.$i.'</a></li>'; //eğer aynı değilse normal listele
       }
   }
}
   
if($Sayfa != $Sayfa_Sayisi){
     echo '<li class="page-item"><a href="?q='; echo $Sayfa + 1; echo '" class="page-link">Sonraki</a></li>';
     echo '<li class="page-item"><a href="?q='; echo $Sayfa_Sayisi; echo '" class="page-link">Son</a></li>';
}

echo '</ul></nav></div>';
