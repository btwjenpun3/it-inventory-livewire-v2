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
            'article_name' => 'Sepatu Adidas reBook',
            'description' => 'Adidas reBook X45',
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
            'title' => 'Manager Sales',
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

        \App\Models\Master\MasterWarehouse::create([
            'warehouse_code' => 'WAREHOUSE1',
            'warehouse_name' => 'Warehouse 1'
        ]);
        \App\Models\Master\MasterWarehouse::create([
            'warehouse_code' => 'WAREHOUSE2',
            'warehouse_name' => 'Warehouse 2'
        ]);

        \App\Models\Master\MasterRak::create([
            'rak_code' => 'RAK1',
            'rak_name' => 'Rak 1 - Cotton'
        ]);

        \App\Models\Master\MasterLocation::create([
            'location_code' => 'WR-01-01',
            'location_name' => 'Warehouse 1 - Rak 1',
            'warehouse_id' => 1,
            'rak_id' => 1
        ]);

        \App\Models\Master\MasterMaterial::create([
            'material_code' => 'M-1',
            'description' => 'Cotton',
            'satuan_id' => 4,
            'material_type_id' => 4
        ]);
        \App\Models\Master\MasterMaterial::create([
            'material_code' => 'M-2',
            'description' => 'Thread',
            'satuan_id' => 4,
            'material_type_id' => 4
        ]);

        \App\Models\Master\MasterBomLevel::create([
            'bom_level' => '0',
        ]);
        \App\Models\Master\MasterBomLevel::create([
            'bom_level' => '1',
        ]);
        \App\Models\Master\MasterBomLevel::create([
            'bom_level' => '2',
        ]);
        \App\Models\Master\MasterBomLevel::create([
            'bom_level' => '3',
        ]);

    }
}
