<form method="POST" action="/login">
    <input type="text" name="email" placeholder="Email">
    <p><?php echo e($errors['email']); ?></p>
    <input type="password" name="password" placeholder="Password">
    <p><?php echo e($errors['password']); ?></p>
    <button type="submit">Login</button>
</form><?php /**PATH /Users/david.vanschaik/Desktop/bit-academy/PlayGround/DaveWork/resources/views/login.blade.php ENDPATH**/ ?>