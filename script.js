document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    const userTableBody = document.getElementById('userTableBody');
    const adminFilterBtn = document.getElementById('adminFilterBtn');
    const showAllBtn = document.getElementById('showAllBtn');
    const messageDiv = document.getElementById('message');

    /**
     * TASK 1: Handle User Registration
     * Requirement: Forms should NOT reload page. Use fetch().
     */
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // This stops the page from refreshing

            // 1. Collect Data from Frontend
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const role = document.getElementById('role').value;

            // 2. Frontend Validation (Requirement #3)
            if (!name || !email || !password || !role) {
                displayMessage("All fields are required!", "orange");
                return;
            }

            const formData = { name, email, password, role };

            try {
                // 3. API-based communication (fetch)
                const response = await fetch('insert.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.status === 'success') {
                    displayMessage("✔ " + result.message, "green");
                    registerForm.reset();
                    fetchUsers(); // Refresh dashboard table
                } else {
                    // Logic Requirement #1 & #2: Error handling for Admin count and Duplicates
                    displayMessage("✖ " + result.message, "red");
                }
            } catch (error) {
                console.error("Fetch error:", error);
                displayMessage("Server error. Ensure insert.php exists and works.", "red");
            }
        });
    }

    /**
     * TASK 2: Fetch Users for Dashboard
     * Requirement: API-based communication using fetch()
     */
    async function fetchUsers(roleFilter = '') {
        try {
            // Requirement #4: Filter via API or frontend logic
            const url = roleFilter ? `users.php?role=${roleFilter}` : 'users.php';
            const response = await fetch(url);
            const users = await response.json();

            userTableBody.innerHTML = ''; // Clear current rows

            if (users.length === 0) {
                userTableBody.innerHTML = '<tr><td colspan="3" style="text-align:center;">No records found.</td></tr>';
                return;
            }

            users.forEach(user => {
                const badgeClass = user.role === 'admin' ? 'badge-admin' : 'badge-user';
                const row = `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td><span class="badge ${badgeClass}">${user.role}</span></td>
                    </tr>
                `;
                userTableBody.innerHTML += row;
            });
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    }

    /**
     * TASK 3: Filter Buttons Logic (Requirement #4)
     */
    if (adminFilterBtn) {
        adminFilterBtn.addEventListener('click', () => {
            fetchUsers('admin');
        });
    }

    if (showAllBtn) {
        showAllBtn.addEventListener('click', () => {
            fetchUsers();
        });
    }

    // Helper function to show messages
    function displayMessage(text, color) {
        messageDiv.style.color = color;
        messageDiv.innerText = text;
    }

    // Initial table load on page visit
    fetchUsers();
});