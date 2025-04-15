<?php
include_once('../includes/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$staff_members = [
    [
        'id' => 1,
        'name' => 'Alex Johnson',
        'title' => 'CEO & Founder',
        'bio' => 'Alex founded SnapStorage in 2019 with a vision to create the most secure and user-friendly photo storage solution.',
        'expertise' => 'Business Strategy, Security Architecture',
        'image' => '../assets/img/avatar.png'
    ],
    [
        'id' => 2,
        'name' => 'Samantha Lee',
        'title' => 'Chief Technology Officer',
        'bio' => 'With 15 years in cloud security, Samantha ensures all your photos remain private and protected.',
        'expertise' => 'Cloud Infrastructure, Data Protection',
        'image' => '../assets/img/avatar.png'
    ],
    [
        'id' => 3,
        'name' => 'Marcus Chen',
        'title' => 'Lead Developer',
        'bio' => 'Marcus oversees our development team and is passionate about creating intuitive user experiences.',
        'expertise' => 'Mobile Development, UX Design',
        'image' => '../assets/img/avatar.png'
    ]
];

$staff_id = isset($_GET['id']) ? $_GET['id'] : null;
$selected_staff = null;

$search_term = isset($_GET['search']) ? $_GET['search'] : '';
while (stripos($search_term, 'script') !== false) {
    $search_term = str_ireplace('script', '', $search_term);
}
$search_results = [];

if (!empty($search_term)) {
    foreach ($staff_members as $staff) {
        if (stripos($staff['name'], $search_term) !== false || 
            stripos($staff['title'], $search_term) !== false ||
            stripos($staff['expertise'], $search_term) !== false) {
            $search_results[] = $staff;
        }
    }
}

if ($staff_id !== null) {
    foreach ($staff_members as $staff) {
        if ($staff['id'] == $staff_id) {
            $selected_staff = $staff;
            break;
        }
    }
}
?>

<main>
    <section id="staff">
        <div class="overview-container">
            <h2>Meet Our Team</h2>
            <p>The talented people behind SnapStorage</p>
            
            <div class="search-container">
                <form method="GET" action="staff.php" class="search-form">
                    <input type="text" name="search" placeholder="Search staff by name or expertise..." 
                           value="<?php echo $search_term; ?>">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>
            
            <?php if (!empty($search_term)): ?>
                <div class="search-results">
                    <h3>Search Results for: <?php echo $search_term; ?></h3>
                    
                    <?php if (empty($search_results)): ?>
                        <p>No staff members found matching "<?php echo $search_term; ?>"</p>
                    <?php else: ?>
                        <div class="staff-grid">
                            <?php foreach ($search_results as $staff): ?>
                                <div class="staff-card">
                                    <div class="staff-image">
                                        <img src="<?php echo file_exists($staff['image']) ? $staff['image'] : '/assets/img/avatar.png'; ?>" alt="<?php echo $staff['name']; ?>">
                                    </div>
                                    <div class="staff-info">
                                        <h3><?php echo $staff['name']; ?></h3>
                                        <p class="staff-title"><?php echo $staff['title']; ?></p>
                                        <p><strong>Expertise:</strong> <?php echo $staff['expertise']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif ($selected_staff): ?>
                <div class="staff-profile">
                    <div class="profile-header">
                    <div class="staff-id">Staff ID: <?php echo $staff_id; ?></div>
                        <div class="profile-image">
                            <img src="<?php echo file_exists($selected_staff['image']) ? $selected_staff['image'] : '/assets/img/avatar.png'; ?>" 
                                 alt="<?php echo $selected_staff['name']; ?>">
                        </div>
                        <div class="profile-info">
                            <h2><?php echo $selected_staff['name']; ?></h2>
                            <p class="profile-title"><?php echo $selected_staff['title']; ?></p>
                            <div class="profile-expertise">
                                <strong>Expertise:</strong> <?php echo $selected_staff['expertise']; ?>
                            </div>
                            <p class="profile-bio"><?php echo $selected_staff['bio']; ?></p>
                            
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="staff-grid">
                    <?php foreach ($staff_members as $staff): ?>
                        <div class="staff-card">
                            <div class="staff-image">
                                <img src="<?php echo file_exists($staff['image']) ? $staff['image'] : '/assets/img/avatar.png'; ?>" alt="<?php echo $staff['name']; ?>">
                            </div>
                            <div class="staff-info">
                                <h3><?php echo $staff['name']; ?></h3>
                                <p class="staff-title"><?php echo $staff['title']; ?></p>
                                <p><strong>Expertise:</strong> <?php echo $staff['expertise']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once('../includes/footer.php'); ?>