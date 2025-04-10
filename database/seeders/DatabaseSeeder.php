<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'username' => 'admin',
        //     'firstname' => 'Admin',
        //     'lastname' => 'Admin',
        //     'email' => 'admin@argon.com',
        //     'password' => bcrypt('secret')
        // ]);

        DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('secret'),
            // 'email' => 'hendywonggo@gmail.com',
            'email' => 'admin@argon.com',
            'nama' => 'hendy',
            'no_telp' => '081332641234',
            'alamat' => 'surabaya',
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'username' => 'kasir',
            'password' => bcrypt('secret'),
            // 'email' => 'hendywonggo888@gmail.com',
            'email' => 'admin@argon.com',
            'nama' => 'hendy',
            'no_telp' => '081332641234',
            'alamat' => 'surabaya',
            'role' => 'kasir'
        ]);


        DB::table('suppliers')->insert([
            'nama' => 'SOGA',
            'alamat' => 'JL. Tukad Citarum O no 16, Dauh Puri Kelod , Denpasar',
            'no_telp' => '0819990357661',
            'note' => 'sales sila, owner made 0877-6169-66211'
        ]);
        DB::table('suppliers')->insert([
            'nama' => 'SINAR PURNAMA',
            'alamat' => 'JL. Dalung Permai, Krobokan Kaja, Br Bluran',
            'no_telp' => '08123968952',
            'note' => 'owner Pak Made , 0361 8685905'
        ]);
        DB::table('suppliers')->insert([
            'nama' => 'DUNIA PLASTIK',
            'alamat' => 'JL. Cokroaminoto No 432, ubung kaja , Denpasar',
            'no_telp' => '085100429256',
            'note' => 'owner Ko Acuan 0817341104'
        ]);
        DB::table('suppliers')->insert([
            'nama' => 'TRIGUNA JAYA',
            'alamat' => 'JL. Nginden Intan Raya no A8, Surabaya',
            'no_telp' => '08121384296',
            'note' => ''
        ]);


        DB::table('customers')->insert([
            'nama' => 'Trial Customer',
            'alamat' => 'JL. Nginden Intan Raya no A8, Surabaya',
            'no_telp' => '08121384296',
            'note' => 'Toko ...'
        ]);


        DB::table('kategoris')->insert([
            'kode' => 'AAA',
            'nama' => 'OPP / KANTONGAN'
        ]);
        DB::table('kategoris')->insert([
            'kode' => 'BBB',
            'nama' => 'KRESEK/ GELAS'
        ]);
        DB::table('kategoris')->insert([
            'kode' => 'CCC',
            'nama' => 'THINWALL/MIKA'
        ]);
        DB::table('kategoris')->insert([
            'kode' => 'DDD',
            'nama' => 'KERTAS DLL '
        ]);


        DB::table('satuans')->insert([
            'nama' => 'PAK 1/4'
        ]);
        DB::table('satuans')->insert([
            'nama' => 'KG'
        ]);
        DB::table('satuans')->insert([
            'nama' => 'PAK'
        ]);
        DB::table('satuans')->insert([
            'nama' => 'SLOP'
        ]);
        DB::table('satuans')->insert([
            'nama' => 'ROL'
        ]);


        DB::table('barangs')->insert([
            'kategoris_id' => 1,
            'kode' => 'AAA001',
            'nama' => 'OPP TL 100 X 60',
            'stock' => 0,
            'harga_beli' => 9250,
            'harga_jual' => 11000,
            'satuans_id' => 1
        ]);
    }
}
