<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">About</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Company</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Team</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Blog</a></li>
                    </ul>
                </div>

                <!-- Resources section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Resources</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Documentation</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Support</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Legal section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Legal</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media & Copyright -->
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">Facebook</span>
                        <i class="ph-fill ph-facebook-logo text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">Twitter</span>
                        <i class="ph-fill ph-twitter-logo text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">GitHub</span>
                        <i class="ph-fill ph-github-logo text-xl"></i>
                    </a>
                </div>
                <p class="text-base text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer> 