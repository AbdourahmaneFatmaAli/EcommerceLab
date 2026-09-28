// Get the registration form
const registerForm = document.querySelector(
    "form[action='../actions/register_action.php']"
);

// Regular expressions for email and phone validation
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneRegex = /^[0-9+\-\s]{7,15}$/;

// Only run if the registration form exists
if (registerForm) {

    registerForm.addEventListener("submit", function (event) {

        let valid = true;

        // Get form fields
        const name = document.getElementById("customer_name");
        const email = document.getElementById("customer_email");
        const password = document.getElementById("customer_pass");
        const country = document.getElementById("customer_country");
        const city = document.getElementById("customer_city");
        const contact = document.getElementById("customer_contact");
        const address = document.getElementById("customer_address");

        // Remove previous error messages
        document.querySelectorAll(".field-error").forEach(function (error) {
            error.remove();
        });

        // Helper function for showing an error
        function showError(field, message) {
            const error = document.createElement("span");

            error.className = "field-error";
            error.textContent = message;

            field.parentNode.appendChild(error);

            valid = false;
        }

        // Validate name
        if (name.value.trim() === "") {
            showError(name, "Full name is required.");
        }

        // Validate email
        if (email.value.trim() === "") {
            showError(email, "Email is required.");
        } else if (!emailRegex.test(email.value.trim())) {
            showError(email, "Please enter a valid email address.");
        }

        // Validate password
        if (password.value === "") {
            showError(password, "Password is required.");
        }

        // Validate country
        if (country.value.trim() === "") {
            showError(country, "Please select your country.");
        }

        // Validate city
        if (city.value.trim() === "") {
            showError(city, "City is required.");
        }

        // Validate contact number
        if (contact.value.trim() === "") {
            showError(contact, "Contact number is required.");
        } else if (!phoneRegex.test(contact.value.trim())) {
            showError(contact, "Please enter a valid phone number.");
        }

        // Validate address
        if (address.value.trim() === "") {
            showError(address, "Address is required.");
        }

        // Stop the form from submitting if there are errors
        if (!valid) {
            event.preventDefault();
            return;
        }

        // Optional loading state
        const submitButton = registerForm.querySelector(
            'button[type="submit"]'
        );

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = "Registering...";
        }
    });
}