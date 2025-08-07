<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $trip->title }} - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        }
        .rating-star {
            transition: color 0.2s ease;
            cursor: pointer;
        }
        .rating-star:hover,
        .rating-star.active {
            color: #f59e0b;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
                </div>
                
                <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرئيسية</a>
                    <a href="{{ route('trips.index') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">الرحلات</a>
                    <a href="{{ route('requests.index') }}" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">طلباتي</a>
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

    <!-- Trip Hero Section -->
    <section class="relative">
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ $trip->image_url }}');">
            <div class="hero-bg h-full flex items-center">
                <div class="container mx-auto px-4 text-white">
                    <div class="max-w-4xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $trip->title }}</h1>
                        <div class="flex items-center space-x-4 space-x-reverse mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                <span class="text-xl">{{ $trip->destination }}</span>
                            </div>
                            <div class="flex items-center">
                                @if($trip->total_ratings > 0)
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $trip->average_rating ? 'text-yellow-300' : 'text-gray-400' }}"></i>
                                    @endfor
                                    <span class="mr-2">{{ number_format($trip->average_rating, 1) }} ({{ $trip->total_ratings }} تقييم)</span>
                                @else
                                    <span class="text-gray-300">لا توجد تقييمات بعد</span>
                            </script>
</body>
</html>
                            </div>
                        </div>
                        <div class="text-3xl font-bold mb-6">{{ $trip->formatted_price }}</div>
                        <div class="flex items-center space-x-4 space-x-reverse text-lg">
                            <div>
                                <i class="fas fa-calendar-alt ml-2"></i>
                                {{ $trip->duration }} أيام
                            </div>
                            <div>
                                <i class="fas fa-clock ml-2"></i>
                                من {{ $trip->start_date->format('d/m/Y') }} إلى {{ $trip->end_date->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trip Details & Rating -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">وصف الرحلة</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $trip->description }}</p>
                    </div>

                    <!-- Rating System -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">التقييمات والمراجعات</h2>
                        
                        <!-- Rating Summary -->
                        <div class="flex items-center space-x-8 space-x-reverse mb-8">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-purple-600 mb-2">
                                    {{ $trip->total_ratings > 0 ? number_format($trip->average_rating, 1) : '0.0' }}
                                </div>
                                <div class="flex justify-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $trip->average_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">{{ $trip->total_ratings }} تقييم</div>
                            </div>
                            
                            @if($trip->total_ratings > 0)
                            <div class="flex-1">
                                @php $distribution = $trip->getRatingDistribution(); @endphp
                                @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center mb-2">
                                    <span class="w-12 text-sm">{{ $i }} نجوم</span>
                                    <div class="flex-1 mx-4 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $distribution[$i]['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $distribution[$i]['count'] }}</span>
                                </div>
                                @endfor
                            </div>
                            @endif
                        </div>

                        <!-- Add Rating Form -->
                        @php $userRating = $trip->userRating(auth()->id()); @endphp
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">
                                {{ $userRating ? 'تحديث تقييمك' : 'أضف تقييمك' }}
                            </h3>
                            <form action="{{ route('ratings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">التقييم</label>
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="rating-star fas fa-star text-2xl text-gray-300" 
                                           data-rating="{{ $i }}"
                                           onclick="setRating({{ $i }})"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ $userRating ? $userRating->rating : '' }}">
                                </div>
                                
                                <div class="mb-6">
                                    <label for="review" class="block text-gray-700 font-semibold mb-2">مراجعتك (اختياري)</label>
                                    <textarea name="review" id="review" rows="4" 
                                              class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
                                              placeholder="اكتب تجربتك مع هذه الرحلة...">{{ $userRating ? $userRating->review : '' }}</textarea>
                                </div>
                                
                                <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors font-semibold">
                                    <i class="fas fa-star ml-2"></i>
                                    {{ $userRating ? 'تحديث التقييم' : 'إضافة التقييم' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    @if($trip->total_ratings > 0)
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">آراء المسافرين</h3>
                        <div class="space-y-6">
                            @foreach($trip->latestRatings(10) as $rating)
                            <div class="border-b border-gray-100 pb-6 last:border-b-0">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center ml-3">
                                            <i class="fas fa-user text-purple-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $rating->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($rating->review)
                                <p class="text-gray-700 leading-relaxed">{{ $rating->review }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Booking Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 sticky top-24">
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-purple-600 mb-2">{{ $trip->formatted_price }}</div>
                            <div class="text-gray-600">للشخص الواحد</div>
                        </div>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">تاريخ البداية</span>
                                <span class="font-semibold">{{ $trip->start_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">تاريخ النهاية</span>
                                <span class="font-semibold">{{ $trip->end_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">المدة</span>
                                <span class="font-semibold">{{ $trip->duration }} أيام</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600">التقييم</span>
                                <div class="flex items-center">
                                    <span class="font-semibold ml-2">{{ $trip->total_ratings > 0 ? number_format($trip->average_rating, 1) : 'غير مقيم' }}</span>
                                    @if($trip->total_ratings > 0)
                                        <i class="fas fa-star text-yellow-500"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('requests.create', $trip) }}" 
                           class="w-full bg-purple-600 text-white py-3 px-6 rounded-full hover:bg-purple-700 transition-colors font-semibold text-center block">
                            <i class="fas fa-paper-plane ml-2"></i>
                            طلب الرحلة
                        </a>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('trips.index') }}" class="text-purple-600 hover:underline">
                                <i class="fas fa-arrow-right ml-1"></i>
                                العودة للرحلات
                            </a>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">معلومات سريعة</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-600 w-5"></i>
                                <span class="mr-3">{{ $trip->destination }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-purple-600 w-5"></i>
                                <span class="mr-3">{{ $trip->duration }} أيام</span>
                            </div>
                            @if($trip->is_featured)
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-500 w-5"></i>
                                <span class="mr-3">رحلة مميزة</span>
                            </div>
                            @endif
                            @if($trip->total_ratings > 0)
                            <div class="flex items-center">
                                <i class="fas fa-users text-purple-600 w-5"></i>
                                <span class="mr-3">{{ $trip->total_ratings }} شخص قيم هذه الرحلة</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
        // Rating System
        let currentRating = {{ $userRating ? $userRating->rating : 0 }};

        function setRating(rating) {
            currentRating = rating;
            document.getElementById('rating-input').value = rating;
            
            // Update star display
            document.querySelectorAll('.rating-star').forEach((star, index) => {
                if (index + 1 <= rating) {
                    star.classList.add('active');
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-500');
                } else {
                    star.classList.remove('active');
                    star.classList.remove('text-yellow-500');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Initialize rating display
        if (currentRating > 0) {
            setRating(currentRating);
        }

        // Hover effects
        document.querySelectorAll('.rating-star').forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                document.querySelectorAll('.rating-star').forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });

            star.addEventListener('mouseleave', () => {
                setRating(currentRating);
            });
        });

        // Success message auto-hide
        @if(session('success'))
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
        @endif