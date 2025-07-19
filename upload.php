<?php

$uploadDir = __DIR__ . '/uploads/tmp/';

if (! isset($_FILES['chunk']) || ! isset($_POST['filename']) || ! isset($_POST['chunk_index']) || ! isset($_POST['total_chunks'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$filename = $_POST['filename'];
$chunkIndex = intval($_POST['chunk_index']);
$totalChunks = intval($_POST['total_chunks']);

$chunk = $_FILES['chunk']['tmp_name'];
$targetDir = $uploadDir . $filename;

if (! is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$chunkPath = "$targetDir/part_$chunkIndex";
move_uploaded_file($chunk, $chunkPath);

$chunks = glob("$targetDir/part_*");
if (count($chunks) === $totalChunks) {
    $finalPath = __DIR__ . "/uploads/$filename";
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

    exit;
}
