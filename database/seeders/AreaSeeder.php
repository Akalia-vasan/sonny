<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            ['area' => 'Adachi-ku','link' => 'http://www.city.adachi.tokyo.jp/english/translated.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Chiyoda-ku','link' => 'https://www.city.chiyoda.lg.jp/multilingual.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Itabashi-ku','link' => 'https://www.city.itabashi.tokyo.jp/translate/engagree_v2.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Koto-ku','link' => 'https://www.city.koto.lg.jp/language/lang-eng/index.html',     'created_at'=>now(),'updated_at'=>now(),],               
            ['area' => 'Nakano-ku','link' => 'https://www.city.tokyo-nakano.lg.jp/dept/102500/d014584.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Setagaya-ku','link' => 'https://www.city.setagaya.lg.jp/mokuji/bunka/007/001/d00127673.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Shinjuku-ku','link' => 'http://www.city.shinjuku.lg.jp/foreign/english/',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Taito-ku','link' => 'https://www.city.taito.lg.jp/index/multi/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Arakawa-ku','link' => 'https://www.city.arakawa.tokyo.jp/asp/english.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Chuo-ku','link' => 'https://www.city.chuo.lg.jp/multilingual/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Katsushika-ku','link' => 'https://www.city.katsushika.lg.jp/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Meguro-ku','link' => 'https://www.city.meguro.tokyo.jp/multi/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Nerima-ku','link' => 'https://www.city.nerima.tokyo.jp/multilingual/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Shibuya-ku','link' => 'http://www.city.shibuya.tokyo.jp/',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Suginami-ku','link' => 'https://www.city.suginami.tokyo.jp/',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Toshima-ku','link' => 'https://www.city.toshima.lg.jp/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Bunkyo-ku','link' => 'https://www.city.bunkyo.lg.jp/',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Edogawa-ku','link' => 'https://www.city.edogawa.tokyo.jp/foreign/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Kita-ku','link' => 'http://www.city.kita.tokyo.jp/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Minato-ku','link' => 'https://www.city.minato.tokyo.jp/multilingual/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Ota-ku','link' => 'http://www.city.ota.tokyo.jp/honnyaku/index.html',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Shinagawa-ku','link' => 'https://www.city.shinagawa.tokyo.jp/',     'created_at'=>now(),'updated_at'=>now(),],
            ['area' => 'Sumida-ku','link' => 'https://www.city.sumida.lg.jp/index.html',     'created_at'=>now(),'updated_at'=>now(),], 
        ]);
    }
}
