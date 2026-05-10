<?php

function caesar_cipher($text, $key, $is_encrypt = true) {
    $result = "";
    $key = $key % 26;
    if (!$is_encrypt) $key = 26 - $key;

    foreach (str_split($text) as $char) {
        if (ctype_alpha($char)) {
            $offset = ctype_upper($char) ? ord('A') : ord('a');
            $result .= chr((ord($char) + $key - $offset) % 26 + $offset);
        } else {
            $result .= $char;
        }
    }
    return $result;
}

function vigenere_cipher($text, $key, $is_encrypt = true) {
    $result = "";
    $key = strtoupper($key);
    $keyLen = strlen($key);
    if ($keyLen == 0) return $text;

    $j = 0;
    foreach (str_split($text) as $char) {
        if (ctype_alpha($char)) {
            $offset = ctype_upper($char) ? ord('A') : ord('a');
            $k = ord($key[$j % $keyLen]) - ord('A');
            
            if (!$is_encrypt) $k = 26 - $k;
            
            $result .= chr((ord($char) + $k - $offset) % 26 + $offset);
            $j++;
        } else {
            $result .= $char;
        }
    }
    return $result;
}

$output = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'] ?? '';
    $algo = $_POST['algo'] ?? 'caesar';
    $key = $_POST['key'] ?? '';
    $action = $_POST['action'] ?? 'encrypt';

    if ($algo === 'caesar') {
        $output = caesar_cipher($message, (int)$key, ($action === 'encrypt'));
    } else {
        $output = vigenere_cipher($message, $key, ($action === 'encrypt'));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cipher-Core Professional | Cryptography Tool</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: #f8fafc; display: flex; justify-content: center; padding: 50px; }
        .container { background: #1e293b; padding: 2rem; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.5); width: 100%; max-width: 600px; border: 1px solid #334155; }
        h2 { color: #38bdf8; border-bottom: 2px solid #334155; padding-bottom: 10px; }
        textarea, input, select { width: 100%; padding: 12px; margin: 10px 0; border-radius: 4px; border: 1px solid #334155; background: #0f172a; color: white; box-sizing: border-box; }
        .btn-group { display: flex; gap: 10px; margin-top: 10px; }
        button { flex: 1; padding: 12px; cursor: pointer; border: none; border-radius: 4px; font-weight: bold; transition: 0.3s; }
        .btn-enc { background: #0284c7; color: white; }
        .btn-dec { background: #059669; color: white; }
        button:hover { opacity: 0.8; }
        .result-box { margin-top: 20px; padding: 15px; background: #334155; border-left: 4px solid #38bdf8; word-wrap: break-word; }
        footer { margin-top: 20px; font-size: 0.8rem; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>Cipher Engine v1.0</h2>
    <form method="post">
        <label>Pilih Algoritma:</label>
        <select name="algo" id="algo" onchange="toggleKeyType()">
            <option value="caesar">Caesar Cipher (Key: Angka)</option>
            <option value="vigenere">Vigenère Cipher (Key: Huruf)</option>
        </select>

        <label>Pesan (Plaintext/Ciphertext):</label>
        <textarea name="message" rows="5" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

        <label id="keyLabel">Kunci (Key):</label>
        <input type="text" name="key" id="keyInput" placeholder="Masukkan angka (Caesar) atau kata (Vigenere)" required value="<?php echo htmlspecialchars($_POST['key'] ?? ''); ?>">

        <div class="btn-group">
            <button type="submit" name="action" value="encrypt" class="btn-enc">ENKRIPSI</button>
            <button type="submit" name="action" value="decrypt" class="btn-dec">DEKRIPSI</button>
        </div>
    </form>

    <?php if ($output !== ""): ?>
        <div class="result-box">
            <strong>Hasil:</strong><br>
            <p><?php echo htmlspecialchars($output); ?></p>
        </div>
    <?php endif; ?>

    <footer>
        Dibuat dengan Laragon & Antigravity<br>
        &copy; 2026 - Informatika Professional
    </footer>
</div>

<script>
function toggleKeyType() {
    const algo = document.getElementById('algo').value;
    const keyInput = document.getElementById('keyInput');
    keyInput.type = (algo === 'caesar') ? 'number' : 'text';
}
toggleKeyType();
</script>

</body>
</html>