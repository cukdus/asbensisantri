<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class GuruSeeder extends Seeder
{
    private \Faker\Generator $faker;
    private array $usedNuptks = [];
    private array $usedUniqueCodes = [];
    private array $usedEmails = [];
    private array $usedUsernames = [];

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        $this->faker = \Faker\Factory::create('id_ID');
    }

    public function run()
    {
        // Delete existing guru users (keep superadmin)
        $this->db->table('users')->where('role', 'guru')->delete();

        // Insert new guru data
        $guruData = $this->createGuru(5);
        $batchSize = 5;

        for ($i = 0; $i < count($guruData); $i += $batchSize) {
            $batch = array_slice($guruData, $i, $batchSize);
            $this->db->table('users')->insertBatch($batch);
        }

        echo '✅ GuruSeeder: ' . count($guruData) . " guru berhasil ditambahkan ke tabel users\n";
    }

    protected function createGuru($count = 1)
    {
        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
            $nuptk = $this->generateUniqueNuptk();
            $uniqueCode = $this->generateUniqueCode();

            // Generate realistic teacher names
            $firstName = $gender === 'Laki-laki' ? $this->faker->firstNameMale() : $this->faker->firstNameFemale();
            $lastName = $this->faker->lastName();
            $title = $this->faker->randomElement(['', 'S.Pd', 'S.Pd.', 'M.Pd', 'M.Pd.', 'Drs.', 'Dra.']);

            $namaLengkap = $firstName . ' ' . $lastName;
            if ($title) {
                $namaLengkap = $title . ' ' . $namaLengkap;
            }

            // Generate unique email and username
            $email = $this->generateUniqueEmail($firstName, $lastName);
            $username = $this->generateUniqueUsername($firstName, $lastName);

            array_push($data, [
                'email' => $email,
                'username' => $username,
                'password_hash' => password_hash('123456', PASSWORD_DEFAULT),  // Default password
                'nuptk' => $nuptk,
                'nama_lengkap' => $namaLengkap,
                'jenis_kelamin' => $gender,
                'alamat' => $this->faker->address(),
                'no_hp' => $this->generatePhoneNumber(),
                'foto' => null,  // Foto akan diupload nanti melalui interface admin
                'unique_code' => $uniqueCode,
                'role' => 'guru',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $data;
    }

    private function generateUniqueNuptk(): string
    {
        do {
            // Generate NUPTK format: 16 digits
            $nuptk = $this->faker->numerify('################');
        } while (in_array($nuptk, $this->usedNuptks));

        $this->usedNuptks[] = $nuptk;
        return $nuptk;
    }

    private function generateUniqueCode(): string
    {
        do {
            $uniqueCode = $this->faker->uuid();
        } while (in_array($uniqueCode, $this->usedUniqueCodes));

        $this->usedUniqueCodes[] = $uniqueCode;
        return $uniqueCode;
    }

    private function generateUniqueEmail(string $firstName, string $lastName): string
    {
        $baseEmail = strtolower($firstName . '.' . $lastName);
        $baseEmail = str_replace(' ', '', $baseEmail);
        $counter = 1;

        do {
            $email = $counter === 1 ? $baseEmail . '@sekolah.com' : $baseEmail . $counter . '@sekolah.com';
            $counter++;
        } while (in_array($email, $this->usedEmails));

        $this->usedEmails[] = $email;
        return $email;
    }

    private function generateUniqueUsername(string $firstName, string $lastName): string
    {
        $baseUsername = strtolower($firstName . $lastName);
        $baseUsername = str_replace(' ', '', $baseUsername);
        $counter = 1;

        do {
            $username = $counter === 1 ? $baseUsername : $baseUsername . $counter;
            $counter++;
        } while (in_array($username, $this->usedUsernames));

        $this->usedUsernames[] = $username;
        return $username;
    }

    private function generatePhoneNumber(): string
    {
        $providers = ['0811', '0812', '0813', '0821', '0822', '0823', '0851', '0852', '0853'];
        $provider = $this->faker->randomElement($providers);
        $number = $this->faker->numerify('########');
        return $provider . $number;
    }
}
