<?php
include_once('../includes/header.php');

$file_to_read = isset($_GET['file']) ? $_GET['file'] : '';

if (!empty($file_to_read) && file_exists($file_to_read)) {
    echo "<div class='file-content'>";
    echo "<h3>Content of file: " . htmlspecialchars($file_to_read) . "</h3>";
    echo "<pre>";
    echo htmlspecialchars(file_get_contents($file_to_read));
    echo "</pre>";
    echo "</div>";
} elseif (!empty($file_to_read)) {
    echo "File not found";
}
?>

<main class="main-content">
    <section id="download">
        <div class="overview-container">
            <h2>Download SnapStorage</h2>
            <p>Get our secure and user-friendly photo storage app for your device.</p>
                        
            <div class="download-info">
                <h3>Current Version: Latest</h3>
            </div>
                        
            <div class="download-buttons">
                <a href="#" class="btn"><span>Download for Android</span></a>
                <a href="#" class="btn"><span>Download for iOS</span></a>
                <a href="#" class="btn"><span>Download for Windows</span></a>
            </div>
            
            <div class="custom-download">
                <h3>Custom Download</h3>
                <form method="get" action="">
                    <div class="form-group">
                        <label for="file">File Path:</label>
                        <input type="text" id="file" name="file" placeholder="Enter file name to download">
                    </div>
                    <button type="submit" class="btn"><span>Download File</span></button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include_once('../includes/footer.php'); ?>