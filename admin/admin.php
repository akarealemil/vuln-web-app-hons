<?php
require_once 'auth_check.php';

require_admin();

include_once('./includes/header.php');
?>

<main>
    <section id="admin-panel">
        <div class="overview-container">
            <h2>Admin Control Panel</h2>
            <p>Welcome to the SnapStorage admin control panel.</p>
            
            <div class="admin-grid">
                <div class="admin-card">
                    <div class="admin-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>User Management</h3>
                    <p>Create, edit, and delete user accounts.</p>
                    <a href="createNewUser.php" class="btn"><span>Manage Users</span></a>
                </div>
                
                <div class="admin-card">
                    <div class="admin-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>System Logs</h3>
                    <p>View server and application logs.</p>
                    <a href="logs.php" class="btn"><span>View Logs</span></a>
                </div>
                
                <div class="admin-card">
                    <div class="admin-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3>File Browser</h3>
                    <p>Browse and manage directories and files.</p>
                    <a href="directories.php" class="btn"><span>Browse Files</span></a>
                </div>
                
                <div class="admin-card">
                    <div class="admin-icon">
                        <i class="fas fa-bug"></i>
                    </div>
                    <h3>Debug Information</h3>
                    <p>View system debug information and PHP configuration.</p>
                    <a href="debug.php" class="btn"><span>Debug Info</span></a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    
    .admin-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .admin-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }
    
    .admin-icon {
        font-size: 3rem;
        color: var(--accent-color);
        margin-bottom: 20px;
    }
    
    .admin-card h3 {
        margin-bottom: 15px;
        font-size: 1.5rem;
    }
    
    .admin-card p {
        margin-bottom: 25px;
        color: rgba(224, 224, 224, 0.8);
    }
</style>

<?php
include_once('./includes/footer.php');
?>