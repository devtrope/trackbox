<?php

$database = new PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');

$files = $database->query('SELECT * FROM songs')->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
    <tr>
        <th>Name</th>
        <th>Hash</th>
        <th>Path</th>
    </tr>
    <?php foreach ($files as $file): ?>
        <tr>
            <td><?php echo htmlspecialchars($file['name']); ?></td>
            <td><?php echo htmlspecialchars($file['hash']); ?></td>
            <td><?php echo htmlspecialchars($file['path']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>