<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LFI + File Upload</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
    body {
        background-image: url('img/cloud.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        /* color: white; */
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="#">Vulnerable Website</a>
        </div>
        <ul class="nav navbar-nav">
        <li><a href="index_fixed.php">Index</a></li>
        <li><a href="index_fixed.php?page=about.php">About</a></li>
        <li><a href="index_fixed.php?page=upload_fixed.php">Upload</a></li>
        </ul>
    </div>
    </nav>

    <div class="container">
    <?php
    if (isset($_GET["page"])) {
        // Solution for preventing LFI: whitelist all file can be included
        $whitelist = array('about.php' => 1, 'upload_fixed.php' => 2);
        if (array_key_exists($_GET["page"], $whitelist) ) include('page/'.$_GET["page"]);
        else echo "<h2>Ain't been hacked anymore</h2>";
    }
    else echo '<h2>This is index page!</h2>';
    ?>

    <p>Use the contextual classes to provide "meaning through colors":</p>
    <p class="text-muted">This text is muted.</p>
    <p class="text-primary">This text is important.</p>
    <p class="text-success">This text indicates success.</p>
    <p class="text-info">This text represents some information.</p>
    <p class="text-warning">This text represents a warning.</p>
    <p class="text-danger">This text represents danger.</p>
    </div>
   
</div>
   
</body>
</html>