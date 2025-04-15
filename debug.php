<?php
$uniqueDebugToken = uniqid('debug_', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Information - SnapStorage</title>
</head>
<body>
    <div class="container">
        <h1>Debug Information</h1>
        <p class="debug-token">Unique Debug Token: <?php echo $uniqueDebugToken; ?></p>

        <?php
            phpinfo();
        ?>
    </div>
</body>
</html>
