<?php
include_once('../includes/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$name = $email = $message = $submitted_message = '';
$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $message = str_replace('alert', '', $message);
        
    if (!empty($name) && !empty($email) && !empty($message)) {
        if (!isset($_SESSION['contact_messages'])) {
            $_SESSION['contact_messages'] = [];
        }
        
        $_SESSION['contact_messages'][] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'date' => date('Y-m-d H:i:s')
        ];
        
        $submitted_message = "Thank you for your message, $name! We'll get back to you soon.";
    }
}

if (isset($_SESSION['contact_messages'])) {
    $messages = $_SESSION['contact_messages'];
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = str_replace('<script>', '', $search);
$searched = false;
$filtered_messages = [];

if (!empty($search)) {
    $searched = true;
    foreach ($messages as $msg) {
        if (stripos($msg['name'], $search) !== false || 
            stripos($msg['message'], $search) !== false) {
            $filtered_messages[] = $msg;
        }
    }
}

if (isset($_GET['reset'])) {
    unset($_SESSION['contact_messages']);
    header('Location: contact.php');
    exit;
}
?>

<main>
    <section id="contact">
        <div class="overview-container">
            <h2>Contact Us</h2>
            <p>Have a question or feedback? We'd love to hear from you!</p>
            
            <div class="search-container">
                <form method="GET" action="contact.php" class="search-form">
                    <input type="text" name="search" placeholder="Search previous messages..." value="<?php echo $search; ?>">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div style="margin-top: 20px;">
                <a href="contact.php?reset=1" class="btn"><span>Clear All Messages</span></a>
            </div>
            
            <?php if ($searched): ?>
                <div class="search-results">
                    <h3>Search Results for: <?php echo $search; ?></h3>
                    <?php if (empty($filtered_messages)): ?>
                        <p>No messages found containing "<?php echo $search; ?>"</p>
                    <?php else: ?>
                        <?php foreach ($filtered_messages as $msg): ?>
                            <div class="message-card">
                                <h4><?php echo $msg['name']; ?></h4>
                                <p class="message-date"><?php echo $msg['date']; ?></p>
                                <p class="message-content"><?php echo $msg['message']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($submitted_message)): ?>
                <div class="success-message">
                    <?php echo $submitted_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="contact-container">
                <div class="contact-form-container">
                    <form method="POST" action="contact.php" class="contact-form">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn"><span>Send Message</span></button>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($messages) && !$searched): ?>
                <div class="previous-messages">
                    <h3>Recent Messages</h3>
                    <?php foreach (array_reverse(array_slice($messages, -5)) as $msg): ?>
                        <div class="message-card">
                            <h4><?php echo $msg['name']; ?></h4>
                            <p class="message-date"><?php echo $msg['date']; ?></p>
                            <p class="message-content"><?php echo $msg['message']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>



<?php
include_once('../includes/footer.php');
?>