<?php
$baseDir = realpath("../");
$currentDir = isset($_GET['dir']) ? realpath($baseDir . '/' . $_GET['dir']) : $baseDir;

$hiddenItems = array(
    '.git',
    'README.md',
    'robots.txt',
    '.htaccess',
    'debug.php',
    'database',
    'errors',
);

echo "<h2>Directory Listing for: " . htmlspecialchars($currentDir) . "</h2>";
echo "<ul>";

if ($currentDir !== $baseDir) {
    $parentDir = dirname($_GET['dir']);
    echo "<li><a href='?dir=" . urlencode($parentDir) . "'><strong>[⬆ Back]</strong></a></li>";
}

if ($handle = opendir($currentDir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && !in_array($file, $hiddenItems)) {
            $filePath = isset($_GET['dir']) ? $_GET['dir'] . '/' . $file : $file;
            $safePath = urlencode($filePath);

            if (is_dir("$currentDir/$file")) {
                echo "<li><strong>[DIR]</strong> <a href='?dir=$safePath'>$file</a></li>";
            } else {
                echo "<li><a href='" . htmlspecialchars("/{$filePath}") . "' target='_blank'>$file</a></li>";
            }
        }
    }
    closedir($handle);
} else {
    echo "<p>Failed to open directory.</p>";
}

echo "</ul>";
?>
