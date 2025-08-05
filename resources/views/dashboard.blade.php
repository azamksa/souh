<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("! لقد سجلت الدخول بنجاح") }}

                    <!-- زر الرجوع -->
                    <div class="mt-6 text-left">
                        <a href="{{ url('/welcome') }}"
                        style="background-color: #1a99d4ff; color: #351465ff;"
                        class="inline-flex items-center px-5 py-2 font-semibold rounded-full shadow-md hover:opacity-90 transition-all duration-300">
                         <i class="fas fa-arrow-right ml-2"></i>
                            الرجوع إلى الصفحة الرئيسية
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
