<div id="error-container" class="fixed bottom-4 right-4 w-[30%] space-y-2">
    @foreach($errors as $error)
        <div class="error-message bg-orange-500 text-white h-10 flex items-center justify-center opacity-0 translate-x-full transition-opacity transition-transform duration-500">
            <p>{{ $error }}</p>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach((message, index) => {
            setTimeout(function() {
                message.classList.remove('opacity-0', 'translate-x-full');
                setTimeout(function() {
                    message.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(function() {
                        message.remove();
                    }, 500); // Remove from DOM after fade-out
                }, 5000); // Hide after 5 seconds
            }, index * 500); // Stagger display times by 0.5 seconds
        });
    });
</script>
