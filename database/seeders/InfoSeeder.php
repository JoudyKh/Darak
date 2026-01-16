<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infos = [
            [
                'key' => 'phone1',
                'value' => '0999999999',
            ],
            [
                'key' => 'phone2',
                'value' => '0999999998',
            ],
            [
                'key' => 'phone3',
                'value' => '0999999898',
            ],
            [
                'key' => 'email1',
                'value' => 'email1@gmail.com',
            ],
            [
                'key' => 'email2',
                'value' => 'email2@gmail.com',
            ],
            [
                'key' => 'facebook',
                'value' => 'https://www.facebook.com',
            ],
            [
                'key' => 'instagram',
                'value' => 'https://www.instagram.com',
            ],
            [
                'key' => 'whatsapp',
                'value' => 'https://www.whatsapp.com',
            ],
        ];
        Info::insert($infos);
    }
}
