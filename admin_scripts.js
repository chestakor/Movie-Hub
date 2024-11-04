document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('details-modal');
    const closeModal = document.querySelector('.close');
    const modalInfo = document.getElementById('modal-info');

    const detailsButtons = document.querySelectorAll('.details-btn');
    const requestTableBody = document.querySelector('.dashboard-table tbody'); // Ensure the correct selector

    // Show modal details
    detailsButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
            const index = this.getAttribute('data-index');

            fetch('requests.txt')
                .then(response => response.text())
                .then(data => {
                    const lines = data.trim().split("\n");
                    const line = lines[index];

                    const [datetime, type, name, year, language, quality, ip] = line.split(" | ");

                    modalInfo.innerHTML = `
                    <h3>↯ NEW CONTENT REQUEST</h3>
                    <div class="content-info">
                        <h4>Content Information</h4>
                        <hr />
                        <p>Type: ${type}</p>
                        <p>Name: ${name}</p>
                        <p>Year: ${year}</p>
                        <p>Language: ${language}</p>
                        <p>Quality: ${quality}</p>
                    </div>
                    <div class="user-info">
                        <h4>User Information</h4>
                        <hr />
                        <p>IP Address: ${ip}</p>
                    </div>`;

                    modal.style.display = "block";
                });
        });
    });

    // Close modal
    closeModal.addEventListener('click', function () {
        modal.style.display = "none";
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Mark as done using tick mark
    document.querySelectorAll('.tick-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            const row = this.closest('tr'); // Get the closest row

            // Move the row to the last position
            requestTableBody.appendChild(row);

            // Change its background color to indicate it's done
            row.classList.add('done');

            // Append "done" flag to the requests.txt
            updateRequestStatus(index, 'done');
        });
    });

    // Delete request using cross mark
    document.querySelectorAll('.cross-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            const row = this.closest('tr'); // Get the closest row
            row.remove(); // Remove the row from the table

            // Remove the request from the requests.txt
            deleteRequest(index);
        });
    });

    // Function to update the status of a request to "done"
    function updateRequestStatus(index, status) {
        fetch(`update_request.php?index=${index}&status=${status}`)
            .then(response => response.text())
            .then(data => {
                console.log('Request updated: ', data);
            });
    }

    // Function to delete a request
    function deleteRequest(index) {
        fetch(`delete_request.php?index=${index}`)
            .then(response => response.text())
            .then(data => {
                console.log('Request deleted: ', data);
            });
    }

    // Welcome popup on login
    const welcomeModal = document.getElementById('welcome-modal');
    const closeWelcome = document.getElementById('close-welcome');

    // Show welcome modal when the page loads
    welcomeModal.style.display = "block";

    // Close the welcome modal
    closeWelcome.addEventListener('click', function () {
        welcomeModal.style.display = "none";
    });
});