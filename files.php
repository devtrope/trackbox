<?php

$database = new PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');

$query = "SELECT s1.* FROM songs s1
          INNER JOIN (SELECT name, MAX(version) AS max_version FROM songs GROUP BY name) s2
          ON s1.name = s2.name AND s1.version = s2.max_version
          ORDER BY s1.name";
$files = $database->query($query)->fetchAll(PDO::FETCH_ASSOC);

?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Hash</th>
            <th>Path</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($files as $file): ?>
            <tr>
                <td><?php echo htmlspecialchars($file['name']); ?></td>
                <td><?php echo htmlspecialchars($file['hash']); ?></td>
                <td><?php echo htmlspecialchars($file['path']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>