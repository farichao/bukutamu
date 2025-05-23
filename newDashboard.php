<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=Silakan login dulu!");
    exit();
}

if (!empty($_SESSION['welcome_message'])) {
    echo "<script>alert('" . addslashes($_SESSION['welcome_message']) . "');</script>";
    unset($_SESSION['welcome_message']);
}

// Nama file untuk menyimpan data tamu
$data_file = "data_tamu.txt";

// Proses simpan data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['comment'], $_POST['email'])) {
    $name = trim($_POST['name']);
    $comment = trim($_POST['comment']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($comment) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $timestamp = date("Y-m-d H:i:s");
        $entry = "Waktu: $timestamp\nNama: $name\nKomentar: $comment\nEmail: $email\n---\n";
        file_put_contents($data_file, $entry, FILE_APPEND);
        $success_message = "Data berhasil disimpan!";
    } else {
        $error_message = "Harap isi semua data dengan benar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url(bunga.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            gap: 20px;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgb(107, 0, 23, 0.9);
            color: white;
            padding: 12px 18px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.2s;
        }

        .logout-btn:hover {
            box-shadow: 0 8px 15px rgba(174, 119, 131, 0.6);
        }

        .box {
            flex: 1;
            border-radius: 10px;
            padding: 30px;
            color: black;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #6B0118;
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin-bottom: 20px;
        }

        input, textarea {
            width: calc(100% - 20px);
            height: 50px;
            border: 2px solid #ae7783;
            background-color: #FDF8F5;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 16px;
            display: block;
            outline: none;
        }

        textarea {
            height: 120px;
            resize: none;
        }

        input:focus, textarea:focus {
            border-color: #6B0118;
        }

        input[type="submit"] {
            background-color: rgba(107, 0, 23, 0.9);
            border-radius: 20px;
            color: #FFF;
            border: none;
            padding: 15px;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            box-shadow: 0 8px 15px rgba(174, 119, 131, 0.6);
        }

        .comment-box {
            background-color: rgba(174, 119, 131, 0.2);
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            font-size: 16px;
            color: #6B0118;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout-btn">Logout</a>

        <div class="box">
            <h2>Guest Book</h2>
            <form method="post" action="">
                <input type="text" name="name" placeholder="Name" required>
                <textarea name="comment" placeholder="Comment" required></textarea>
                <input type="email" name="email" placeholder="Email" required>
                <input type="submit" value="Send">
            </form>
            <?php if (!empty($success_message)) : ?>
                <p style="color: green;"><?= $success_message ?></p>
            <?php elseif (!empty($error_message)) : ?>
                <p style="color: red;"><?= $error_message ?></p>
            <?php endif; ?>
        </div>

        <div class="box">
            <h2>History Input</h2>
            <div id="comments">
                <?php
                if (file_exists($data_file)) {
                    $entries = file($data_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach ($entries as $line) {
                        if ($line === "---") {
                            echo "<hr>";
                        } else {
                            echo "<div class='comment-box'>" . htmlspecialchars($line) . "</div>";
                        }
                    }
                } else {
                    echo "<p>Belum ada komentar.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
