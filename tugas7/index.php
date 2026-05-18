<?php
$output = "Silakan isi form dan klik Generate";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country      = strtoupper(trim((string)$_POST['country']));
    $state        = trim((string)$_POST['state']);
    $locality     = trim((string)$_POST['locality']);
    $organization = trim((string)$_POST['organization']);
    $commonName   = trim((string)$_POST['commonName']);

    $privKey = "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDQj\n[Simulated RSA 2048-bit Key for " . $commonName . "]\n-----END PRIVATE KEY-----";
    
    $cert = "-----BEGIN CERTIFICATE-----\nMIIDpTCCAo2gAwIBAgIUL3k8VzY1MzAyOTM4NDY0NTI3ODIwMTkwDQY\n[Generated for: " . $organization . "]\n[Location: " . $locality . ", " . $country . "]\n-----END CERTIFICATE-----";

    $output = "IDENTITAS CSR BERHASIL DISUSUN:\n";
    $output .= "C=$country, ST=$state, L=$locality, O=$organization, CN=$commonName\n\n";
    $output .= "--- PRIVATE KEY ---\n" . $privKey . "\n\n";
    $output .= "--- CERTIFICATE (CRT) ---\n" . $cert;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SSL Generator | Praktikum</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; padding: 40px 0; }
        .container { width: 100%; max-width: 800px; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: #2c3e50; color: #fff; padding: 20px; text-align: center; }
        .content { padding: 30px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 5px; font-size: 13px; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; transition: 0.3s; }
        button:hover { background: #219150; }
        textarea { width: 100%; height: 350px; font-family: 'Courier New', monospace; background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 8px; resize: none; font-size: 11px; margin-top: 20px; border: none; line-height: 1.5; }
        .footer { text-align: center; padding: 15px; font-size: 11px; color: #95a5a6; background: #fafafa; border-top: 1px solid #eee; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2 style="margin:0;">SSL Generator v1.0</h2>
        <p style="margin:5px 0 0; font-size: 13px; opacity: 0.8;">Iqbal Syafra Dilla - Praktikum Kriptografi - Simulation Mode</p>
    </div>

    <div class="content">
        <form method="POST">
            <div class="form-grid">
                <div><label>Negara (ID)</label><input type="text" name="country" placeholder="Input Negara" required></div>
                <div><label>Provinsi</label><input type="text" name="state" placeholder="Input Provinsi" required></div>
                <div><label>Kota</label><input type="text" name="locality" placeholder="Input Kota" required></div>
                <div><label>Organisasi</label><input type="text" name="organization" placeholder="Input Nama Organisasi" required></div>
                <div style="grid-column: span 2;"><label>Common Name (Domain)</label><input type="text" name="commonName" placeholder="www.domain.com" required></div>
            </div>
            <button type="submit">Generate SSL</button>
        </form>

        <textarea readonly><?php echo htmlspecialchars($output); ?></textarea>
    </div>

    <div class="footer">
        © 2026 Praktikum Kriptografi.
    </div>
</div>

</body>
</html>
