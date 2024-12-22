document.addEventListener('DOMContentLoaded', function () {
    const reportLinks = document.querySelectorAll('.cursor-pointer');
    reportLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // Prevent the click event from propagating to the parent section
            e.stopPropagation();

            // Prevent the default action of the link (such as redirecting)
            e.preventDefault();

            // Toggle the visibility of the reports section
            toggleReports(link.getAttribute('data-post-id'));
        });
    });

    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    
    scrollLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
});

function toggleReports(postId) {
    const reportSection = document.getElementById(`reports-${postId}`);
    if (reportSection) {
        if (reportSection.classList.contains('hidden')) {
            // Show the reports
            reportSection.classList.remove('hidden');
            reportSection.style.maxHeight = reportSection.scrollHeight + 'px';
            reportSection.style.opacity = '1';
        } else {
            // Hide the reports
            reportSection.style.maxHeight = '0';
            reportSection.style.opacity = '0';
            setTimeout(() => {
                reportSection.classList.add('hidden');
            }, 300); // Match the duration of the transition
        }
    }
}

function handleClick(event, url) {
    // Prevent redirect if the click event came from the "No. of Reports" button or any link
    if (event.target.closest('.cursor-pointer') || event.target.closest('a')) {
        return;
    }

    // Proceed with redirect if not from the "No. of Reports" button or any link
    window.location.href = url;
}

// Prevent section click if clicking on a link
document.querySelectorAll("section a").forEach(link => {
    link.addEventListener("click", event => event.stopPropagation());
});
