<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('sync-files').addEventListener('click', function() {
            fetch ('http://127.0.0.1:5001/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchFiles()
                } else {
                    alert('An error happened during synchronization: ' + data.message);
                }
            })
        })

        function fetchFiles() {
            fetch('files.php')
            .then(response => response.text())
            .then(html => {
                document.querySelector('.files').innerHTML = html
            })
            .catch(error => {
                console.error('Error fetching files:', error)
            })
        }

        fetchFiles()
    })
</script>
<body>
    <button id="sync-files" class="btn btn-primary">Synchroniser</button>
    <div class="files"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>