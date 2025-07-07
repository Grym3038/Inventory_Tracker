<?php include('Views/_partials/header.php'); ?>

<?php 
require "vendor/autoload.php";
$client = new Google\Client;

$client->setAuthConfig( 'credentials.json');

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>

<div class=" w-full h-screen ">


<div class="container m-auto p-4 flex  w-full h-full items-center justify-center">
        <div class="w-[35rem] h-[50rem] max-w-lg m-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-4xl py-6 flex items-center justify-center">
            <div class="p-10 m-auto h-[80%] w-[80%]">
                <!-- Toggle between Login and Signup -->
                <div class="flex justify-center mb-8">
                    <button id="loginTab" class="px-6 py-2 font-medium text-white bg-blue-500 rounded-l-lg focus:outline-none">
                        Login
                    </button>
                    <button id="signupTab" class="px-6 py-2 font-medium text-blue-500 bg-white border border-blue-500 rounded-r-lg focus:outline-none">
                        Sign Up
                    </button>

                </div>

                <!-- Login Form -->
                <form id="loginForm" class="space-y-6">
                    <h2 class="text-2xl font-bold text-center text-gray-800">Welcome Back</h2>
                    <div>
                        <label for="loginEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="loginEmail"   name="loginEmail" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="loginPassword" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="loginPassword" name="loginPassword" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-500 hover:text-blue-700">Forgot password?</a>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Sign in
                        </button>
                    </div>
                </form>

                <!-- Signup Form (Hidden by default) -->
                <form id="signupForm" class="space-y-6 hidden">
                    <h2 class="text-2xl font-bold text-center text-gray-800">Create Account</h2>
                    <div>
                        <label for="signupName" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="signupName" name="signupName" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="signupEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="signupEmail" name="signupEmail" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="signupPassword" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="signupPassword" name="signupPassword" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-500 hover:text-blue-700">Terms and Conditions</a>
                        </label>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Account
                        </button>
                    </div>
                </form>

                <!-- Social Login -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-3">
                        <a href="<?= $url ?>">
                            <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <img class="w-6 h-6" src="https://www.svgrepo.com/show/475656/google-color.svg" loading="lazy" alt="google logo">
                            </button>  
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script>
       document.addEventListener('DOMContentLoaded', () => {
        // Forms & tabs
        const loginTab     = document.getElementById('loginTab');
        const signupTab    = document.getElementById('signupTab');
        const loginForm    = document.getElementById('loginForm');
        const signupForm   = document.getElementById('signupForm');

        // Set form actions to point at home controller
        loginForm.action  = '?action=login';
        loginForm.method  = 'POST';
        signupForm.action = '?action=signup';
        signupForm.method = 'POST';

        // Toggle views
        signupTab.addEventListener('click', e => {
            e.preventDefault();
            loginForm.classList.add('hidden');
            signupForm.classList.remove('hidden');
            loginTab.classList.replace('bg-blue-500', 'bg-white');
            loginTab.classList.replace('text-white', 'text-blue-500');
            signupTab.classList.replace('bg-white', 'bg-blue-500');
            signupTab.classList.replace('text-blue-500', 'text-white');
        });
        loginTab.addEventListener('click', e => {
            e.preventDefault();
            signupForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            signupTab.classList.replace('bg-blue-500', 'bg-white');
            signupTab.classList.replace('text-white', 'text-blue-500');
            loginTab.classList.replace('bg-white', 'bg-blue-500');
            loginTab.classList.replace('text-blue-500', 'text-white');
        });

        // email regex
        const validEmail = email => /\S+@\S+\.\S+/.test(email);

        // Handle login submit
        loginForm.addEventListener('submit', e => {
            e.preventDefault();
            const email    = loginForm.loginEmail.value.trim();
            const password = loginForm.loginPassword.value;

            if (!validEmail(email)) {
            return alert('Please enter a valid email address.');
            }
            if (password.length < 6) {
            return alert('Password must be at least 6 characters.');
            }

            loginForm.submit();
        });

        // Handle signup submit
        signupForm.addEventListener('submit', e => {
            e.preventDefault();
            const name            = signupForm.signupName.value.trim();
            const email           = signupForm.signupEmail.value.trim();
            const password        = signupForm.signupPassword.value;
            const confirmPassword = signupForm.confirmPassword.value;
            const termsAccepted   = signupForm.terms.checked;

            if (name.length < 2) {
            return alert('Please enter your full name.');
            }
            if (!validEmail(email)) {
            return alert('Please enter a valid email address.');
            }
            if (password.length < 6) {
            return alert('Password must be at least 6 characters.');
            }
            if (password !== confirmPassword) {
            return alert('Passwords do not match.');
            }
            if (!termsAccepted) {
            return alert('You must agree to the Terms and Conditions.');
            }

            signupForm.submit();
            
        });
        });

    </script>
<?php include('Views/_partials/fullFooter.php'); ?>
