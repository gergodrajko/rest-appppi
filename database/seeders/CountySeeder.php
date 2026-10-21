<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\County;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counties = [
            [
                'name' => 'Bács-Kiskun',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/bacs.jpg',
            ],
            [
                'name' => 'Baranya',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/baranya_0.jpg',
            ],
            [
                'name' => 'Békés',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/bekes.jpg',
            ],
            [
                'name' => 'Borsod-Abaúj-Zemplén',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/borsod.jpg',
            ],
            [
                'name' => 'Csongrád-Csanád',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/csongrad.jpg',
            ],
            [
                'name' => 'Fejér',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/fejer.jpg',
            ],
            [
                'name' => 'Győr-Moson-Sopron',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/gyor.jpg',
            ],
            [
                'name' => 'Hajdú-Bihar',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/hajdu.jpg',
            ],
            [
                'name' => 'Heves',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/heves.jpg',
            ],
            [
                'name' => 'Jász-Nagykun-Szolnok',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/jasz.jpg',
            ],
            [
                'name' => 'Komárom-Esztergom',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/komarom.jpg',
            ],
            [
                'name' => 'Nógrád',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/nograd.jpg',
            ],
            [
                'name' => 'Pest',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/pest.jpg',
            ],
            [
                'name' => 'Somogy',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/somogy.jpg',
            ],
            [
                'name' => 'Szabolcs-Szatmár-Bereg',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/szabolcs.jpg',
            ],
            [
                'name' => 'Tolna',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/tolna.jpg',
            ],
            [
                'name' => 'Vas',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/vas.jpg',
            ],
            [
                'name' => 'Veszprém',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/veszprem.jpg',
            ],
            [
                'name' => 'Zala',
                'badge_url' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/zala.jpg',
            ],
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($counties));

        $bar->start();
    

        foreach ($counties as $county){
            County::create($county);

            $bar->advance();
        }
        
        $bar->finish();

        $this->command->newLine();
    }
}