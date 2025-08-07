<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة التقييمات - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
        }
        .rating-filter {
            transition: all 0.2s ease;
        }
        .rating-filter.active {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-purple-600">
                        <i class="fas fa-arrow-right ml-2"></i>
                        <span>إدارة التقييمات</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600" target="_blank">
                        <i class="fas fa-external-link-alt ml-1"></i>
                        زيارة الموقع
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                            خروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-500 text-white text-center py-3 px-4 alert-success">
        <i class="fas fa-check-circle ml-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Page Header & Stats -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">إدارة التقييمات والمراجعات</h1>
                    <p class="text-gray-600">مراقبة وإدارة تقييمات المسافرين لجميع الرحلات</p>
                </div>
                
                <!-- Rating Filter -->
                <div class="flex items-center space-x-2 space-x-reverse mt-4 lg:mt-0">
                    <span class="text-gray-700 font-semibold">تصفية حسب النجوم:</span>
                    <button onclick="filterByRating('all')" class="rating-filter bg-purple-600 text-white px-3 py-2 rounded-full text-sm font-semibold active">
                        الكل
                    </button>
                    @for($i = 5; $i >= 1; $i--)
                    <button onclick="filterByRating({{ $i }})" class="rating-filter bg-yellow-100 text-yellow-800 px-3 py-2 rounded-full text-sm font-semibold flex items-center">
                        <span>{{ $i }}</span>
                        <i class="fas fa-star mr-1 text-xs"></i>
                    </button>
                    @endfor
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-star text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $ratings->count() }}</div>
                            <div class="text-sm opacity-90">إجمالي التقييمات</div>
                        </div>
                    </div>
                </div>
                
                @php
                $avgRating = $ratings->avg('rating') ?: 0;
                $ratingCounts = $ratings->groupBy('rating')->map->count();
                @endphp
                
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ number_format($avgRating, 1) }}</div>
                            <div class="text-sm opacity-90">المتوسط العام</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-thumbs-up text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $ratingCounts->get(5, 0) + $ratingCounts->get(4, 0) }}</div>
                            <div class="text-sm opacity-90">تقييمات إيجابية</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-comment text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $ratings->whereNotNull('review')->count() }}</div>
                            <div class="text-sm opacity-90">مع مراجعات</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $ratingCounts->get(1, 0) + $ratingCounts->get(2, 0) }}</div>
                            <div class="text-sm opacity-90">تقييمات سلبية</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">توزيع التقييمات</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <canvas id="ratingsChart" width="300" height="200"></canvas>
                    </div>
                    <div class="space-y-3">
                        @for($i = 5; $i >= 1; $i--)
                        @php
                        $count = $ratingCounts->get($i, 0);
                        $percentage = $ratings->count() > 0 ? round(($count / $ratings->count()) * 100, 1) : 0;
                        @endphp
                        <div class="flex items-center">
                            <div class="flex items-center w-20">
                                <span class="text-sm font-semibold">{{ $i }}</span>
                                @for($j = 1; $j <= $i; $j++)
                                <i class="fas fa-star text-yellow-500 text-xs mr-1"></i>
                                @endfor
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            <div class="w-16 text-sm text-gray-600">{{ $count }} ({{ $percentage }}%)</div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ratings List -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="space-y-4">
                @foreach($ratings as $rating)
                <div class="rating-card bg-white rounded-xl shadow-lg p-6 card-hover" data-rating="{{ $rating->rating }}">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <!-- Rating Info -->
                        <div class="lg:col-span-2">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center ml-4">
                                        <i class="fas fa-user text-purple-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $rating->user->name }}</h3>
                                        <p class="text-gray-600">{{ $rating->user->email }}</p>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-clock text-gray-400 text-sm ml-1"></i>
                                            <span class="text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-left">
                                    <div class="flex items-center justify-end mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $rating->rating }}/5</div>
                                </div>
                            </div>

                            <!-- Trip Info -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">تفاصيل الرحلة</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-plane text-purple-600 ml-2"></i>
                                        <span class="font-medium">{{ $rating->trip->title }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-purple-600 ml-2"></i>
                                        <span>{{ $rating->trip->destination }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-money-bill-wave text-purple-600 ml-2"></i>
                                        <span>{{ number_format($rating->trip->price) }} ريال</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-purple-600 ml-2"></i>
                                        <span>متوسط تقييم الرحلة: {{ number_format($rating->trip->average_rating, 1) }} ({{ $rating->trip->total_ratings }} تقييم)</span>
                                    </div>
                                </div>
                            </div>

                            @if($rating->review)
                            <div class="bg-blue-50 border-r-4 border-blue-400 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">المراجعة</h4>
                                <p class="text-blue-700 leading-relaxed">{{ $rating->review }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Actions & Analytics -->
                        <div class="lg:col-span-2">
                            <!-- Rating Analysis -->
                            <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold text-gray-800 mb-3">تحليل التقييم</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">نوع التقييم:</span>
                                        <span class="text-sm font-semibold
                                            @if($rating->rating >= 4) text-green-600
                                            @elseif($rating->rating == 3) text-yellow-600
                                            @else text-red-600 @endif">
                                            @if($rating->rating >= 4) إيجابي جداً
                                            @elseif($rating->rating == 3) متوسط
                                            @else يحتاج انتباه @endif
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">لديه مراجعة:</span>
                                        <span class="text-sm font-semibold {{ $rating->review ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $rating->review ? 'نعم' : 'لا' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">تقييمات المستخدم:</span>
                                        <span class="text-sm font-semibold text-purple-600">{{ $rating->user->ratings->count() }} تقييم</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">متوسط تقييماته:</span>
                                        <span class="text-sm font-semibold text-purple-600">{{ number_format($rating->user->average_rating, 1) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            @if($rating->rating <= 2 || ($rating->review && strlen($rating->review) < 20))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-red-600 ml-2"></i>
                                    <span class="font-semibold text-red-800">تقييم يحتاج انتباه</span>
                                </div>
                                <p class="text-red-700 text-sm mb-3">
                                    @if($rating->rating <= 2) هذا التقييم منخفض ويمكن أن يؤثر على سمعة الرحلة.
                                    @else هذه المراجعة قصيرة جداً وقد لا تكون مفيدة للمسافرين الآخرين. @endif
                                </p>
                                <div class="flex space-x-2 space-x-reverse">
                                    <button onclick="contactUser('{{ $rating->user->email }}', '{{ $rating->user->name }}')"
                                            class="flex-1 bg-red-600 text-white py-2 px-3 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                        <i class="fas fa-envelope text-xs ml-1"></i>
                                        تواصل مع العميل
                                    </button>
                                    <button onclick="confirmDeleteRating('{{ $rating->id }}')"
                                            class="flex-1 bg-red-700 text-white py-2 px-3 rounded-lg hover:bg-red-800 transition-colors text-sm">
                                        <i class="fas fa-trash text-xs ml-1"></i>
                                        حذف التقييم
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-check-circle text-green-600 ml-2"></i>
                                    <span class="font-semibold text-green-800">تقييم ممتاز</span>
                                </div>
                                <p class="text-green-700 text-sm">هذا التقييم إيجابي ومفيد للمسافرين الآخرين.</p>
                            </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="grid grid-cols-2 gap-2">
                                <a href="mailto:{{ $rating->user->email }}" 
                                   class="bg-blue-100 text-blue-700 py-2 px-3 rounded-lg hover:bg-blue-200 transition-colors text-center text-sm">
                                    <i class="fas fa-envelope text-xs"></i>
                                    <span class="block">راسل العميل</span>
                                </a>
                                <a href="{{ route('trips.show', $rating->trip) }}" target="_blank"
                                   class="bg-purple-100 text-purple-700 py-2 px-3 rounded-lg hover:bg-purple-200 transition-colors text-center text-sm">
                                    <i class="fas fa-plane text-xs"></i>
                                    <span class="block">عرض الرحلة</span>
                                </a>
                                <button onclick="viewUserDetails('{{ $rating->user->id }}')"
                                        class="bg-gray-100 text-gray-700 py-2 px-3 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                    <i class="fas fa-user text-xs"></i>
                                    <span class="block">ملف العميل</span>
                                </button>
                                <button onclick="confirmDeleteRating('{{ $rating->id }}')"
                                        class="bg-red-100 text-red-700 py-2 px-3 rounded-lg hover:bg-red-200 transition-colors text-sm">
                                    <i class="fas fa-trash text-xs"></i>
                                    <span class="block">حذف التقييم</span>
                                </button>
                            </div>

                            <!-- Rating Timeline -->
                            <div class="mt-4 bg-gray-50 p-3 rounded-lg">
                                <h5 class="font-semibold text-gray-700 text-sm mb-2">الجدول الزمني</h5>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div>تاريخ التقييم: {{ $rating->created_at->format('d/m/Y H:i') }}</div>
                                    <div>منذ: {{ $rating->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($ratings->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">لا توجد تقييمات</h3>
                    <p class="text-gray-500">لم يتم استلام أي تقييمات حتى الآن</p>
                </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($ratings->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $ratings->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-4xl mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">تأكيد الحذف</h3>
                    <p class="text-gray-600 mb-6">هل أنت متأكد من رغبتك في حذف هذا التقييم؟ لا يمكن التراجع عن هذا الإجراء.</p>
                    
                    <div class="flex space-x-3 space-x-reverse">
                        <form id="deleteForm" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                نعم، احذف التقييم
                            </button>
                        </form>
                        <button onclick="closeDeleteModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter by rating
        function filterByRating(rating) {
            const cards = document.querySelectorAll('.rating-card');
            const buttons = document.querySelectorAll('.rating-filter');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('bg-purple-600', 'text-white', 'active');
                btn.classList.add('bg-yellow-100', 'text-yellow-800');
            });
            
            event.target.classList.remove('bg-yellow-100', 'text-yellow-800');
            event.target.classList.add('bg-purple-600', 'text-white', 'active');
            
            // Filter cards
            cards.forEach(card => {
                if (rating === 'all' || parseInt(card.dataset.rating) === rating) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Delete rating confirmation
        function confirmDeleteRating(ratingId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            
            form.action = `/admin/ratings/${ratingId}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Contact user
        function contactUser(email, name) {
            const subject = encodeURIComponent('استفسار حول تقييمك - سواح');
            const body = encodeURIComponent(`السلام عليكم ${name}،\n\nنشكرك على تقييمك لإحدى رحلاتنا. نود التواصل معك للمزيد من التفاصيل.\n\nشكراً لك\nفريق سواح`);
            window.open(`mailto:${email}?subject=${subject}&body=${body}`);
        }

        // View user details (placeholder)
        function viewUserDetails(userId) {
            // In a real app, this would open a user details modal or page
            alert('ستفتح صفحة تفاصيل العميل قريباً');
        }

        // Initialize chart
        const ctx = document.getElementById('ratingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['5 نجوم', '4 نجوم', '3 نجوم', '2 نجمة', '1 نجمة'],
                datasets: [{
                    data: [
                        {{ $ratingCounts->get(5, 0) }},
                        {{ $ratingCounts->get(4, 0) }},
                        {{ $ratingCounts->get(3, 0) }},
                        {{ $ratingCounts->get(2, 0) }},
                        {{ $ratingCounts->get(1, 0) }}
                    ],
                    backgroundColor: ['#10B981', '#22C55E', '#FCD34D', '#F97316', '#EF4444'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Auto-hide success message
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);

        // Close modal on outside click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>