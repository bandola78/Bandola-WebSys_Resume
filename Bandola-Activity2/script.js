// Navigation sections
function showSection(sectionName) {
    // Remove active class from all nav buttons
    const buttons = document.querySelectorAll('.nav-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    // Add active class to clicked button
    event.target.classList.add('active');
    
    // Hide all main content sections
    const sections = document.querySelectorAll('.content .section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Show selected section(s)
    if (sectionName === 'all') {
        sections.forEach(section => section.classList.add('active'));
    } else {
        const targetSection = document.getElementById(sectionName + '-section');
        if (targetSection) {
            targetSection.classList.add('active');
        }
    }
}

// Skill alert
function showSkillAlert(skill) {
    alert(`Skill: ${skill}\n\nClick to learn more about this skill!`);
}

// Toggle details in projects/education
function toggleDetails(element) {
    element.style.background = element.style.background === 'rgb(0, 0, 0)' ? '#fafafa' : '#000';
    element.style.color = element.style.color === 'white' ? '#333' : 'white';
}

// Copy email to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Email copied to clipboard: ' + text);
    }).catch(() => {
        alert('Email: ' + text);
    });
}

// Show/hide password toggle
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const checkbox = document.getElementById('show-password');
    if (passwordInput) {
        passwordInput.type = checkbox.checked ? 'text' : 'password';
    }
}