# Laravel - CMS

Laravel - CMS Reposunu indirdikten sonra çalıştırılması gereken komutlar.
composer -i
php artisan cms:first-installment
composer dump-autoload
php artisan cms:first-installment komutu sizin için bütün gerekli migrasyon ve yapılandırma ayarlarını yapacak ve 1 adet kullanıcı hesabı oluşturacaktır.
Kurulum tamamlandı mesajını konsol ekranında gördükten sonra /admin rotası ile admin paneli giriş ekranına ulaşabilirsiniz.

Uygulamanızda il ve ilçe gerekliği varsa uygulamanın içinde gömülü bulunan ve ilk kurulum esnasında oluşturulan ama içeriği doldurulmayan il ilçe (towns , cities) tablolarınu aşağıdaki komutlar ile doldurabilir ve City ve Townmodelleri ile kullanabilirsiniz.

php artisan db:seed --class=createCitiesSeeder

php artisan db:seed --class=createTownsSeeder

Bütün işlemler bittikten sonra uygulamayı kullanmaya başlayabilirsiniz.

Blade belgelerinde ihtiyacınız olan fonksiyonlar App/Helpers/Helper.php dosyasındadır ihtiyacınız olan ek fonksiyonkları bu dosya içerisinde yapabilirsiniz(Bu dosta composer.json belgesinde files olarak eklidir ilk kurulumdan sonra "composer dump-autoload" komutu çalıştırılmalıdır)

Cms nin tip ve form yöneticindeki tipler ise Config/Custom.php dosyasında tutulmaktadır.
