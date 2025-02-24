document.addEventListener('DOMContentLoaded', function() {
    const applyButtons = document.querySelectorAll('.apply-btn');
    const popup = document.getElementById('application-popup');
    const closeBtn = document.querySelector('.close');
    const filterForm = document.getElementById('filter-form');
    const jobCards = document.querySelectorAll('.job-card');
    const cvFileInput = document.getElementById('cv_file');
    const fileNameDisplay = document.getElementById('file-name');

    applyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.getAttribute('data-job-id');
            const jobCard = this.closest('.job-card');
            const jobTitle = jobCard.querySelector('h3').textContent;
            const jobCompany = jobCard.querySelector('p:nth-of-type(1)').textContent;
            const jobLocation = jobCard.querySelector('p:nth-of-type(2)').textContent;
            const jobSalary = jobCard.querySelector('p:nth-of-type(3)').textContent;

            document.getElementById('job_id').value = jobId;
            document.getElementById('popup-job-details').innerHTML = `
                <h3>${jobTitle}</h3>
                <p>${jobCompany}</p>
                <p>${jobLocation}</p>
                <p>${jobSalary}</p>
            `;

            popup.style.display = 'block';
        });
    });

    closeBtn.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    });

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const keyword = document.getElementById('keyword').value.toLowerCase();
        const location = document.getElementById('location').value;
        const category = document.getElementById('category').value;

        jobCards.forEach(card => {
            const cardLocation = card.getAttribute('data-location');
            const cardCategory = card.getAttribute('data-category');
            const cardText = card.textContent.toLowerCase();

            const matchesKeyword = cardText.includes(keyword);
            const matchesLocation = location === '' || cardLocation === location;
            const matchesCategory = category === '' || cardCategory === category;

            if (matchesKeyword && matchesLocation && matchesCategory) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    cvFileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileNameDisplay.textContent = `Selected file: ${this.files[0].name}`;
        } else {
            fileNameDisplay.textContent = '';
        }
    });
});
