@extends('layouts.app')

@section('login')
    <div class="text-center mt-10">
        <h1 class="text-4xl font-bold">Resell Stock Monitor</h1>
        <h2 class="text-2xl text-gray-600 mt-2">Step Up Your Sneaker Game</h2>
    </div>
    <div class="flex justify-center mt-8">
        <button id="show-login" class="bg-blue-500 text-white px-4 py-2 rounded-l-md focus:outline-none">Log In</button>
        <button id="show-register" class="bg-gray-200 text-black px-4 py-2 rounded-r-md focus:outline-none">Sign Up</button>
    </div>
    <div class="container mx-auto mt-8 max-w-md">
        <form id="login-form" method="POST" action="/login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <input type="text" name="email" placeholder="Email Address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div id="username-row" class="mb-4 hidden">
                <input type="text" name="username" placeholder="Username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div id="confirm-password-row" class="mb-4 hidden">
                <input type="password" name="confirm" placeholder="Confirm Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <input type="submit" id="login-submit" value="Log In" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginForm = document.getElementById('login-form');
            var loginSubmit = document.getElementById('login-submit');
            var usernameRow = document.getElementById('username-row');
            var confirmPasswordRow = document.getElementById('confirm-password-row');
            var errorPopup = document.querySelector('.error');

            document.getElementById('show-login').addEventListener('click', function() {
                usernameRow.classList.add('hidden');
                confirmPasswordRow.classList.add('hidden');
                loginSubmit.value = 'Log In';
                loginForm.action = '/login';
            });

            document.getElementById('show-register').addEventListener('click', function() {
                usernameRow.classList.remove('hidden');
                confirmPasswordRow.classList.remove('hidden');
                loginSubmit.value = 'Sign Up';
                loginForm.action = '/register';
            });

            if (errorPopup.innerText.trim() !== '') {
                errorPopup.classList.remove('hidden');
                setTimeout(function() {
                    errorPopup.classList.add('hidden');
                }, 10000); // Hide after 10 seconds
            }
        });
    </script>
@endsection
