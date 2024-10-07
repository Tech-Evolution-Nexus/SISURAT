<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets("style.css") ?>">
</head>
<body>
    <h1>COBA PHP</h1>
    
    <table class="bg-danger">
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
        </tr>
        <?php foreach($pasien as $p):?>
            <tr>
                <td><?=$p["nama"]?></td>
                <td><?=$p["kelas"]?></td>
            </tr>
        <?php endforeach;?>
    </table>
</body>
</html>