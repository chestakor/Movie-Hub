// Form validation function
function validateForm() {
    const movieName = document.getElementById('movie-name').value.trim();
    const year = document.getElementById('year').value.trim();

    // Validate movie name
    if (!movieName) {
        alert("Content Name is required.");
        return false;
    }

    // Validate year format if provided
    if (year && !/^\d{4}$/.test(year)) {
        alert("Please enter a valid 4-digit year.");
        return false;
    }

    return true; // Form is valid
}

// Hamburger menu toggle function
function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}