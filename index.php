<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    alert('Files synchronised successfully');
                } else {
                    alert('An error happened during synchronization: ' + data.message);
                }
            })
        })
    })
</script>
<body>
    <button id="sync-files">Synchroniser</button>
</body>
</html>