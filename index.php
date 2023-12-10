<?php
// Session indítása
session_start();

// Ellenőrzöm, hogy be van-e jelentkezve a felhasználó
if (isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit();
}

// Ellenőrzöm a bejelentkezési adatokat
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ellenőrzöm az engedélyezett felhasználónév és jelszó párost
    if ($username === 'aaa' && $password === 'aaa') {
        // Sikeres belépés esetén, session változó beállítása
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
    } else {
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}
?>
<!-- Weblap formázás -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
</head>
<body>
    <h2>Bejelentkezés</h2>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Felhasználónév:</label>
        <input type="text" name="username" required><br>
        <label>Jelszó:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Belépés">
    </form>
</body>
</html>