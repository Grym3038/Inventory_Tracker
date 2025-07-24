<?php include('Views/_partials/header.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Pricing Plans</h1>
        <p class="text-xl text-gray-600">Choose the perfect plan for your inventory management needs</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Basic Plan -->
        <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-200">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Basic</h3>
                <div class="text-4xl font-bold text-blue-600 mb-6">$29<span class="text-lg text-gray-600">/month</span></div>
                <p class="text-gray-600 mb-8">Perfect for small businesses</p>
            </div>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Up to 1,000 items
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    5 users
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Basic reporting
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Email support
                </li>
            </ul>
            <br>
            <br>
            <a href="?action=loginForm" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Get Started
            </a>
        </div>

        <!-- Professional Plan -->
        <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-blue-500 relative">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
            </div>
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Professional</h3>
                <div class="text-4xl font-bold text-blue-600 mb-6">$79<span class="text-lg text-gray-600">/month</span></div>
                <p class="text-gray-600 mb-8">Ideal for growing businesses</p>
            </div>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Up to 10,000 items
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    25 users
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Advanced reporting
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Priority support
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    API access
                </li>
            </ul>
            <a href="?action=loginForm" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Get Started
            </a>
        </div>

        <!-- Enterprise Plan -->
        <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-200">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise</h3>
                <div class="text-4xl font-bold text-blue-600 mb-6">$199<span class="text-lg text-gray-600">/month</span></div>
                <p class="text-gray-600 mb-8">For large organizations</p>
            </div>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Unlimited items
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Unlimited users
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Custom reporting
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    24/7 phone support
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Custom integrations
                </li>
            </ul>
            <a href="?action=loginForm" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Contact Sales
            </a>
        </div>
    </div>
</div>

<?php include('Views/_partials/fullFooter.php'); ?> 