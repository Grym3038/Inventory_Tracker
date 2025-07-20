
<!DOCTYPE html>
<html lang="en-us" class=" ">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShelfAware</title>

        <link rel="stylesheet" href="src\output.css" />

    <link rel="stylesheet" href="Lib\CSS\styles.css?v=1.4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="Lib\Images\New-logo.svg" rel="icon" meda="(prefers-color-scheme: light)">
    <link href="Lib\Images\New-logo-white.svg" rel="icon" media="(prefers-color-scheme: dark)">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>


</head>
<body class=" bg-custom-blobs text-black h-screen pt-5">


    <header class="border-gray-200  text-black">
        <div class="animate-slide-down md:w-[90%] lg:w-[90%] xl:max-w-[75%] md:mx-auto lg:mx-auto px-0 sm:px-5 lg:px-18 py-5 md:bg-[#0000000a] border-b-2 border-[#00000033] md:border-[#cccccc00] md:rounded-2xl lg:rounded-full">
            <div class="flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex-shrink-0 flex row">
                    <img src="Lib\Images\New-logo.svg" alt="" class="w-[2rem] lg:w-[3rem] mr-1">
                    <span class="self-center text-[1.5rem] md:text-lg lg:text-[1.5rem] font-semibold whitespace-nowrap text-black font-rubik">ShelfAware</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden lg:flex space-x-10 text-sm lg:text-md">
                    <a href="." class="text-gray-700 font-semibold hover:text-black transition-all">Home</a>
                    <a href="?action=pricing" class="text-gray-700 font-semibold hover:text-black transition-all">Pricing</a>
                    <a href="?action=About" class="text-gray-700 font-semibold hover:text-black transition-all">About Us</a>
                    <a href="?action=Contact" class="text-gray-700 font-semibold hover:text-black transition-all">Contact</a>
                </nav>

                <!-- Call-to-Action Button -->
                <div class="hidden md:flex justify-around w-[20rem] lg:w-[30%]">
                    <a href="?action=loginForm" class="bg-gray-200 border-1 border-gray-300 hover:bg-[#003980] font-bold text-gray-700 py-2 px-6 rounded-full text-md lg:text-md transition-all">
                        Login
                    </a>
                    <a href="?action=pricing" class="bg-[#0078FF] border-1 border-blue-800 hover:bg-[#003980] font-bold text-white py-2 px-6 rounded-full text-md lg:text-md transition-all">
                        Start Free Trial
                    </a>
                </div>

                <!-- Mobile Menu Button (for smaller screens) -->
                <div class="lg:hidden flex items-center  px-10 sm:px-16">
                    <button id="menu-button" class="text-black focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="lg:hidden mt-5 hidden space-y-4 transition-all duration-100">
                <div class="flex md:hidden justify-around border-b-1 border-gray-300 w-full pb-3">
                    <a href="?action=loginForm" class="bg-gray-200 border-1 border-gray-300 hover:bg-[#003980] font-bold text-gray-700 py-2 px-6 rounded-full text-md lg:text-lg transition-all">
                        Login
                    </a>
                    <a href="?action=pricing" class="bg-[#0078FF] border-1 border-blue-800 hover:bg-[#003980] font-bold text-white py-2 px-6 rounded-full text-md lg:text-lg transition-all">
                        Start Free Trial
                    </a>
                </div>
                <a href="." class="block text-lg text-gray-700 font-semibold hover:text-black transition-all px-10 sm:px-16">Home</a>
                <a href="?action=pricing" class="block text-lg text-gray-700 font-semibold hover:text-black transition-all px-10 sm:px-16">Pricing</a>
                <a href="?action=About" class="block text-lg text-gray-700 font-semibold hover:text-black transition-all px-10 sm:px-16">About Us</a>
                <a href="?action=Contact" class="block text-lg text-gray-700 font-semibold hover:text-black transition-all px-10 sm:px-16">Contact</a>

            </div>
        </div>
    </header>
        <script>
        // Mobile Menu Toggle
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
