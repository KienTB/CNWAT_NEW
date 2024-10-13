function showSection(sectionId) {
    var sections = document.querySelectorAll('.content-section');
    sections.forEach(function(section) {
        section.style.display = 'none';
    });

    var selectedSection = document.getElementById(sectionId);
    if(selectedSection) {
        selectedSection.style.display = 'block';
    }

    // Cập nhật trạng thái active cho menu
    var menuItems = document.querySelectorAll('.sidebar nav ul li');
    menuItems.forEach(function(item) {
        item.classList.remove('active');
    });
    var activeItem = document.querySelector('.sidebar nav ul li a[onclick="showSection(\'' + sectionId + '\')"]').parentNode;
    if(activeItem) {
        activeItem.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    showSection('home');
});