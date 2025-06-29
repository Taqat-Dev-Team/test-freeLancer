document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login_form');
    const signInSubmitButton = document.getElementById('kt_sign_in_submit');

    // Function to clear previous error messages
    function clearErrors() {
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
    }

    // Function to display server-side errors
    function displayErrors(errors) {
        clearErrors(); // Clear existing errors first

        // Display field-specific errors
        if (errors.errors) {
            for (const field in errors.errors) {
                const errorMessage = errors.errors[field][0]; // Get the first error message for the field
                const errorFieldContainer = document.querySelector(`[data-field-error="${field}"]`);
                const inputField = loginForm.querySelector(`[name="${field}"]`);

                if (errorFieldContainer) {
                    errorFieldContainer.innerHTML = errorMessage;
                }
                if (inputField) {
                    inputField.classList.add('is-invalid');
                }
            }
        }
    }


    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        clearErrors(); // Clear any previous errors

        // Show loading indicator
        signInSubmitButton.setAttribute('data-kt-indicator', 'on');
        signInSubmitButton.disabled = true;

        const formData = new FormData(loginForm); // Get form data

        fetch(loginForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to detect AJAX
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
            .then(response => {
                // Check if response is JSON (e.g., validation errors)
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json().then(data => {
                        if (!response.ok) {
                            return Promise.reject(data); // Propagate error for .catch()
                        }
                        return data;
                    });
                } else {
                    // If not JSON, it might be a redirect or other non-error response
                    if (response.ok && response.redirected) {
                        window.location.href = response.url; // Handle successful redirect
                        return; // Stop further processing
                    }
                    // If not JSON and not a redirect, something unexpected happened
                    return response.text().then(text => {
                        const errorData = {message: 'An unexpected error occurred. Please try again later.'};
                        try {
                            const parsedData = JSON.parse(text);
                            if (parsedData && parsedData.message) {
                                errorData.message = parsedData.message;
                            }
                        } catch (e) {
                            // Not a JSON, use generic message
                        }
                        return Promise.reject(errorData);
                    });
                }
            })
            .then(data => {
                // Success response from Laravel
                if (data && data.redirect) {
                    toastr.success(data.message || 'Login successful! Redirecting...');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000); // Small delay to show toastr message
                } else {
                    toastr.success('Login successful!');
                    // Handle cases where Laravel returns success without explicit redirect (less common for login)
                    // You might want to redirect to a default dashboard here
                    window.location.href = '/admin/dashboard'; // Example redirect
                }
            })
            .catch(error => {
                // Error handling (e.g., validation errors, server errors)
                console.error('Login error:', error);
                if (error) {
                    displayErrors(error); // Display errors on the form and with Toastr
                } else {
                    toastr.error('An unknown error occurred. Please try again.');
                }
            })
            .finally(() => {
                // Hide loading indicator
                signInSubmitButton.removeAttribute('data-kt-indicator');
                signInSubmitButton.disabled = false;
            });
    });
});
