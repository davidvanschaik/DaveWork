@foreach($errors as $error)
    <div class="error-message fixed bottom-4 right-4 bg-orange-500 text-white w-[30%] h-10 mb-2 flex items-center justify-center hidden">
        <p>{{ $error }}</p>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach((message, index) => {
            setTimeout(function() {
                message.classList.remove('hidden');
                setTimeout(function() {
                    message.classList.add('hidden');
                }, 5000); // Hide after 5 seconds
            }, index * 500); // Stagger display times by 0.5 seconds
        });
    });
</script>