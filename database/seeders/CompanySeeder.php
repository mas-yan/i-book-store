<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'MyStore',
            'address' => 'Desa Karangmalang Rt:06 Rw:01, Kec.Kangung, kab.Kendal',
            'day_operational' => 'Buka Setiap Hari',
            'time_operational' => '<p><strong>Senin - Jumat&nbsp;</strong>(07.00 - 19.00)</p>
            <p><strong>Sabtu - Minggu&nbsp;</strong>(07-00 - 16.00)&nbsp;</p>',
            'long' => '-6.91489074604621',
            'lat' => '110.1179379124807',
            'about' => 'toko barang ori dan terpercaya'
        ]);
    }
}
