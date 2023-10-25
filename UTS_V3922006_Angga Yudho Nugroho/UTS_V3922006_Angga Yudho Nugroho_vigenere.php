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
function encryptText($text, $key) {
    $encryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; // Set default shift untuk karakter non-alphabet
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position + $shift) % 26;
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; // Karakter non-alphabet tidak diubah
        }
        
        $encryptedText .= $newChar;
    }
    
    return $encryptedText;
}

function decryptText($text, $key) {
    $decryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; // Set default shift untuk karakter non-alphabet
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position - $shift + 26) % 26;
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; // Karakter non-alphabet tidak diubah
        }
        
        $decryptedText .= $newChar;
    }
    
    return $decryptedText;
}




$text = ''; // Masukkan teks yang ingin dienkripsi/didekripsi di sini
$key = 'ANG'; // Kunci enkripsi

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["text"])) {
    $text = $_POST["text"];
    if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt") {
        $encryptedText = encryptText($text, $key);
    } elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") {
        $decryptedText = decryptText($text, $key);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
</head>
<body>
    <h1>Enkripsi dan Dekripsi Teks Menggunakan Vigenere Cipher</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="text">Masukkan teks:</label>
        <input type="text" name="text" id="text" value="<?php echo $text; ?>">
        <input type="radio" name="operation" value="encrypt" <?php if (!isset($_POST["operation"]) || (isset($_POST["operation"]) && $_POST["operation"] == "encrypt")) echo "checked"; ?>> Enkripsi
        <input type="radio" name="operation" value="decrypt" <?php if (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") echo "checked"; ?>> Dekripsi
        <input type="submit" value="Proses">
    </form>

    <?php if (!empty($encryptedText) || !empty($decryptedText)): ?>
        <?php if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt"): ?>
            <h2>Hasil Enkripsi</h2>
        <?php elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt"): ?>
            <h2>Hasil Dekripsi</h2>
        <?php endif; ?>
        <p>Input: <?php echo $text; ?></p>
        <p>Output: <?php echo (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") ? $decryptedText : $encryptedText; ?></p>
    <?php endif; ?>

    <a href="caesar.php"><button>Enskripsi Tahap Pertama</button></a>
</body>
</html>