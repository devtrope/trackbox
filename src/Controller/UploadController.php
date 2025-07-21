<?php

namespace Trackbox\Controller;

class UploadController
{
    public function index(): void
    {
        $database = new \PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');

        $uploadDir = __DIR__ . '/uploads/tmp/';

        if (! isset($_FILES['chunk']) || ! isset($_POST['filename']) || ! isset($_POST['chunk_index']) || ! isset($_POST['total_chunks']) || ! isset($_POST['hash'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $filename = $_POST['filename'];
        $chunkIndex = intval($_POST['chunk_index']);
        $totalChunks = intval($_POST['total_chunks']);
        $incomingHash = $_POST['hash'];

        // Ignore if the file has not been modified
        $songExists = $database->prepare('SELECT * FROM songs WHERE name = :name AND hash = :hash');
        $songExists->execute(['name' => $filename, 'hash' => $incomingHash]);
        if ($songExists->rowCount() > 0) {
            exit;
        }

        $chunk = $_FILES['chunk']['tmp_name'];
        $targetDir = $uploadDir . $filename;

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $chunkPath = "$targetDir/part_$chunkIndex";
        move_uploaded_file($chunk, $chunkPath);

        $chunks = glob("$targetDir/part_*");
        if (count($chunks) === $totalChunks) {
            $uploadPath = "uploads/$incomingHash." . pathinfo($filename, PATHINFO_EXTENSION);
            $finalPath = __DIR__ . "/" . $uploadPath;
            $out = fopen($finalPath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $partPath = "$targetDir/part_$i";
                $in = fopen($partPath, 'rb');
                stream_copy_to_stream($in, $out);
                fclose($in);
            }

            fclose($out);

            array_map('unlink', glob("$targetDir/part_*"));
            rmdir($targetDir);

            $stmt = $database->prepare('SELECT MAX(version) AS max_version FROM songs WHERE name = :name');
            $stmt->execute(['name' => $filename]);
            $maxVersion = $stmt->fetch()['max_version'] ?? 0;
            $newVersion = $maxVersion + 1;

            $ins = $database->prepare('INSERT INTO songs (hash, name, path, version) VALUES (:hash, :name, :path, :version)');
            $ins->execute([
                'hash' => $incomingHash,
                'name' => $filename,
                'path' => $uploadPath,
                'version' => $newVersion
            ]);

            exit;
        }
    }
}
