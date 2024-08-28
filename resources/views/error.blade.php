<div id="error-container" class="fixed bottom-4 right-4 w-[30%] flex flex-col-reverse space-y-2 space-y-reverse z-50"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorContainer = document.getElementById('error-container');
        let delay = 0; // Initialize delay

        function showToast(type, message) {
            const toast = document.createElement('div');
            toast.className = `error-message ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white px-4 py-3 rounded-lg shadow-lg flex items-center justify-between transition-opacity duration-[3000ms] ease-out opacity-0 mb-2`;

            toast.innerHTML = `
                <p>${message}</p>
                <button class="ml-4 focus:outline-none text-white" onclick="this.parentElement.remove()">✖</button>
            `;

            // Insert the new toast at the top of the container
            errorContainer.prepend(toast);

            // Gradually increase the opacity to create a "mist-like" effect after a delay
            setTimeout(() => {
                toast.classList.remove('opacity-0');
                toast.classList.add('opacity-200');
            }, delay);

            // Automatically remove the toast after it has been fully visible for a while
            setTimeout(() => {
                toast.classList.remove('opacity-200');
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 3000); // Duration matches the fade-in effect
            }, delay + 4000);

            // Increase the delay for the next toast
            delay += 1000; // Adjust this value for more or less delay between toasts
        }

        // Iterate over the errors and show each as a toast with increasing delay
        @foreach($errors as $key => $error)
        showToast('{{ $key === 'success' ? 'success' : 'error' }}', '{{ $error }}');
        @endforeach
    });
</script>
