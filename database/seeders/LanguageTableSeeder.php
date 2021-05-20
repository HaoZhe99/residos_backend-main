<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = [
            [
                'id'        =>1,
                'title'     =>'English',
                'shortkey'  =>'en'
            ],
            [
                'id'        =>2,
                'title'     =>'Arabic',
                'shortkey'  =>'ar'
            ],
            [
                'id'        =>3,
                'title'     =>'Azerbaijani',
                'shortkey'  =>'az'
            ],
            [
                'id'        =>4,
                'title'     =>'Bosnian',
                'shortkey'  =>'bs'
            ],
            [
                'id'        =>5,
                'title'     =>'Catalan',
                'shortkey'  =>'ca'
            ],
            [
                'id'        =>6,
                'title'     =>'Chinese (Simplified)',
                'shortkey'  =>'zh-Hans'
            ],
            [
                'id'        =>7,
                'title'     =>'Chinese (Traditional)',
                'shortkey'  =>'zh-Hant'
            ],
            [
                'id'        =>8,
                'title'     =>'Croatian',
                'shortkey'  =>'hr'
            ],
            [
                'id'        =>9,
                'title'     =>'Czech',
                'shortkey'  =>'cs'
            ],
            [
                'id'        =>10,
                'title'     =>'Danish',
                'shortkey'  =>'da'
            ],
            [
                'id'        =>11,
                'title'     =>'Dutch',
                'shortkey'  =>'nl'
            ],
            [
                'id'        =>12,
                'title'     =>'Estonian',
                'shortkey'  =>'et'
            ],
            [
                'id'        =>13,
                'title'     =>'Finnish',
                'shortkey'  =>'fi'
            ],
            [
                'id'        =>14,
                'title'     =>'French',
                'shortkey'  =>'fr'
            ],
            [
                'id'        =>15,
                'title'     =>'Georgian',
                'shortkey'  =>'ka'
            ],
            [
                'id'        =>16,
                'title'     =>'Bulgarian',
                'shortkey'  =>'bg'
            ],
            [
                'id'        =>17,
                'title'     =>'German',
                'shortkey'  =>'de'
            ],
            [
                'id'        =>18,
                'title'     =>'Greek',
                'shortkey'  =>'el'
            ],
            [
                'id'        =>19,
                'title'     =>'Hindi',
                'shortkey'  =>'hi'
            ],
            [
                'id'        =>20,
                'title'     =>'Hebrew',
                'shortkey'  =>'he'
            ],
            [
                'id'        =>21,
                'title'     =>'Hungarian',
                'shortkey'  =>'hu'
            ],
            [
                'id'        =>22,
                'title'     =>'In[donesian',
                'shortkey'  =>    'id',
                ],
                [
                'id'        =>23,
                'title'     =>'Italian',
                'shortkey'  =>'it'
            ],
            [
                'id'        =>24,
                'title'     =>'Japanese',
                'shortkey'  =>'ja'
            ],
            [
                'id'        =>25,
                'title'     =>'Korean',
                'shortkey'  =>'ko'
            ],
            [
                'id'        =>26,
                'title'     =>'Latvian',
                'shortkey'  =>'lv'
            ],
            [
                'id'        =>27,
                'title'     =>'Lithuanian',
                'shortkey'  =>'lt'
            ],
            [
                'id'        =>28,
                'title'     =>'Malay',
                'shortkey'  =>'ms'
            ],
            [
                'id'        =>29,
                'title'     =>'Norwegian',
                'shortkey'  =>'nb'
            ],
            [
                'id'        =>30,
                'title'     =>'Persian',
                'shortkey'  =>'fa'
            ],
            [
                'id'        =>31,
                'title'     =>'Polish',
                'shortkey'  =>'pl'
            ],
            [
                'id'        =>32,
                'title'     =>'Portuguese',
                'shortkey'  =>'pt'
            ],
            [
                'id'        =>33,
                'title'     =>'Punjabi',
                'shortkey'  =>'pa'
            ],
            [
                'id'        =>34,
                'title'     =>'Romanian',
                'shortkey'  =>'ro'
            ],
            [
                'id'        =>35,
                'title'     =>'Russian',
                'shortkey'  =>'ru'
            ],
            [
                'id'        =>36,
                'title'     =>'Serbian',
                'shortkey'  =>'sr'
            ],
            [
                'id'        =>37,
                'title'     =>'Slovak',
                'shortkey'  =>'sk'
            ],
            [
                'id'        =>38,
                'title'     =>'Spanish',
                'shortkey'  =>'es'
            ],
            [
                'id'        =>39,
                'title'     =>'Swedish',
                'shortkey'  =>'sv'
            ],
            [
                'id'        =>40,
                'title'     =>'Thai',
                'shortkey'  =>'th'
            ],
            [
                'id'        =>41,
                'title'     =>'Turkish',
                'shortkey'  =>'tr'
            ],
            [
                'id'        =>42,
                'title'     =>'Ukrainian',
                'shortkey'  =>'uk'
            ],
            [
                'id'        =>43,
                'title'     =>'Vietnamese',
                'shortkey'  =>'vi'
            ],
        ];

        Language::insert($language);
    }
}
