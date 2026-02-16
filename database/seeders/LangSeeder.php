<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [["name" => "Türkçe", "key" => "tr"],["name" => "English", "key" => "en"]];

        foreach($data as $item){
            Language::create([
                "key" => $item['key'],
                "text"=> $item['name']
            ]);

        }
    }
}
