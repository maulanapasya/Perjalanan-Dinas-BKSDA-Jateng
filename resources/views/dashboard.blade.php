@include('headerMain')
<head>
    <title>Dashboard</title>
</head>

<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
{{-- <div class="card">
    <div class="card-header" id="dashboardHeader">Sambutan Kepala Balai</div>
    <div class="card-body" id="dashboardBody">
        <div class="dashboard-flex">
            <div>
                <img id="balai" src="<?php echo asset('img/gedung_ksda_jateng.jpg') ?>" alt="Balai KSDA Jateng" />
            </div>
            <div class="cold-md-9" id="welcome-message">
                <p id="welcome-paragraph">
                Puji syukur kami panjatkan kepada Tuhan Yang Maha Kuasa karena
                berkat rahmat dan karunia-Nya. Sistem Informasi Perjalanan
                Dinas Balai Konservasi Sumber Daya Alam Jawa Tengah akhirnya
                bisa terwujud. Dengan hadirnya sistem informasi ini, Balai
                Konservasi Sumber Daya Alam Jawa Tengah sedang berupaya untuk
                meningkatkan pengelolaan data. Akhirnya, selamat berkunjung ke
                sistem kami, semoga kita semua selalu dalam Lindungan Tuhan
                Yang Maha Kuasa.
                </p>
                </br>
                <p class="signature">
                Semarang, April 2024<br />
                <br>
                <br>
                <strong>Darmanto, S.P., M.AP.</strong><br />
                Kepala Balai Konservasi Sumber Daya Alam Jawa Tengah
                </p>
            </div>
        </div>
    </div>
</div> --}}

<div id="dashboard-container" class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-center bg-light">
            <h5>Sambutan Kepala Balai</h5>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Bagian Gambar -->
                <div class="col-md-4 text-center">
                    <img id="balai" src="<?php echo asset('img/gedung_ksda_jateng.jpg') ?>" class="img-fluid rounded" alt="Balai KSDA Jateng">
                </div>
                <!-- Bagian Teks -->
                <div class="col-md-8" id="welcome-message">
                    <p id="welcome-paragraph">
                        Puji syukur kami panjatkan kepada Tuhan Yang Maha Kuasa karena
                        berkat rahmat dan karunia-Nya. Sistem Informasi Perjalanan
                        Dinas Balai Konservasi Sumber Daya Alam Jawa Tengah akhirnya
                        bisa terwujud. Dengan hadirnya sistem informasi ini, Balai
                        Konservasi Sumber Daya Alam Jawa Tengah sedang berupaya untuk
                        meningkatkan pengelolaan data. Akhirnya, selamat berkunjung ke
                        sistem kami, semoga kita semua selalu dalam Lindungan Tuhan
                        Yang Maha Kuasa.
                    </p>
                    <br>
                    <p class="text-end signature">
                        Semarang, Mei 2024<br>
                        <br>
                        <br>
                        <strong>Darmanto, S.P., M.AP.</strong><br>
                        Kepala Balai Konservasi Sumber Daya Alam Jawa Tengah
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>