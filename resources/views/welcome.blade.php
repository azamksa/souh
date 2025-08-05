<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سواح - دليلك للسياحة والرحلات</title>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Alert Banner for Guest Users -->
    @guest
    <div id="guest-alert" class="bg-gradient-to-r from-orange-500 to-red-500 text-white text-center py-3 px-4 relative">
        <div class="flex items-center justify-center space-x-2 space-x-reverse">
            <i class="fas fa-info-circle animate-bounce"></i>
            <span class="font-medium">مرحباً بك في سواح! للاستفادة من جميع الميزات والحجز</span>
            <a href="{{ route('register') }}" class="underline font-bold hover:text-yellow-300 transition-colors">سجل دخولك هنا</a>
        </div>
        <button onclick="document.getElementById('guest-alert').style.display='none'" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-yellow-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endguest

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="text-2xl font-bold text-purple-600">
                        <i class="fas fa-plane text-3xl"></i>
                        <span class="mr-2">سواح</span>
                    </div>
                    <span class="text-gray-600 text-sm">دليلك للسياحة والرحلات</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                    <a href="#home" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرئيسية</a>
                    <a href="{{ route('trips.index') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرحلات</a>
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

    <!-- Hero Section -->
    <section id="home" class="hero-bg min-h-screen flex items-center relative">
        <div class="container mx-auto px-4 text-center text-white relative z-10">
            <div class="floating">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    اكتشف العالم مع
                    <span class="text-yellow-300">سواح</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed">
                    رحلات استثنائية، تقييمات حقيقية، وأسعار تنافسية لأجمل الوجهات السياحية حول العالم
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4 md:space-x-reverse mb-12">
                <a href="{{ route('trips.index') }}" class="bg-yellow-400 text-purple-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transition-all transform hover:scale-105 shadow-xl">
                    <i class="fas fa-search ml-2"></i>
                    استكشف الرحلات
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">500+</div>
                    <div class="text-sm md:text-base">وجهة سياحية</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">10k+</div>
                    <div class="text-sm md:text-base">عميل سعيد</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">25+</div>
                    <div class="text-sm md:text-base">دولة</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">4.7★</div>
                    <div class="text-sm md:text-base">تقييم العملاء</div>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 right-10 text-white text-6xl opacity-20 floating" style="animation-delay: -2s;">
            <i class="fas fa-mountain"></i>
        </div>
        <div class="absolute bottom-20 left-10 text-white text-4xl opacity-20 floating" style="animation-delay: -4s;">
            <i class="fas fa-ship"></i>
        </div>
        <div class="absolute top-1/2 left-20 text-white text-5xl opacity-20 floating" style="animation-delay: -1s;">
            <i class="fas fa-umbrella-beach"></i>
        </div>
    </section>

    <!-- Featured Trips -->
    <section id="trips" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">الرحلات المميزة</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">اختر من مجموعة متنوعة من الرحلات المصممة خصيصاً لتناسب جميع الأذواق والميزانيات</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Trip Card 1 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="relative">
                        <img src="{{ asset('https://www.terhalak.com/wp-content/uploads/2020/08/honeymoon-in-the-Maldives.jpg') }}" alt="Trip 1" class="w-full h-64 object-cover">
                        <!-- <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-500"></div>
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-camera text-white text-4xl"></i>
                        </div> -->
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            مميزة
                        </div>
                        <div class="absolute bottom-4 left-4 bg-white bg-opacity-90 px-3 py-1 rounded-full">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <span class="mr-1 text-gray-800 font-bold">4.8</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">رحلة إلى جزر المالديف</h3>
                        <p class="text-gray-600 mb-4">استمتع بأجمل الشواطئ والمياه الفيروزية في جنة على الأرض</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">2,500 ريال</div>
                            <a href="{{ route('trips.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 2 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="relative">
                        <img src="{{ asset('https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800') }}" alt="Trip 1" class="w-full h-64 object-cover">
                        <!-- <div class="h-64 bg-gradient-to-br from-green-400 to-blue-500"></div>
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-mountain text-white text-4xl"></i>
                        </div> -->
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            جديدة
                        </div>
                        <div class="absolute bottom-4 left-4 bg-white bg-opacity-90 px-3 py-1 rounded-full">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <span class="mr-1 text-gray-800 font-bold">4.6</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">مغامرة في جبال الألب</h3>
                        <p class="text-gray-600 mb-4">تسلق أعلى القمم واستمتع بالطبيعة الخلابة والهواء النقي</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">3,200 ريال</div>
                            <a href="{{ route('trips.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 3 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="relative">
                        <img src="{{ asset('https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=800') }}" alt="Trip 1" class="w-full h-64 object-cover">
                        <!-- <div class="h-64 bg-gradient-to-br from-orange-400 to-red-500"></div>
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-umbrella-beach text-white text-4xl"></i>
                        </div> -->
                        <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            الأكثر طلباً
                        </div>
                        <div class="absolute bottom-4 left-4 bg-white bg-opacity-90 px-3 py-1 rounded-full">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <span class="mr-1 text-gray-800 font-bold">4.9</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">استرخاء في بالي</h3>
                        <p class="text-gray-600 mb-4">شواطئ ساحرة، ثقافة غنية، ومنتجعات فاخرة في جزيرة الآلهة</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">1,800 ريال</div>
                            <a href="{{ route('trips.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('trips.index') }}" class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-eye ml-2"></i>
                    عرض جميع الرحلات
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">لماذا تختار سواح؟</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">نحن نقدم تجربة سفر متكاملة تجمع بين الجودة والراحة والأسعار المناسبة</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">ضمان الجودة</h3>
                    <p class="text-gray-600">جميع رحلاتنا مضمونة بأعلى معايير الجودة والأمان</p>
                </div>

                <div class="text-center p-6 bg-white rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dollar-sign text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">أسعار تنافسية</h3>
                    <p class="text-gray-600">نقدم أفضل الأسعار مع باقات متنوعة تناسب جميع الميزانيات</p>
                </div>

                <div class="text-center p-6 bg-white rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">دعم 24/7</h3>
                    <p class="text-gray-600">فريق دعم متاح على مدار الساعة لمساعدتك في أي وقت</p>
                </div>

                <div class="text-center p-6 bg-white rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">تجارب لا تُنسى</h3>
                    <p class="text-gray-600">نحن نصمم كل رحلة لتكون تجربة استثنائية تبقى في الذاكرة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">جاهز للمغامرة؟</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">انضم إلى آلاف المسافرين الذين اختاروا سواح لرحلاتهم المميزة</p>
            <div class="space-y-4 md:space-y-0 md:space-x-4 md:space-x-reverse md:flex md:justify-center">
                <a href="{{ route('trips.index') }}" class="bg-yellow-400 text-purple-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transition-all transform hover:scale-105 shadow-xl pulse-slow block md:inline-block">
                    <i class="fas fa-rocket ml-2"></i>
                    ابدأ رحلتك الآن
                </a>
                <a href="#contact" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-purple-600 transition-all block md:inline-block">
                    <i class="fas fa-phone ml-2"></i>
                    اتصل بنا
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-plane text-purple-400 text-2xl ml-2"></i>
                        <span class="text-2xl font-bold">سواح</span>
                    </div>
                    <p class="text-gray-400 mb-4">دليلك الموثوق للسياحة والرحلات حول العالم</p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">الخدمات</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('trips.index') }}" class="text-gray-400 hover:text-white transition-colors">حجز الرحلات</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">تقييم الأماكن</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الاستشارات السياحية</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">التأمين السياحي</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">معلومات</h3>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">من نحن</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الشروط والأحكام</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">سياسة الخصوصية</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">تواصل معنا</h3>
                    <div class="space-y-2 text-gray-400">
                        <div class="flex items-center">
                            <i class="fas fa-phone ml-2"></i>
                            <span>+966 11 123 4567</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope ml-2"></i>
                            <span>info@sawah.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt ml-2"></i>
                            <span>الرياض، المملكة العربية السعودية</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 سواح. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 100) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        });

        // Auto-hide guest alert after 10 seconds
        setTimeout(function() {
            const alert = document.getElementById('guest-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.style.display = 'none', 500);
            }
        }, 10000);
    </script>
</body>
</html>