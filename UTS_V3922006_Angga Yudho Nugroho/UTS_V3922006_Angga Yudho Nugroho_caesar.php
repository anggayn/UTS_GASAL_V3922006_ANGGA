<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

       
        h2 {
            margin-top: 20px;
            text-align: center; /* Center the h2 element */
        }

        p {
            font-size: 18px;
            text-align: center; /* Center the paragraph element */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
// Tabel substitusi karakter
$encryptionTable = [
    'A' => 'A',
    'B' => 'N',
    'C' => 'G',
    'D' => 'B',
    'E' => 'C',
    'F' => 'D',
    'G' => 'E',
    'H' => 'F',
    'I' => 'H',
    'J' => 'I',
    'K' => 'J',
    'L' => 'K',
    'M' => 'L',
    'N' => 'M',
    'O' => 'O',
    'P' => 'P',
    'Q' => 'Q',
    'R' => 'R',
    'S' => 'S',
    'T' => 'T',
    'U' => 'U',
    'V' => 'V',
    'W' => 'W',
    'X' => 'X',
    'Y' => 'Y',
    'Z' => 'Z'
];

// Fungsi untuk mengenkripsi teks
function encryptText($text, $table) {
    $encryptedText = "";
    $text = strtoupper($text); // Konversi teks ke huruf besar

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        // Periksa apakah karakter ada dalam tabel substitusi
        if (array_key_exists($char, $table)) {
            $encryptedText .= $table[$char];
        } else {
            // Jika karakter tidak ada dalam tabel substitusi, biarkan karakter asli
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

// Fungsi untuk mendekripsi teks
function decryptText($text, $table) {
    $decryptedText = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        // Cari karakter asli dalam tabel substitusi
        $originalChar = array_search($char, $table);
        if ($originalChar !== false) {
            $decryptedText .= $originalChar;
        } else {
            // Jika karakter tidak ada dalam tabel substitusi, biarkan karakter asli
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

// Inisialisasi variabel
$text = "";
$processedText = "";
$operation = "encrypt"; // Default operation is encryption

// Memproses input saat formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["text"];
    $operation = $_POST["operation"];

    if ($operation == "encrypt") {
        $processedText = encryptText($text, $encryptionTable);
    } elseif ($operation == "decrypt") {
        $processedText = decryptText($text, $encryptionTable);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
</head>
<body>
    <h1>Enkripsi dan Dekripsi Teks Menggunakan Caesar Chiper</h1>
    <form method="post" action="">
        <label for="text">Masukkan Teks:</label>
        <input type="text" id="text" name="text" value="<?php echo $text; ?>">
        
        <!-- Tambahkan radio button untuk memilih enkripsi atau dekripsi -->
        <input type="radio" name="operation" value="encrypt" <?php if ($operation == "encrypt") echo "checked"; ?>> Enkripsi
        <input type="radio" name="operation" value="decrypt" <?php if ($operation == "decrypt") echo "checked"; ?>> Dekripsi

        <input type="submit" value="Proses">
    </form>

    <?php if (!empty($processedText)) : ?>
        <?php if ($operation == "encrypt") : ?>
            <h2>Hasil Enkripsi:</h2>
        <?php elseif ($operation == "decrypt") : ?>
            <h2>Hasil Dekripsi:</h2>
        <?php endif; ?>
        <p><?php echo $processedText; ?></p>
    <?php endif; ?>

    <a href="vigenere.php"><button>Enkripsi Tahap Kedua</button></a>
</body>
</html>
