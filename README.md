<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Bloga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .content-section {
            margin-bottom: 30px;
        }

        .content-section h2 {
            margin-bottom: 15px;
        }

        .content-section p {
            margin-bottom: 10px;
        }

        .steps {
            list-style-type: none;
            padding: 0;
        }

        .steps li {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <!-- Gambar di atas -->
        <img src="path/to/your/image.jpg" alt="Header Image" class="header-image">

        <!-- Bahasa Indonesia -->
        <div class="content-section">
            <h2>Bahasa Indonesia</h2>
            <p>Kami Telah Melakukan Yang Terbaik Untng Website bLog Kami Dan Kalian bisa support kami dengan dukung kami Untung Selalu Berkembang Dan Melanjutkan Website Terkait Website,kami Selalu update mingguan</p>
            <p>Fitur * bug * Tambahan Dll</p>
            <h3>Langkah-langkah</h3>
            <ul class="steps">
                <li>Website ini akan di publish jika seperjalan fitur sudah berjalan saya tidak akan menambahkan fitur like karena website ini di buat hanya untuk senang</li>
            </ul>
        </div>

        <!-- English Language -->
        <div class="content-section">
            <h2>English Language</h2>
            <p>We have done our best for our blog website and you can support us with our contract. Fortunately, we always develop and continue the website. Related websites, we always update weekly</p>
            <h3>Steps</h3>
            <ul class="steps">
                <li>This website will be published if the features are running, I will not add a like feature because this website was created just for fun.</li>
            </ul>
        </div>

        <!-- Japanese Language -->
        <div class="content-section">
            <h2>Japanese Language</h2>
            <p>私たちはブログウェブサイトのために最善を尽くしており、私たちをサポートすることで、関連ウェブサイトを常に開発および継続することができ、毎週更新されます。機能*バグ*追加など</p>
            <p>ありがとうございます私は嬉しいですね</p>
            <h3>ステップ</h3>
            <ul class="steps">
                <li>この Web サイトは機能が実行されていれば公開されます。この Web サイトはただ楽しむために作成されたものであるため、「いいね！」機能は追加しません</li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
