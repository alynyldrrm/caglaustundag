<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class firstInstallment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:first-installment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cms İlk Kurulum Ayarları';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "kurulum başladı \n";
        try {
            /* Spatie permission paketinin kaynaklarının çıkartılması*/
            echo "permission paketinin kaynak dosyaları çıkartılıyor \n";
            Artisan::call('vendor:publish', ['--provider' => "Spatie\Permission\PermissionServiceProvider"]);
            echo "permission paketinin kaynak dosyaları çıkartıldı \n";
            /* Varsayılan Eklenen tr dili için çeviri dosyasının oluşturulması*/
            echo "Varsayılan Eklenen tr dili için çeviri dosyası oluşturuluyor \n";
            fopen(lang_path("tr.json"), "w");
            file_put_contents(lang_path("tr.json"), "[]");
            echo "Varsayılan Eklenen tr dili için çeviri dosyası oluşturuldu \n";
            /** Migrasyonları Çalıştırma */
            echo "migrasyonlar çalıştırılıyor \n";
            Artisan::call("migrate --force");
            echo "migrasyonlar tamamlanı \n";
            /** Seederı Çalıtırma */
            Artisan::call("db:seed", ["--class" => "firstInstallmentSeeder"]);
            /**Cache leri temizle */
            echo "Cacheler temizleniyor \n";
            Artisan::call("cache:clear");
            Artisan::call("optimize:clear");
            Artisan::call("clear-compiled");
            Artisan::call("config:clear");
            echo "Cacheler temizlendi \n";
            echo "CMS Kurulumu Tamamlandı Kolay Gelsin :D \n";
        } catch (\Throwable $th) {
            echo "----HATA---- \n";
            echo $th->getMessage();
        }
    }
}
