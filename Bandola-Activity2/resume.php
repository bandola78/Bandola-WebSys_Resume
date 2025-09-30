<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Logout logic (optional if using separate logout.php)
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// User/Resume data
$name = "JOBELYN BANDOLA";
$title = "3rd-year Computer Science Student | Aspiring Data Scientist";
$location = "Philippines";
$email = "jobelynbandola16@gmail.com";
$phone = "+639266614453";

$about = "3rd-year Computer Science student aspiring to be a Data Scientist, with a solid background in Python, SQL, and statistics. Skilled in data handling, small-scale projects, and analytical thinking. Enthusiastic about applying data-driven problem-solving and exploring machine learning.";

$skills = ["Python", "SQL", "Microsoft Office", "Applications"];

$certifications = [
    "SQL Fundamentals (DataCamp)" => "SQL Fundamentals - DataCamp",
    "Associate Data Scientist in Python (DataCamp)" => "Associate Data Scientist in Python - DataCamp"
];

$interests = ["Gaming 🎮", "Animals 🐾", "Traveling ✈️"];

$education = [
    [
        "level" => "College",
        "course" => "B.S. Computer Science",
        "school" => "Batangas State University - TNEU - Alangilan",
        "year" => "2023 - Present"
    ],
    [
        "level" => "Senior High School",
        "course" => "Science, Technology, Engineering, and Mathematics",
        "school" => "Batangas Christian School",
        "year" => "2021 - 2023"
    ]
];

$projects = [
    [
        "title" => "Stray Haven",
        "subtitle" => "Stray Animal Management System",
        "year" => "2024",
        "desc" => "Developed a console-based Java application for managing stray animals. Implemented object-oriented programming principles (encapsulation, inheritance, and polymorphism) to handle stray animal records, health tracking, and adoption status. Gained hands-on experience with project organization and system design."
    ],
    [
        "title" => "Animal Encyclopedie",
        "subtitle" => "Information System",
        "year" => "2024",
        "desc" => "Created an educational application showcasing animal facts, categories, and sounds. Applied Java programming and basic database concepts to build an interactive system aimed at making learning engaging for children. Enhanced skills in problem-solving and user-centered design."
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Resume</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <!-- Logout button -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <a href="logout.php" style="background: #000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: 600;">Logout</a>
    </div>

    <div class="container">
        <!-- Header with profile picture -->
        <!-- Header -->
    <div class="header">
        <div class="header-left">
            <img src="picture.png" alt="Profile Picture" class="profile-pic">
        </div>
        <div class="header-right">
            <h1><?php echo $name; ?></h1>
            <p><?php echo $title; ?></p>
        </div>
    </div>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <button class="nav-btn active" onclick="showSection('about')">About</button>
            <button class="nav-btn" onclick="showSection('education')">Education</button>
            <button class="nav-btn" onclick="showSection('projects')">Projects</button>
            <button class="nav-btn" onclick="showSection('all')">View All</button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Skills -->
                <div class="section active">
                    <h2>SKILLS</h2>
                    <?php foreach ($skills as $skill): ?>
                        <div class="skill-item" onclick="showSkillAlert('<?php echo $skill; ?>')"><?php echo $skill; ?></div>
                    <?php endforeach; ?>
                </div>

                <!-- Certifications -->
                <div class="section active">
                    <h2>CERTIFICATIONS</h2>
                    <?php foreach ($certifications as $label => $alert): ?>
                        <div class="cert-item" onclick="alert('<?php echo $alert; ?>')"><?php echo $label; ?></div>
                    <?php endforeach; ?>
                </div>

                <!-- Interests -->
                <div class="section active">
                    <h2>INTERESTS</h2>
                    <div class="interest-list">
                        <?php foreach ($interests as $interest): ?>
                            <div class="interest-item" onclick="alert('Interest: <?php echo $interest; ?>')"><?php echo $interest; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="content">
                <!-- About -->
                <div class="section active" id="about-section">
                    <h2>ABOUT</h2>
                    <div class="about-text"><?php echo $about; ?></div>
                    <button class="download-btn" onclick="alert('Download feature - Connect to your PDF generation!')">Download Resume</button>
                </div>

                <!-- Education -->
                <div class="section" id="education-section">
                    <h2>EDUCATION</h2>
                    <?php foreach ($education as $edu): ?>
                        <div class="education-item" onclick="toggleDetails(this)">
                            <h3><?php echo $edu["level"]; ?></h3>
                            <h2><?php echo $edu["course"]; ?></h2>
                            <div class="subtitle"><?php echo $edu["school"]; ?></div>
                            <div class="year"><?php echo $edu["year"]; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Projects -->
                <div class="section" id="projects-section">
                    <h2>PROJECTS</h2>
                    <?php foreach ($projects as $proj): ?>
                        <div class="project-item" onclick="toggleDetails(this)">
                            <h3><?php echo $proj["title"]; ?></h3>
                            <div class="subtitle"><?php echo $proj["subtitle"]; ?></div>
                            <div class="year"><?php echo $proj["year"]; ?></div>
                            <p><?php echo $proj["desc"]; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
