<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rögzítés az adatbázisban
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $message = $_POST['message'];

    $sql = "INSERT INTO records (username, message) VALUES ('{$_SESSION['username']}', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Bejegyzés sikeresen rögzítve!";
    } else {
        echo "Hiba a rögzítés során: " . $conn->error;
    }
}

// Az összes rekord lekérése
$result = $conn->query("SELECT * FROM records ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üdvözöljük</title>
</head>
<body>
    <h2>Üdvözöljük, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Űrlap az új bejegyzés rögzítéséhez -->
    <form method="post" action="">
        <label>Új bejegyzés:</label>
        <textarea name="message" rows="4" cols="50" required></textarea><br>
        <input type="submit" name="submit" value="Rögzítés">
    </form>

    <hr>

    <!-- Az összes rekord megjelenítése -->
    <h3>Eddig rögzített bejegyzések:</h3>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>{$row['created_at']} - {$row['username']}: {$row['message']}</p>";
        }
    } else {
        echo "Nincs még rögzített bejegyzés.";
    }
    ?>

    <!-- Módosításhoz form -->
    <h3>Módosítás</h3>
    <form method="post" action="">
        <label>Válassz egy rekordot a módosításhoz:</label>
        <select name="record_id">
            <?php
            $result = $conn->query("SELECT id, created_at FROM records ORDER BY created_at DESC");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['created_at']}</option>";
                }
            }
            ?>
        </select>
        <br>
        <label>Új üzenet:</label>
        <textarea name="new_message" rows="4" cols="50" required></textarea><br>
        <input type="submit" name="update" value="Módosítás">
    </form>

    <?php
    // Módosítás végrehajtása
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $recordId = $_POST['record_id'];
        $newMessage = $_POST['new_message'];

        $updateSql = "UPDATE records SET message = '$newMessage' WHERE id = $recordId";

        if ($conn->query($updateSql) === TRUE) {
            echo "Bejegyzés módosítva!";
        } else {
            echo "Hiba a módosítás során: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>