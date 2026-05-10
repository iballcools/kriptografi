<?php

function generateKey() {
    return bin2hex(random_bytes(16));
}

function signData($data, $key) {
    return hash_hmac('sha256', $data, $key);
}

function verifyData($data, $key, $signature) {
    $check = hash_hmac('sha256', $data, $key);
    return hash_equals($check, $signature);
}


$status = "";
$type = "";
$key = $_POST['key'] ?? '';
$doc = $_POST['doc'] ?? 'Transfer ke Budi: Rp 100.000';
$sig = $_POST['sig'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn_gen'])) {
        $key = generateKey();
        $status = "NEW KEY GENERATED";
        $type = "info";
    } elseif (isset($_POST['btn_sign'])) {
        if (!$key) {
            $status = "ERROR: KEY IS MISSING";
            $type = "error";
        } else {
            $sig = signData($doc, $key);
            $status = "DOCUMENT SIGNED SUCCESSFULLY";
            $type = "success";
        }
    } elseif (isset($_POST['btn_verif'])) {
        if (verifyData($doc, $key, $sig)) {
            $status = "VERIFICATION SUCCESS: DATA AUTHENTIC";
            $type = "success";
        } else {
            $status = "VERIFICATION FAILED: DATA CORRUPTED (MITM DETECTED)!";
            $type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptoVerify - Terminal Edition</title>
    <style>
        :root {
            --bg: #0f172a;
            --card: #1e293b;
            --accent: #38bdf8;
            --green: #22c55e;
            --red: #ef4444;
            --text: #f1f5f9;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Monaco', 'Consolas', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: var(--card);
            width: 90%;
            max-width: 500px;
            padding: 30px;
            border-radius: 8px;
            border-top: 4px solid var(--accent);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 { font-size: 1.5rem; margin: 0; color: var(--accent); }
        .header p { font-size: 0.8rem; opacity: 0.7; }

        .console-status {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            text-transform: uppercase;
            border-left: 4px solid transparent;
            background: rgba(0,0,0,0.2);
        }

        .info { border-color: var(--accent); color: var(--accent); }
        .success { border-color: var(--green); color: var(--green); }
        .error { border-color: var(--red); color: var(--red); }

        label { display: block; margin-bottom: 8px; font-size: 0.75rem; color: var(--accent); }

        input, textarea {
            width: 100%;
            background: #0f172a;
            border: 1px solid #334155;
            color: #38bdf8;
            padding: 12px;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-family: inherit;
        }

        textarea { height: 80px; resize: none; }

        .actions { display: flex; flex-direction: column; gap: 10px; }
        
        .btn {
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-family: inherit;
            transition: 0.3s;
        }

        .btn-main { background: var(--accent); color: var(--bg); }
        .btn-outline { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
        .btn-danger { background: var(--red); color: white; }

        .btn:hover { opacity: 0.8; transform: scale(0.98); }

        .footer { text-align: center; margin-top: 20px; font-size: 0.7rem; opacity: 0.5; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Web Verifikator Dokumen</h1>
        <p>Tugas Praktikum Kriptografi - Iqbal Syafra Dilla</p>
    </div>

    <?php if ($status): ?>
        <div class="console-status <?php echo $type; ?>">
            > <?php echo $status; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Security Key</label>
        <div style="display: flex; gap: 5px;">
            <input type="text" name="key" value="<?php echo $key; ?>" placeholder="Waiting for key..." readonly>
            <button type="submit" name="btn_gen" class="btn btn-main" style="height: 45px;">GEN</button>
        </div>

        <label>Document Content</label>
        <textarea name="doc"><?php echo htmlspecialchars($doc); ?></textarea>

        <label>Digital Signature</label>
        <input type="text" name="sig" value="<?php echo $sig; ?>" readonly>

        <div class="actions">
            <button type="submit" name="btn_sign" class="btn btn-outline">Execute Signature</button>
            <button type="submit" name="btn_verif" class="btn btn-danger">Authenticity Verivication</button>
        </div>
    </form>

</body>
</html>