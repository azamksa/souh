<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي - سواح</title>
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.15);
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
                    <a href="{{ route('trips.index') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرحلات</a>
                    <a href="{{ route('requests.index') }}" class="text-purple-600 font-bold">طلباتي</a>
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">لوحة التحكم</a>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
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
        </div>
    </nav>

    <!-- Page Header -->
    <section class="hero-bg py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <i class="fas fa-clipboard-list mb-4 text-yellow-300"></i>
                <br>طلباتي
            </h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                تتبع جميع طلبات الرحلات التي قمت بإرسالها
            </p>
        </div>
    </section>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-500 text-white text-center py-3 px-4">
        <i class="fas fa-check-circle ml-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500 text-white text-center py-3 px-4">
        <i class="fas fa-exclamation-circle ml-2"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Requests Content -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">قائمة طلباتي</h2>
                <a href="{{ route('trips.index') }}" class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors font-medium">
                    <i class="fas fa-plus ml-2"></i>
                    طلب رحلة جديدة
                </a>
            </div>

            @if($requests->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($requests as $request)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border">
                        <div class="p-6">
                            <!-- Status Badge -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 rounded-full text-sm font-bold
                                    @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status == 'approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($request->status == 'pending') 
                                        <i class="fas fa-clock ml-1"></i>قيد المراجعة
                                    @elseif($request->status == 'approved') 
                                        <i class="fas fa-check ml-1"></i>موافق عليه
                                    @else 
                                        <i class="fas fa-times ml-1"></i>مرفوض
                                    @endif
                                </span>
                                <span class="text-gray-500 text-sm">{{ $request->created_at->format('d/m/Y') }}</span>
                            </div>

                            <!-- Trip Info -->
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $request->trip->title }}</h3>
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                <span>{{ $request->trip->destination }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-money-bill-wave ml-2"></i>
                                <span>{{ number_format($request->trip->price) }} ريال</span>
                            </div>

                            <!-- Notes -->
                            @if($request->notes)
                            <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                <h4 class="font-semibold text-gray-700 mb-1">ملاحظاتك:</h4>
                                <p class="text-gray-600 text-sm">{{ $request->notes }}</p>
                            </div>
                            @endif

                            <!-- Trip Duration -->
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-calendar-alt ml-2"></i>
                                <span>من {{ $request->trip->start_date->format('d/m/Y') }} إلى {{ $request->trip->end_date->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">لم تقم بإرسال أي طلبات بعد</h3>
                    <p class="text-gray-500 mb-8">ابدأ بتصفح الرحلات المتاحة وأرسل طلبك الأول</p>
                    <a href="{{ route('trips.index') }}" class="bg-purple-600 text-white px-8 py-3 rounded-full hover:bg-purple-700 transition-colors font-medium">
                        <i class="fas fa-plane ml-2"></i>
                        تصفح الرحلات
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
        // Auto-hide success/error messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-500, .bg-red-500');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.style.display = 'none', 500);
            });
        }, 5000);
    </script>
</body>
</html>