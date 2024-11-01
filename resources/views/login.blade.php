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

            <div id="username-row" class="mb-4 hidden">
                <input type="text" name="username" placeholder="Username" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <input type="password" name="password" value="HelloWorld2024!" placeholder="Password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div id="confirm-password-row" class="mb-4 hidden">
                <input type="password" name="confirm" value="HelloWorld2024!" placeholder="Confirm Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div id="phone-row" class="mb-4 hidden">
                <input type="text" name="phone" value="+31636356931" placeholder="Phone Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex items-center justify-between">
                <input type="submit" name="submit" id="login-submit" value="Log In" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const loginSubmit = document.getElementById('login-submit');
            const usernameRow = document.getElementById('username-row');
            const confirmPasswordRow = document.getElementById('confirm-password-row');
            const phoneRow = document.getElementById('phone-row');

            document.getElementById('show-login').addEventListener('click', function () {
                usernameRow.classList.add('hidden');
                confirmPasswordRow.classList.add('hidden');
                phoneRow.classList.add('hidden');

                loginSubmit.value = 'Log In';
                loginForm.action = '/login';
            });

            document.getElementById('show-register').addEventListener('click', function () {
                usernameRow.classList.remove('hidden');
                confirmPasswordRow.classList.remove('hidden');
                phoneRow.classList.remove('hidden');

                loginSubmit.value = 'Sign Up';
                loginForm.action = '/login';
            });
        });
    </script>
@endsection
