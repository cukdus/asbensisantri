<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class SiswaSeeder extends Seeder
{
    private \Faker\Generator $faker;
    private array $kelas;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        $this->faker = \Faker\Factory::create('id_ID');
        $this->kelas = $this->db->table('tb_kelas')->get()->getResultArray();
    }

    public function run()
    {
        // Clear existing data first
        $this->db->table('tb_siswa')->truncate();

        // Insert new data
        $this->db->table('tb_siswa')->insertBatch(
            $this->createSiswa(10)
        );

        echo "✅ SiswaSeeder: 20 siswa berhasil ditambahkan\n";
    }

    protected function createSiswa($count = 1)
    {
        $data = [];
        $usedNis = [];
        $usedUniqueCodes = [];

        // Daftar nama siswa Indonesia yang realistis
        $namaPria = [
            'Ahmad Rizki', 'Budi Santoso', 'Dedi Kurniawan', 'Eko Prasetyo', 'Fajar Nugroho',
            'Gilang Ramadhan', 'Hendra Wijaya', 'Indra Gunawan', 'Joko Susilo', 'Kevin Pratama',
            'Lukman Hakim', 'Muhammad Iqbal', 'Nanda Pratama', 'Oscar Febrian', 'Putra Mahendra',
            'Qori Maulana', 'Rizky Aditya', 'Satria Wibowo', 'Taufik Hidayat', 'Umar Faruq',
            'Vino Bastian', 'Wahyu Setiawan', 'Xavier Nugraha', 'Yoga Pratama', 'Zaki Rahman'
        ];

        $namaWanita = [
            'Ayu Lestari', 'Bella Safitri', 'Citra Dewi', 'Dina Marlina', 'Eka Putri',
            'Fitri Handayani', 'Gita Sari', 'Hani Rahmawati', 'Indah Permata', 'Jihan Aulia',
            'Kirana Putri', 'Lestari Wulandari', 'Maya Sari', 'Nisa Rahmawati', 'Olivia Damayanti',
            'Putri Maharani', 'Qonita Zahira', 'Rina Susanti', 'Sari Dewi', 'Tika Rahayu',
            'Ulfa Khoirunnisa', 'Vina Melinda', 'Wulan Dari', 'Xenia Putri', 'Yuni Astuti', 'Zahra Amelia'
        ];

        // Daftar nama orang tua
        $namaOrangTuaPria = [
            'Bapak Sutrisno', 'Bapak Bambang', 'Bapak Agus', 'Bapak Hendra', 'Bapak Joko',
            'Bapak Rudi', 'Bapak Andi', 'Bapak Dedi', 'Bapak Eko', 'Bapak Fajar'
        ];

        $namaOrangTuaWanita = [
            'Ibu Siti', 'Ibu Rina', 'Ibu Dewi', 'Ibu Sri', 'Ibu Ani',
            'Ibu Wati', 'Ibu Yuni', 'Ibu Lestari', 'Ibu Maya', 'Ibu Indah'
        ];

        for ($i = 0; $i < $count; $i++) {
            $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);

            // Generate unique NIS
            do {
                $nis = $this->faker->numerify('2024####');
            } while (in_array($nis, $usedNis));
            $usedNis[] = $nis;

            // Generate unique code
            do {
                $uniqueCode = $this->faker->uuid();
            } while (in_array($uniqueCode, $usedUniqueCodes));
            $usedUniqueCodes[] = $uniqueCode;

            // Pilih nama berdasarkan gender
            if ($gender == 'Laki-laki') {
                $nama = $this->faker->randomElement($namaPria);
            } else {
                $nama = $this->faker->randomElement($namaWanita);
            }

            // Generate nama orang tua
            $namaAyah = $this->faker->randomElement($namaOrangTuaPria);
            $namaIbu = $this->faker->randomElement($namaOrangTuaWanita);
            $namaOrangTua = $namaAyah . ' & ' . $namaIbu;

            // Generate alamat Indonesia yang realistis
            $jalan = $this->faker->randomElement([
                'Jl. Merdeka', 'Jl. Sudirman', 'Jl. Diponegoro', 'Jl. Ahmad Yani', 'Jl. Gatot Subroto',
                'Jl. Pahlawan', 'Jl. Kartini', 'Jl. Veteran', 'Jl. Pemuda', 'Jl. Raya'
            ]);
            $nomor = $this->faker->numberBetween(1, 999);
            $kelurahan = $this->faker->randomElement([
                'Kelurahan Sumber', 'Kelurahan Makmur', 'Kelurahan Sejahtera', 'Kelurahan Indah',
                'Kelurahan Damai', 'Kelurahan Jaya', 'Kelurahan Sentosa', 'Kelurahan Asri'
            ]);
            $kecamatan = $this->faker->randomElement([
                'Kecamatan Pusat', 'Kecamatan Timur', 'Kecamatan Barat', 'Kecamatan Utara', 'Kecamatan Selatan'
            ]);
            $alamat = $jalan . ' No. ' . $nomor . ', ' . $kelurahan . ', ' . $kecamatan;

            // Tahun masuk berdasarkan kelas
            $kelasData = $this->faker->randomElement($this->kelas);
            $kelasNama = $kelasData['kelas'];

            if ($kelasNama == 'X') {
                $tahunMasuk = date('Y');  // Kelas X = tahun ini
            } elseif ($kelasNama == 'XI') {
                $tahunMasuk = date('Y') - 1;  // Kelas XI = tahun lalu
            } else {  // XII
                $tahunMasuk = date('Y') - 2;  // Kelas XII = 2 tahun lalu
            }

            array_push($data, [
                'nis' => $nis,
                'nama_siswa' => $nama,
                'id_kelas' => $kelasData['id_kelas'],
                'jenis_kelamin' => $gender,
                'no_hp' => $this->faker->numerify('08##########'),
                'foto' => null,  // Akan diisi nanti jika diperlukan
                'nama_orang_tua' => $namaOrangTua,
                'alamat' => $alamat,
                'tahun_masuk' => $tahunMasuk,
                'unique_code' => $uniqueCode
            ]);
        }

        return $data;
    }
}
