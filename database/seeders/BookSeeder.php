<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Harry Potter and the Sorcerer\'s Stone',
            'author' => 'J.K. Rowling',
            'year' => 1997,
            'cover' => 'Harry-Potter-1.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Di hari ulang tahunnya yang kesebelas, Harry Potter, seorang yatim piatu yang tinggal bersama bibi dan paman yang kejam, mengetahui bahwa ia adalah seorang penyihir dan diundang untuk bersekolah di Sekolah Sihir Hogwarts. Di sana, ia belajar sihir, bertemu teman-teman baik, dan mengungkap misteri di balik kematian orang tuanya serta keberadaan penyihir jahat, Lord Voldemort.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Chamber of Secrets',
            'author' => 'J.K. Rowling',
            'year' => 1998,
            'cover' => 'Harry-Potter-2.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Tahun kedua Harry di Hogwarts diwarnai oleh serangkaian kejadian aneh. Ada makhluk misterius yang menyerang murid-murid dan legenda tentang Kamar Rahasia yang konon menyimpan monster kuno. Harry dan teman-temannya harus mengungkap kebenaran di balik legenda ini untuk melindungi Hogwarts dari ancaman yang tersembunyi.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Prisoner of Azkaban',
            'author' => 'J.K. Rowling',
            'year' => 1999,
            'cover' => 'Harry-Potter-3.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Harry kembali ke Hogwarts untuk tahun ketiganya. Kali ini, ia harus berhadapan dengan Sirius Black, seorang tahanan yang melarikan diri dari penjara Azkaban yang terkenal angker. Sirius diyakini sebagai pengikut setia Voldemort dan mengincar nyawa Harry. Namun, seiring berjalannya waktu, Harry menyadari bahwa ada kebenaran yang lebih kompleks di balik sosok Sirius Black.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Goblet of Fire',
            'author' => 'J.K. Rowling',
            'year' => 2000,
            'cover' => 'Harry-Potter-4.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Tahun keempat Harry di Hogwarts diwarnai oleh Turnamen Triwizard, sebuah kompetisi sihir berbahaya yang diikuti oleh tiga sekolah sihir. Harry secara misterius terpilih sebagai salah satu peserta, meskipun ia tidak mendaftarkan diri. Ia harus menghadapi berbagai tantangan berat dan mengungkap misteri di balik pemilihan namanya.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Order of the Phoenix',
            'author' => 'J.K. Rowling',
            'year' => 2003,
            'cover' => 'Harry-Potter-5.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Kembalinya Lord Voldemort tidak diakui oleh Kementerian Sihir. Harry dan teman-temannya membentuk kelompok rahasia bernama Laskar Dumbledore untuk melawan Voldemort dan pengikutnya. Mereka harus berjuang untuk membuktikan kebenaran dan menghadapi berbagai rintangan dari Kementerian Sihir yang korup.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Half-Blood Prince',
            'author' => 'J.K. Rowling',
            'year' => 2005,
            'cover' => 'Harry-Potter-6.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Tahun keenam Harry di Hogwarts dipenuhi dengan misteri dan ketegangan. Ia menemukan buku catatan milik Pangeran Berdarah Campuran yang berisi mantra-mantra berbahaya. Sementara itu, Voldemort semakin kuat dan mempersiapkan serangan terakhirnya ke Hogwarts.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Deathly Hallows',
            'author' => 'J.K. Rowling',
            'year' => 2007,
            'cover' => 'Harry-Potter-7.jpg',
            'genre' => 'Fantasi',
            'synopsis' => 'Petualangan terakhir Harry dan teman-temannya membawanya dalam pencarian Relikui Kematian, tiga benda sihir legendaris yang konon bisa membuat pemiliknya abadi. Mereka harus berpacu dengan waktu untuk menemukan Relikui Kematian sebelum Voldemort mendapatkannya. Pertempuran terakhir antara Harry dan Voldemort pun tak terhindarkan.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Kambing Jantan',
            'author' => 'Raditya Dika',
            'year' => 2006,
            'cover' => 'kambing_jantan.jpg',
            'genre' => 'Komedi',
            'synopsis' => 'Kumpulan catatan harian konyol dan lucu Raditya Dika selama kuliah di Australia, penuh dengan tingkah laku "kambing jantan"-nya dalam menjalani kehidupan sebagai mahasiswa rantau.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Cinta Brontosaurus',
            'author' => 'Raditya Dika',
            'year' => 2006,
            'cover' => 'cinta_brontosaurus.jpg',
            'genre' => 'Komedi',
            'synopsis' => 'Kisah-kisah kocak seputar cinta dan kehidupan, mulai dari pengalaman naksir teman SD, cinta ditolak, sampai lika-liku menjalani hubungan jarak jauh. Semua disajikan dengan gaya bahasa khas Raditya Dika yang lucu dan menghibur.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Radikus MakanKakus',
            'author' => 'Raditya Dika',
            'year' => 2007,
            'cover' => 'radikus_makankakus.jpg',
            'genre' => 'Komedi',
            'synopsis' => 'Perjalanan kocak Radikus dalam mencari cinta sejatinya. Mulai dari pengalaman kencan buta yang aneh, sampai usaha mendapatkan cinta dari cewek yang ternyata sudah punya pacar. Semua disajikan dengan gaya bahasa yang jenaka dan penuh tawa.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Marmut Merah Jambu',
            'author' => 'Raditya Dika',
            'year' => 2008,
            'cover' => 'marmut_merah_jambu.jpg',
            'genre' => 'Komedi',
            'synopsis' => 'Kumpulan kisah-kisah lucu dan mengharukan tentang masa-masa SMA. Mulai dari pengalaman cinta monyet, persahabatan, sampai kenakalan-kenakalan khas anak SMA. Semua disajikan dengan gaya bahasa yang ringan dan penuh nostalgia.',
            'is_available' => true,
        ]);

        Book::create([
            'title' => 'Manusia Setengah Salmon',
            'author' => 'Raditya Dika',
            'year' => 2011,
            'cover' => 'manusia_setengah_salmon.jpg',
            'genre' => 'Komedi',
            'synopsis' => 'Kisah-kisah absurd dan lucu tentang kehidupan sehari-hari, mulai dari pengalaman pindah rumah, sampai lika-liku menjadi seorang penulis. Semua disajikan dengan gaya bahasa khas Raditya Dika yang penuh humor dan sindiran.',
            'is_available' => true,
        ]);
    }
}
