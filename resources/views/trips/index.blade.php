<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرحلات المتاحة - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.15"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.15"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .pulse-slow {
            animation: pulse 3s infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-overlay {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600">
                        <i class="fas fa-plane text-3xl"></i>
                        <span class="mr-2">سواح</span>
                    </a>
                    <span class="text-gray-600 text-sm">دليلك للسياحة والرحلات</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرئيسية</a>
                    <a href="{{ route('trips.index') }}" class="text-purple-600 font-bold">الرحلات</a>
                    @auth
                        <a href="{{ route('requests.index') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">طلباتي</a>
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">لوحة التحكم</a>
                    @endauth
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    @guest
                        <a href="{{ route('login') }}" class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors font-medium">
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="border border-purple-600 text-purple-600 px-6 py-2 rounded-full hover:bg-purple-50 transition-colors font-medium">
                            <i class="fas fa-user-plus ml-2"></i>
                            إنشاء حساب
                        </a>
                    @else
                        <div class="relative">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <span class="text-gray-700">مرحباً، {{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition-colors">
                                        <i class="fas fa-sign-out-alt"></i>
                                        تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="hero-bg py-20">
        <div class="container mx-auto px-4 text-center text-white">
            <div class="floating">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    <i class="fas fa-map-marked-alt mb-4 text-yellow-300"></i>
                    <br>الرحلات المتاحة
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed">
                    اكتشف أجمل الوجهات السياحية حول العالم مع باقات متنوعة تناسب جميع الأذواق
                </p>
            </div>
        </div>
    </section>

    <!-- Alert for Guests -->
    @guest
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-center py-4 px-4">
        <div class="flex items-center justify-center space-x-2 space-x-reverse">
            <i class="fas fa-info-circle animate-bounce"></i>
            <span class="font-medium">لمشاهدة تفاصيل الرحلات وإرسال الطلبات، يرجى</span>
            <a href="{{ route('login') }}" class="underline font-bold hover:text-yellow-200 transition-colors">تسجيل الدخول</a>
            <span>أو</span>
            <a href="{{ route('register') }}" class="underline font-bold hover:text-yellow-200 transition-colors">إنشاء حساب جديد</a>
        </div>
    </div>
    @endguest

    <!-- Trips Grid -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            @if($trips->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($trips as $trip)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover relative">
                        <!-- Trip Image -->
                        <div class="relative">
                            <div class="h-64 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center">
                                @if($trip->image_url && filter_var($trip->image_url, FILTER_VALIDATE_URL))
                                    <img src="{{ $trip->image_url }}" alt="{{ $trip->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-image text-white text-4xl"></i>
                                @endif
                            </div>
                            
                            <!-- Trip Badges -->
                            @if($trip->is_featured)
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <i class="fas fa-star ml-1"></i>
                                مميزة
                            </div>
                            @endif

                            <!-- Price Badge -->
                            <div class="absolute bottom-4 left-4 bg-white bg-opacity-95 px-4 py-2 rounded-full shadow-lg">
                                <div class="text-2xl font-bold text-purple-600">{{ number_format($trip->price) }} ريال</div>
                            </div>
                        </div>

                        <!-- Trip Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $trip->title }}</h3>
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                <span>{{ $trip->destination }}</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                {{ Str::limit($trip->description, 100) }}
                            </p>

                            <!-- Trip Duration -->
                            <div class="flex items-center text-gray-500 mb-4 text-sm">
                                <i class="fas fa-calendar-alt ml-2"></i>
                                <span>من {{ $trip->start_date->format('d/m/Y') }} إلى {{ $trip->end_date->format('d/m/Y') }}</span>
                            </div>

                            <!-- Action Button -->
                            <div class="flex items-center justify-between">
                                @auth
                                    <a href="{{ route('trips.show', $trip) }}" 
                                       class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors font-medium flex items-center">
                                        <i class="fas fa-eye ml-2"></i>
                                        عرض التفاصيل
                                    </a>
                                @else
                                    <button onclick="showLoginModal()" 
                                            class="bg-gray-400 text-white px-6 py-3 rounded-full font-medium flex items-center">
                                        <i class="fas fa-lock ml-2"></i>
                                        سجل دخولك للمشاهدة
                                    </button>
                                @endauth
                                
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-clock ml-1"></i>
                                    {{ $trip->end_date->diffInDays($trip->start_date) }} أيام
                                </div>
                            </div>
                        </div>

                        <!-- Guest Overlay -->
                        @guest
                        <div class="absolute inset-0 login-overlay rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-lock text-4xl mb-4"></i>
                                <h3 class="text-xl font-bold mb-2">سجل دخولك</h3>
                                <p class="mb-4">لمشاهدة تفاصيل الرحلة كاملة</p>
                                <div class="space-x-2 space-x-reverse">
                                    <a href="{{ route('login') }}" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                        تسجيل الدخول
                                    </a>
                                    <a href="{{ route('register') }}" class="border border-white text-white px-4 py-2 rounded-full hover:bg-white hover:text-purple-600 transition-colors">
                                        إنشاء حساب
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endguest
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $trips->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <i class="fas fa-plane-slash text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">لا توجد رحلات متاحة حالياً</h3>
                    <p class="text-gray-500 mb-8">سنقوم بإضافة رحلات جديدة قريباً</p>
                    <a href="{{ route('home') }}" class="bg-purple-600 text-white px-8 py-3 rounded-full hover:bg-purple-700 transition-colors font-medium">
                        <i class="fas fa-home ml-2"></i>
                        العودة للرئيسية
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-plane text-purple-400 text-2xl ml-2"></i>
                    <span class="text-2xl font-bold">سواح</span>
                </div>
                <p class="text-gray-400">&copy; 2025 سواح. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script>
        // Show login modal for guests
        function showLoginModal() {
            alert('يرجى تسجيل الدخول أولاً لمشاهدة تفاصيل الرحلة');
            window.location.href = '{{ route("login") }}';
        }
    </script>
</body>
</html>