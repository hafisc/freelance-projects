<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [

            [
                'quiz_id' => 1,
                'question' => 'Gelombang secara fisis didefinisikan sebagai…',
                'option_a' => 'Getaran yang merambat membawa energi.',
                'option_b' => 'Perpindahan materi dari satu tempat ke tempat lain.',
                'option_c' => 'Gerak lurus beraturan partikel medium.',
                'option_d' => 'Perubahan bentuk benda secara permanen.',
                'option_e' => 'Getaran tanpa membawa energi.',
                'answer' => 0
            ],

            [
                'quiz_id' => 1,
                'question' => 'Besaran yang menunjukkan simpangan maksimum suatu titik dari posisi setimbang disebut…',
                'option_a' => 'Periode',
                'option_b' => 'Frekuensi',
                'option_c' => 'Amplitudo',
                'option_d' => 'Panjang gelombang',
                'option_e' => 'Fase',
                'answer' => 2
            ],

            [
                'quiz_id' => 1,
                'question' => 'Periode gelombang 0,25 s. Frekuensinya adalah…',
                'option_a' => '0,25 Hz',
                'option_b' => '2 Hz',
                'option_c' => '4 Hz',
                'option_d' => '8 Hz',
                'option_e' => '40 Hz',
                'answer' => 2
            ],

            [
                'quiz_id' => 1,
                'question' => 'Hubungan v, λ, f yang benar adalah…',
                'option_a' => 'v = λ / f',
                'option_b' => 'v = f / λ',
                'option_c' => 'v = λ × f',
                'option_d' => 'v = λ × f²',
                'option_e' => 'v = f² / λ',
                'answer' => 2
            ],

            [
                'quiz_id' => 1,
                'question' => 'λ = 2 m, f = 5 Hz. Cepat rambatnya…',
                'option_a' => '0,4 m/s',
                'option_b' => '2,5 m/s',
                'option_c' => '7 m/s',
                'option_d' => '10 m/s',
                'option_e' => '20 m/s',
                'answer' => 3
            ],

            [
                'quiz_id' => 1,
                'question' => 'v = 340 m/s, f = 170 Hz. λ = …',
                'option_a' => '0,5 m',
                'option_b' => '1 m',
                'option_c' => '2 m',
                'option_d' => '4 m',
                'option_e' => '6 m',
                'answer' => 2
            ],

            [
                'quiz_id' => 1,
                'question' => 'Beda fase dua titik berjarak 0,5λ adalah…',
                'option_a' => 'π/2',
                'option_b' => 'π',
                'option_c' => '3π/2',
                'option_d' => '2π',
                'option_e' => '4π',
                'answer' => 1
            ],

            [
                'quiz_id' => 1,
                'question' => 'Jika jarak menjadi 2x, intensitas menjadi…',
                'option_a' => '2x',
                'option_b' => '1/2x',
                'option_c' => '1/4x',
                'option_d' => '4x',
                'option_e' => '8x',
                'answer' => 2
            ],

            [
                'quiz_id' => 1,
                'question' => 'Yang benar tentang gelombang adalah…',
                'option_a' => 'Memindahkan materi',
                'option_b' => 'Membawa energi tanpa memindahkan medium',
                'option_c' => 'Tidak membawa energi',
                'option_d' => 'Partikel selalu berpindah jauh',
                'option_e' => 'Tidak membutuhkan medium',
                'answer' => 1
            ],

            [
                'quiz_id' => 1,
                'question' => 'Yang bukan contoh gelombang adalah…',
                'option_a' => 'Bunyi',
                'option_b' => 'Cahaya',
                'option_c' => 'Riak air',
                'option_d' => 'Benda jatuh bebas',
                'option_e' => 'Gelombang radio',
                'answer' => 3
            ],

            [
                'quiz_id' => 2,
                'question' => 'Bunyi dapat terdengar oleh manusia karena…',
                'option_a' => 'Bunyi merambat tanpa medium',
                'option_b' => 'Adanya getaran yang merambat melalui medium',
                'option_c' => 'Bunyi adalah cahaya',
                'option_d' => 'Udara menghasilkan energi sendiri',
                'option_e' => 'Gelombang bunyi tidak bergerak',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Bunyi tidak dapat merambat di ruang hampa karena…',
                'option_a' => 'Tidak ada energi',
                'option_b' => 'Tidak ada medium perambatan',
                'option_c' => 'Frekuensi terlalu kecil',
                'option_d' => 'Tidak ada tekanan',
                'option_e' => 'Suhu terlalu rendah',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Gelombang bunyi termasuk jenis gelombang…',
                'option_a' => 'Transversal',
                'option_b' => 'Elektromagnetik',
                'option_c' => 'Longitudinal',
                'option_d' => 'Stasioner',
                'option_e' => 'Permukaan',
                'answer' => 2
            ],

            [
                'quiz_id' => 2,
                'question' => 'Bagian gelombang bunyi yang memiliki kerapatan maksimum disebut…',
                'option_a' => 'Regangan',
                'option_b' => 'Rapat',
                'option_c' => 'Puncak',
                'option_d' => 'Lembah',
                'option_e' => 'Fase',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Cepat rambat bunyi paling besar terjadi pada medium…',
                'option_a' => 'Gas',
                'option_b' => 'Udara',
                'option_c' => 'Cair',
                'option_d' => 'Padat',
                'option_e' => 'Vakum',
                'answer' => 3
            ],

            [
                'quiz_id' => 2,
                'question' => 'Jika frekuensi bunyi diperbesar, maka nada bunyi menjadi…',
                'option_a' => 'Lebih rendah',
                'option_b' => 'Lebih tinggi',
                'option_c' => 'Tetap',
                'option_d' => 'Menghilang',
                'option_e' => 'Lebih lambat',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Besar kecilnya kuat bunyi ditentukan oleh…',
                'option_a' => 'Frekuensi',
                'option_b' => 'Amplitudo',
                'option_c' => 'Periode',
                'option_d' => 'Panjang gelombang',
                'option_e' => 'Cepat rambat',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Peristiwa pemantulan bunyi yang terdengar jelas setelah bunyi asli disebut…',
                'option_a' => 'Gaung',
                'option_b' => 'Gema',
                'option_c' => 'Resonansi',
                'option_d' => 'Difraksi',
                'option_e' => 'Interferensi',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Gema dapat terdengar jika jarak pemantul minimal sekitar…',
                'option_a' => '5 m',
                'option_b' => '10 m',
                'option_c' => '17 m',
                'option_d' => '25 m',
                'option_e' => '50 m',
                'answer' => 2
            ],

            [
                'quiz_id' => 2,
                'question' => 'Alat musik gitar menghasilkan bunyi karena…',
                'option_a' => 'Tiupan udara',
                'option_b' => 'Getaran senar',
                'option_c' => 'Pemantulan cahaya',
                'option_d' => 'Perubahan suhu',
                'option_e' => 'Gesekan udara',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Cepat rambat bunyi di udara dipengaruhi oleh…',
                'option_a' => 'Warna udara',
                'option_b' => 'Suhu udara',
                'option_c' => 'Tekanan cahaya',
                'option_d' => 'Bentuk gelombang',
                'option_e' => 'Jumlah sumber bunyi',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Jika suhu udara meningkat, maka cepat rambat bunyi akan…',
                'option_a' => 'Menurun',
                'option_b' => 'Tetap',
                'option_c' => 'Meningkat',
                'option_d' => 'Hilangkan bunyi',
                'option_e' => 'Tidak berubah',
                'answer' => 2
            ],

            [
                'quiz_id' => 2,
                'question' => 'Fenomena perubahan frekuensi bunyi akibat gerak relatif disebut…',
                'option_a' => 'Efek Doppler',
                'option_b' => 'Resonansi',
                'option_c' => 'Interferensi',
                'option_d' => 'Difraksi',
                'option_e' => 'Refleksi',
                'answer' => 0
            ],

            [
                'quiz_id' => 2,
                'question' => 'Kotak resonansi pada alat musik berfungsi untuk…',
                'option_a' => 'Mempercepat bunyi',
                'option_b' => 'Memperkuat bunyi',
                'option_c' => 'Menghilangkan bunyi',
                'option_d' => 'Mengubah frekuensi',
                'option_e' => 'Menahan getaran',
                'answer' => 1
            ],

            [
                'quiz_id' => 2,
                'question' => 'Bunyi dengan frekuensi di atas 20.000 Hz disebut…',
                'option_a' => 'Audiosonik',
                'option_b' => 'Infrasonik',
                'option_c' => 'Ultrasonik',
                'option_d' => 'Hipersonik',
                'option_e' => 'Supersonik',
                'answer' => 2
            ],


            [
                'quiz_id' => 3,
                'question' => 'Sinar Matahari membentuk garis lurus di lantai membuktikan cahaya…',
                'option_a' => 'Dapat diuraikan',
                'option_b' => 'Dapat dipantulkan',
                'option_c' => 'Merambat lurus',
                'option_d' => 'Dibiaskan',
                'option_e' => 'Diserap',
                'answer' => 2
            ],

            [
                'quiz_id' => 3,
                'question' => 'Bayangan terbentuk karena…',
                'option_a' => 'Cahaya diserap',
                'option_b' => 'Cahaya diuraikan',
                'option_c' => 'Cahaya lurus dan terhalang',
                'option_d' => 'Cahaya dipantulkan',
                'option_e' => 'Cahaya dibiaskan',
                'answer' => 2
            ],

            [
                'quiz_id' => 3,
                'question' => 'Sudut datang 30° terhadap normal. Sudut pantulnya…',
                'option_a' => '15°',
                'option_b' => '30°',
                'option_c' => '45°',
                'option_d' => '60°',
                'option_e' => '90°',
                'answer' => 1
            ],

            [
                'quiz_id' => 3,
                'question' => 'Cahaya dari udara ke air akan dibiaskan…',
                'option_a' => 'Menjauhi normal',
                'option_b' => 'Sejajar normal',
                'option_c' => 'Mendekati normal',
                'option_d' => 'Berbalik',
                'option_e' => 'Tidak berubah',
                'answer' => 2
            ],

            [
                'quiz_id' => 3,
                'question' => 'Pensil tampak bengkok di air karena…',
                'option_a' => 'Pemantulan',
                'option_b' => 'Pembiasan',
                'option_c' => 'Dispersi',
                'option_d' => 'Interferensi',
                'option_e' => 'Difraksi',
                'answer' => 1
            ],

            [
                'quiz_id' => 3,
                'question' => 'Pelangi terjadi karena cahaya…',
                'option_a' => 'Dipantulkan',
                'option_b' => 'Dibiaskan',
                'option_c' => 'Dibiaskan, dipantulkan, diuraikan',
                'option_d' => 'Diserap',
                'option_e' => 'Difraksikan',
                'answer' => 2
            ],

            [
                'quiz_id' => 3,
                'question' => 'Urutan warna dari panjang gelombang terbesar ke terkecil adalah…',
                'option_a' => 'Ungu–…–Merah',
                'option_b' => 'Merah–…–Ungu',
                'option_c' => 'Merah–Kuning–Hijau',
                'option_d' => 'Ungu–Merah',
                'option_e' => 'Hijau–Merah',
                'answer' => 1
            ],

            [
                'quiz_id' => 3,
                'question' => 'Panjang gelombang kecil berarti…',
                'option_a' => 'Frekuensi kecil, energi kecil',
                'option_b' => 'Frekuensi kecil, energi besar',
                'option_c' => 'Frekuensi besar, energi besar',
                'option_d' => 'Frekuensi besar, energi kecil',
                'option_e' => 'Energi tetap',
                'answer' => 2
            ],

            [
                'quiz_id' => 3,
                'question' => 'Energi terbesar pada spektrum elektromagnetik dimiliki oleh…',
                'option_a' => 'Gelombang radio',
                'option_b' => 'Inframerah',
                'option_c' => 'Cahaya tampak',
                'option_d' => 'Sinar gamma',
                'option_e' => 'Ultraviolet',
                'answer' => 3
            ],

            [
                'quiz_id' => 3,
                'question' => 'Fatamorgana terjadi karena…',
                'option_a' => 'Pemantulan',
                'option_b' => 'Dispersi',
                'option_c' => 'Pembiasan oleh udara berbeda suhu',
                'option_d' => 'Penyerapan',
                'option_e' => 'Hamburan',
                'answer' => 2
            ],

            // ======================
// EVALUASI GABUNGAN (GELOMBANG, BUNYI, CAHAYA)
// quiz_id = 4
// ======================


    [
        'quiz_id' => 4,
        'sub_topik' => 'gelombang',
        'question' => 'Gelombang memiliki frekuensi 5 Hz dan panjang gelombang 2 m. Jika frekuensi menjadi dua kali lipat dan medium tetap, maka cepat rambat gelombang…',
        'option_a' => 'Tetap',
        'option_b' => 'Setengahnya',
        'option_c' => 'Dua kali lipat',
        'option_d' => 'Empat kali lipat',
        'option_e' => 'Nol',
        'answer' => 0
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'gelombang',
        'question' => 'Dua gelombang memiliki frekuensi sama tetapi amplitudo berbeda. Gelombang dengan amplitudo lebih besar akan…',
        'option_a' => 'Memiliki frekuensi lebih besar',
        'option_b' => 'Memiliki energi lebih besar',
        'option_c' => 'Memiliki cepat rambat lebih besar',
        'option_d' => 'Memiliki panjang gelombang lebih kecil',
        'option_e' => 'Tidak membawa energi',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'gelombang',
        'question' => 'Jika panjang gelombang diperbesar dua kali sedangkan cepat rambat tetap, maka frekuensi gelombang menjadi…',
        'option_a' => 'Tetap',
        'option_b' => 'Dua kali lipat',
        'option_c' => 'Setengahnya',
        'option_d' => 'Empat kali lipat',
        'option_e' => 'Nol',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'gelombang',
        'question' => 'Gelombang air yang melewati celah sempit kemudian menyebar menunjukkan sifat…',
        'option_a' => 'Refleksi',
        'option_b' => 'Refraksi',
        'option_c' => 'Difraksi',
        'option_d' => 'Interferensi',
        'option_e' => 'Resonansi',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'gelombang',
        'question' => 'Seorang siswa menyatakan gelombang memindahkan materi karena air bergerak maju. Analisis yang benar adalah…',
        'option_a' => 'Benar karena partikel berpindah',
        'option_b' => 'Benar jika amplitudo besar',
        'option_c' => 'Salah karena yang berpindah energi, bukan materi',
        'option_d' => 'Salah karena gelombang tidak membawa energi',
        'option_e' => 'Benar hanya pada gelombang bunyi',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Seorang penyelam mendengar bunyi lebih cepat di air dibanding udara karena…',
        'option_a' => 'Frekuensi lebih besar',
        'option_b' => 'Amplitudo lebih besar',
        'option_c' => 'Partikel medium lebih rapat',
        'option_d' => 'Suhu lebih tinggi',
        'option_e' => 'Tekanan lebih kecil',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Jika suhu udara meningkat maka cepat rambat bunyi akan…',
        'option_a' => 'Menurun',
        'option_b' => 'Tetap',
        'option_c' => 'Meningkat',
        'option_d' => 'Nol',
        'option_e' => 'Berubah acak',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Nada sirene ambulans terdengar lebih tinggi saat mendekat karena…',
        'option_a' => 'Amplitudo meningkat',
        'option_b' => 'Panjang gelombang bertambah',
        'option_c' => 'Frekuensi yang diterima meningkat',
        'option_d' => 'Cepat rambat meningkat',
        'option_e' => 'Energi berkurang',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Suara di aula kosong terdengar tidak jelas. Solusi terbaik adalah…',
        'option_a' => 'Memperbesar speaker',
        'option_b' => 'Meninggikan atap',
        'option_c' => 'Menambahkan bahan penyerap bunyi',
        'option_d' => 'Membuka jendela',
        'option_e' => 'Menambah sumber bunyi',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Kotak resonansi pada gitar berfungsi untuk…',
        'option_a' => 'Mempercepat bunyi',
        'option_b' => 'Memperkuat bunyi',
        'option_c' => 'Menghilangkan bunyi',
        'option_d' => 'Mengubah frekuensi',
        'option_e' => 'Menahan getaran',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Pensil terlihat bengkok di dalam air karena cahaya mengalami…',
        'option_a' => 'Pemantulan',
        'option_b' => 'Interferensi',
        'option_c' => 'Pembiasan',
        'option_d' => 'Difraksi',
        'option_e' => 'Dispersi',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Cahaya dari udara ke kaca akan dibiaskan dengan arah…',
        'option_a' => 'Menjauhi normal',
        'option_b' => 'Mendekati normal',
        'option_c' => 'Sejajar normal',
        'option_d' => 'Berbalik arah',
        'option_e' => 'Tidak berubah',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Pelangi terbentuk karena kombinasi peristiwa…',
        'option_a' => 'Pemantulan saja',
        'option_b' => 'Pembiasan saja',
        'option_c' => 'Pembiasan dan penguraian cahaya',
        'option_d' => 'Interferensi',
        'option_e' => 'Penyerapan cahaya',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Cahaya ungu memiliki energi lebih besar dibanding merah karena…',
        'option_a' => 'Amplitudo lebih besar',
        'option_b' => 'Frekuensi lebih kecil',
        'option_c' => 'Frekuensi lebih besar',
        'option_d' => 'Cepat rambat lebih besar',
        'option_e' => 'Panjang gelombang lebih besar',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Serat optik dapat mengirim data jarak jauh karena terjadi…',
        'option_a' => 'Difraksi total',
        'option_b' => 'Pemantulan total internal',
        'option_c' => 'Interferensi',
        'option_d' => 'Resonansi',
        'option_e' => 'Absorpsi',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Laser digunakan dalam operasi medis karena…',
        'option_a' => 'Lebih terang',
        'option_b' => 'Energi terfokus dan presisi tinggi',
        'option_c' => 'Panjang gelombang besar',
        'option_d' => 'Tidak menghasilkan panas',
        'option_e' => 'Murah digunakan',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Gelombang bunyi berbeda dengan cahaya karena bunyi…',
        'option_a' => 'Memiliki energi',
        'option_b' => 'Memerlukan medium untuk merambat',
        'option_c' => 'Memiliki frekuensi',
        'option_d' => 'Memiliki amplitudo',
        'option_e' => 'Memiliki panjang gelombang',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Jika jarak sumber bunyi menjadi dua kali, maka intensitas bunyi menjadi…',
        'option_a' => 'Dua kali',
        'option_b' => 'Setengahnya',
        'option_c' => 'Seperempatnya',
        'option_d' => 'Empat kali',
        'option_e' => 'Tetap',
        'answer' => 2
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'cahaya',
        'question' => 'Gelombang elektromagnetik dapat merambat di ruang hampa karena…',
        'option_a' => 'Memiliki amplitudo besar',
        'option_b' => 'Tidak memerlukan medium',
        'option_c' => 'Frekuensinya tinggi',
        'option_d' => 'Panjang gelombangnya kecil',
        'option_e' => 'Energinya kecil',
        'answer' => 1
    ],

    [
        'quiz_id' => 4,
        'sub_topik' => 'bunyi',
        'question' => 'Seorang teknisi memilih bahan peredam bunyi untuk studio rekaman. Keputusan ini bertujuan untuk…',
        'option_a' => 'Mempercepat rambatan bunyi',
        'option_b' => 'Mengurangi pemantulan bunyi',
        'option_c' => 'Meningkatkan frekuensi',
        'option_d' => 'Menambah energi bunyi',
        'option_e' => 'Mengubah panjang gelombang',
        'answer' => 1
    ]
];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
