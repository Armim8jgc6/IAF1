<?php
session_start();

// Ellenőrzöm, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newData = $_POST['newData'];

    // Rögzítem az új adatot
    if (!empty($newData)) {
        $data[] = $newData;
    }
}
?>
<!-- Weblap formázás -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
</head>
<body>
    <h2>Content</h2>
    
    <form method="post" action="">
        <label for="newData">New Data:</label>
        <input type="text" name="newData">
        <button type="submit">Add</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?php echo $item; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Kilépés gomb a sessionből -->
    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>