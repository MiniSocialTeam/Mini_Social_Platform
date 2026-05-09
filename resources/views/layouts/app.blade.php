<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Social Media - ProjectLaravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .story-circle {
            width: 70px; height: 70px;
            object-fit: cover; border-radius: 50%;
            border: 3px solid #d62976; /* Couleur style Instagram */
            padding: 2px;
        }
        .story-container { display: flex; gap: 15px; overflow-x: auto; padding: 10px 0; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container"><a class="navbar-brand" href="#">ProjectLaravel</a></div>
    </nav>
    <div class="container">@yield('content')</div>
</body>
</html>