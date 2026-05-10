<?php
$e = 7; $d = 103; $n = 143;

$hasil = "";
$pesan = isset($_POST['pesan']) ? $_POST['pesan'] : "";
$aksi  = isset($_POST['aksi']) ? $_POST['aksi'] : "enkripsi";

if (isset($_POST['proses']) && !empty($pesan)) {
    if ($aksi == "enkripsi") {
        $raw = "";
        for ($i = 0; $i < strlen($pesan); $i++) {
            $raw .= chr(bcpowmod(ord($pesan[$i]), $e, $n));
        }
        $hasil = base64_encode($raw);
    } else {
        $data = base64_decode($pesan);
        $res = "";
        for ($i = 0; $i < strlen($data); $i++) {
            $res .= chr(bcpowmod(ord($data[$i]), $d, $n));
        }
        $hasil = $res;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Kriptografi RSA | Versi Alternatif</title>
    <style>
        :root { 
            --primary: #10b981; 
            --primary-dark: #059669;
            --bg-light: #f0fdf4; 
        }
        
        body { 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            background: var(--bg-light); 
            display: flex; 
            justify-content: center; 
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container { 
            background: white; 
            padding: 35px; 
            border-radius: 20px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 450px;
            border-top: 10px solid var(--primary);
        }

        h2 { 
            color: #064e3b; 
            text-align: center; 
            margin-bottom: 10px;
            font-size: 24px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 0.85em;
            margin-bottom: 25px;
        }

        .key-badge { 
            background: #ecfdf5; 
            border: 1px solid #a7f3d0; 
            padding: 12px; 
            border-radius: 12px; 
            font-size: 12px; 
            margin-bottom: 25px; 
            text-align: center;
            color: #047857;
        }

        .input-group { margin-bottom: 20px; }

        label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 8px; 
            color: #374151;
            font-size: 14px;
        }

        input[type="text"], select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e5e7eb; 
            border-radius: 10px; 
            box-sizing: border-box;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus {
            border-color: var(--primary);
            outline: none;
        }

        button { 
            width: 100%; 
            padding: 14px; 
            background: var(--primary); 
            color: white; 
            border: none; 
            border-radius: 10px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: all 0.3s;
            font-size: 16px;
        }

        button:hover { 
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .result-box { 
            margin-top: 30px; 
            padding: 15px; 
            background: #f9fafb; 
            border-radius: 12px; 
            border: 1px solid #e5e7eb;
        }

        .result-box label { color: #6b7280; font-size: 12px; text-transform: uppercase; }

        .hasil-text { 
            font-family: 'Consolas', 'Courier New', monospace; 
            word-break: break-all; 
            font-weight: bold; 
            font-size: 1.2em; 
            color: #111827; 
            margin-top: 5px;
        }

        .footer { 
            text-align: center; 
            margin-top: 30px; 
            font-size: 11px; 
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>RSA Security</h2>
        <p class="subtitle"> Tugas Kriptografi - Iqbal Syafra Dilla</p>
        
        <div class="key-badge">
            <strong>Public Key Alice:</strong><br>
            e: <?php echo $e; ?> | n: <?php echo $n; ?>
        </div>

        <form method="post">
            <div class="input-group">
                <label>Input Pesan / Ciphertext</label>
                <input type="text" name="pesan" placeholder="Ketik di sini..." value="<?php echo htmlspecialchars($pesan); ?>" required>
            </div>

            <div class="input-group">
                <label>Pilih Operasi</label>
                <select name="aksi">
                    <option value="enkripsi" <?php echo $aksi=='enkripsi'?'selected':''; ?>>Enkripsi (Kirim Pesan)</option>
                    <option value="dekripsi" <?php echo $aksi=='dekripsi'?'selected':''; ?>>Dekripsi (Baca Pesan)</option>
                </select>
            </div>

            <button type="submit" name="proses">Proses Sekarang</button>
        </form>

        <?php if($hasil): ?>
        <div class="result-box">
            <label>Output Hasil:</label>
            <div class="hasil-text"><?php echo $hasil; ?></div>
        </div>
        <?php endif; ?>

        <div class="footer">
            Informatika 2026 - Universitas Muhammadiyah Pontianak
        </div>
    </div>
</body>
</html>