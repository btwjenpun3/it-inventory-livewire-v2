<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\Testing\Testing::factory(20)->create();

        \App\Models\Master\MasterBuyer::create([
            'code_buyer' => 'BUY100',
            'buyer_name' => 'PT Jaya Sentosa',
            'state' => 'Indonesia'
        ]);

        \App\Models\Master\MasterArticle::create([
            'article_code' => 'ART100',
            'article_name' => 'Sepatu Adidas Air',
            'description' => 'Adidas Air X44',
            'buyer_id' => 1
        ]);
        \App\Models\Master\MasterArticle::create([
            'article_code' => 'ART200',
            'article_name' => 'Sepatu Adidas Air',
            'description' => 'Adidas Air X45',
            'buyer_id' => 1
        ]);
        \App\Models\Master\MasterArticle::create([
            'article_code' => 'ART300',
            'article_name' => 'Kaos Kaki Adidas',
            'description' => 'Adidas Shock XG1',
            'buyer_id' => 1
        ]);

        \App\Models\Master\MasterSatuan::create([
            'satuan' => 'cm',
            'description' => 'Centimeter'
        ]);
        \App\Models\Master\MasterSatuan::create([
            'satuan' => 'pcs',
            'description' => 'Pieces'
        ]);
        \App\Models\Master\MasterSatuan::create([
            'satuan' => 'roll',
            'description' => 'Roll'
        ]);
        \App\Models\Master\MasterSatuan::create([
            'satuan' => 'gr',
            'description' => 'Gram'
        ]);

        \App\Models\Master\MasterCurrency::create([
            'currency_code' => 'IDR',
            'currency_name' => 'Indonesian Rupiah'
        ]);

        \App\Models\Master\MasterPic::create([
            'name' => 'Helmi',
            'title' => 'Gudang',
            'email' => 'muhamadkelmi@gmail.com'
        ]);

        \App\Models\Master\MasterProcurement::create([
            'procurement' => 'MTS',
        ]);
        \App\Models\Master\MasterProcurement::create([
            'procurement' => 'OTS',
        ]);

        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'BOH',
        ]);
        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'BTK',
        ]);
        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'BOP',
        ]);
        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'RAW',
        ]);
        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'WIP',
        ]);
        \App\Models\Master\MasterMaterialType::create([
            'material_type' => 'FG',
        ]);
    }
}
