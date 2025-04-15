<?php
http_response_code(403);
include_once('../includes/header.php');
?>

<main>
    <section id="error-page">
        <div class="overview-container">
            <div class="error-content">
                <h1>403</h1>
                <h2>Access Forbidden</h2>
                <p>You don't have permission to access this page. Please log in or contact the user 'admin'.</p>
                <a href="/index.php" class="btn"><span>Return Home</span></a>
                <a href="/auth/login.php" class="btn"><span>Log In</span></a>
            </div>
        </div>
    </section>
</main>

<?php
include_once('../includes/footer.php');
?>