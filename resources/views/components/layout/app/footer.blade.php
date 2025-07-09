@props([])

















<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('footer.about_heading') }}</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.about_company') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.about_team') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.about_careers') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.about_blog') }}</a></li>
                    </ul>
                </div>

                <!-- Resources section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('footer.resources_heading') }}</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.resources_docs') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.resources_help') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.resources_support') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.resources_contact') }}</a></li>
                    </ul>
                </div>

                <!-- Legal section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('footer.legal_heading') }}</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.legal_privacy') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.legal_terms') }}</a></li>
                        <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('footer.legal_cookies') }}</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media & Copyright -->
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">{{ __('footer.social_facebook') }}</span>
                        <i class="ph-fill ph-facebook-logo text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">{{ __('footer.social_twitter') }}</span>
                        <i class="ph-fill ph-twitter-logo text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <span class="sr-only">{{ __('footer.social_github') }}</span>
                        <i class="ph-fill ph-github-logo text-xl"></i>
                    </a>
                </div>
                <p class="text-base text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ __('common.app_name') }}. {{ __('footer.copyright') }}
                </p>
            </div>
        </div>
    </div>
</footer> 