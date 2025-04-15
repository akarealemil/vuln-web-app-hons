<?php
http_response_code(404);
include_once('../includes/header.php');
?>

<main>
    <section id="error-page">
        <div class="overview-container">
            <div class="error-content">
                <h1>404</h1>
                <h2>Page Not Found</h2>
                <p>The page you are looking for doesn't exist or has been moved.</p>
                <a href="/index.php" class="btn"><span>Return Home</span></a>
            </div>
        </div>
    </section>
</main>

<?php
include_once('../includes/footer.php');
?>