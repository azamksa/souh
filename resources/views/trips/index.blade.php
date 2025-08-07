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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
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
        .rating-stars {
            display: flex;
            gap: 2px;
        }
        .filter-card {
            transition: all 0.2s ease;
        }
        .filter-card.active {
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
                
                <!-- Search and Filter Bar -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" id="searchInput" placeholder="ابحث عن وجهة..." 
                                   class="w-full bg-white bg-opacity-90 text-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        </div>
                        <div>
                            <select id="priceFilter" class="w-full bg-white bg-opacity-90 text-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">جميع الأسعار</option>
                                <option value="0-1000">أقل من 1,000 ريال</option>
                                <option value="1000-3000">1,000 - 3,000 ريال</option>
                                <option value="3000-5000">3,000 - 5,000 ريال</option>
                                <option value="5000+">أكثر من 5,000 ريال</option>
                            </select>
                        </div>
                        <div>
                            <select id="ratingFilter" class="w-full bg-white bg-opacity-90 text-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">جميع التقييمات</option>
                                <option value="4">4+ نجوم</option>
                                <option value="3">3+ نجوم</option>
                                <option value="2">2+ نجوم</option>
                            </select>
                        </div>
                        <div>
                            <button onclick="applyFilters()" class="w-full bg-yellow-400 text-purple-900 p-3 rounded-lg font-bold hover:bg-yellow-300 transition-colors">
                                <i class="fas fa-search ml-2"></i>
                                بحث
                            </button>
                        </div>
                    </div>
                </div>
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

    <!-- Filter Tags -->
    <section class="py-6 bg-white border-b">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex flex-wrap items-center space-x-3 space-x-reverse">
                    <span class="text-gray-700 font-semibold">تصفية سريعة:</span>
                    <button onclick="filterByCategory('featured')" class="filter-card bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-red-200 transition-colors">
                        <i class="fas fa-star ml-1"></i>
                        الرحلات المميزة
                    </button>
                    <button onclick="filterByCategory('topRated')" class="filter-card bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-yellow-200 transition-colors">
                        <i class="fas fa-trophy ml-1"></i>
                        الأعلى تقييماً
                    </button>
                    <button onclick="filterByCategory('budget')" class="filter-card bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-green-200 transition-colors">
                        <i class="fas fa-dollar-sign ml-1"></i>
                        صديقة للميزانية
                    </button>
                    <button onclick="filterByCategory('luxury')" class="filter-card bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-purple-200 transition-colors">
                        <i class="fas fa-gem ml-1"></i>
                        فاخرة
                    </button>
                </div>
                
                <div class="flex items-center space-x-2 space-x-reverse mt-4 lg:mt-0">
                    <span class="text-gray-600 text-sm">ترتيب حسب:</span>
                    <select id="sortBy" onchange="sortTrips()" class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="latest">الأحدث</option>
                        <option value="rating">الأعلى تقييماً</option>
                        <option value="price-low">السعر: من الأقل للأعلى</option>
                        <option value="price-high">السعر: من الأعلى للأقل</option>
                        <option value="popular">الأكثر طلباً</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Trips Grid -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">جميع الرحلات المتاحة</h2>
                    <p class="text-gray-600">عثرنا على <span id="resultCount">{{ $trips->count() }}</span> رحلة متاحة</p>
                </div>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <button onclick="toggleView('grid')" id="gridBtn" class="view-btn bg-purple-600 text-white p-2 rounded-lg">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button onclick="toggleView('list')" id="listBtn" class="view-btn bg-gray-300 text-gray-600 p-2 rounded-lg">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            @if($trips->count() > 0)
                <div id="tripsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($trips as $trip)
                    <div class="trip-card bg-white rounded-2xl shadow-lg overflow-hidden card-hover relative" 
                         data-price="{{ $trip->price }}" 
                         data-rating="{{ $trip->average_rating }}" 
                         data-featured="{{ $trip->is_featured ? 'true' : 'false' }}"
                         data-destination="{{ strtolower($trip->destination) }}"
                         data-title="{{ strtolower($trip->title) }}">
                        
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
                            <div class="absolute top-4 right-4 flex flex-col space-y-2">
                                @if($trip->is_featured)
                                <div class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star ml-1"></i>
                                    مميزة
                                </div>
                                @endif
                                
                                @if($trip->average_rating >= 4.5)
                                <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-trophy ml-1"></i>
                                    الأفضل
                                </div>
                                @endif
                            </div>

                            <!-- Price Badge -->
                            <div class="absolute bottom-4 left-4 bg-white bg-opacity-95 px-4 py-2 rounded-full shadow-lg">
                                <div class="text-xl font-bold text-purple-600">{{ number_format($trip->price) }} ريال</div>
                                <div class="text-xs text-gray-600">للشخص الواحد</div>
                            </div>

                            <!-- Rating Badge -->
                            @if($trip->total_ratings > 0)
                            <div class="absolute top-4 left-4 bg-white bg-opacity-95 px-3 py-2 rounded-full shadow-lg">
                                <div class="flex items-center">
                                    <div class="rating-stars mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $trip->average_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">{{ number_format($trip->average_rating, 1) }}</span>
                                </div>
                                <div class="text-xs text-gray-500 text-center">{{ $trip->total_ratings }} تقييم</div>
                            </div>
                            @endif
                        </div>

                        <!-- Trip Content -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-800 flex-1">{{ $trip->title }}</h3>
                            </div>
                            
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                <span>{{ $trip->destination }}</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed text-sm">
                                {{ Str::limit($trip->description, 100) }}
                            </p>

                            <!-- Trip Details Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div class="flex items-center text-gray-500">
                                    <i class="fas fa-calendar-alt ml-2"></i>
                                    <span>{{ $trip->duration }} أيام</span>
                                </div>
                                <div class="flex items-center text-gray-500">
                                    <i class="fas fa-clock ml-2"></i>
                                    <span>{{ $trip->start_date->format('M Y') }}</span>
                                </div>
                            </div>

                            <!-- Reviews Preview -->
                            @if($trip->total_ratings > 0)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-gray-700">آراء المسافرين:</span>
                                    <span class="text-xs text-gray-500">{{ $trip->total_ratings }} مراجعة</span>
                                </div>
                                @php $latestReview = $trip->ratings()->with('user')->latest()->first(); @endphp
                                @if($latestReview && $latestReview->review)
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex items-center mb-1">
                                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-purple-600 text-xs"></i>
                                        </div>
                                        <span class="text-xs font-medium text-gray-700">{{ $latestReview->user->name }}</span>
                                        <div class="flex mr-2">
                                            @for($i = 1; $i <= $latestReview->rating; $i++)
                                                <i class="fas fa-star text-yellow-500 text-xs"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-600 italic">"{{ Str::limit($latestReview->review, 80) }}"</p>
                                </div>
                                @endif
                            </div>
                            @endif

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
                                
                                <div class="text-right text-sm text-gray-500">
                                    @if($trip->total_ratings > 0)
                                        <div class="flex items-center">
                                            <span class="font-semibold text-gray-700">{{ number_format($trip->average_rating, 1) }}</span>
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        </div>
                                        <div class="text-xs">{{ $trip->total_ratings }} تقييم</div>
                                    @else
                                        <div class="text-gray-400">لم يتم التقييم بعد</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Guest Overlay -->
                        @guest
                        <div class="absolute inset-0 bg-black bg-opacity-60 rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-6">
                                <i class="fas fa-lock text-4xl mb-4"></i>
                                <h3 class="text-xl font-bold mb-2">سجل دخولك</h3>
                                <p class="mb-4">لمشاهدة تفاصيل الرحلة والتقييمات</p>
                                <div class="space-y-2">
                                    <a href="{{ route('login') }}" class="block bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                        تسجيل الدخول
                                    </a>
                                    <a href="{{ route('register') }}" class="block border border-white text-white px-4 py-2 rounded-full hover:bg-white hover:text-purple-600 transition-colors">
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
                    <i class="fas fa-search text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">لا توجد نتائج</h3>
                    <p class="text-gray-500 mb-8">لم نجد رحلات تطابق معايير البحث الخاصة بك</p>
                    <button onclick="clearFilters()" class="bg-purple-600 text-white px-8 py-3 rounded-full hover:bg-purple-700 transition-colors font-medium">
                        <i class="fas fa-undo ml-2"></i>
                        مسح جميع الفلاتر
                    </button>
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
        // Search and Filter Functions
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const priceRange = document.getElementById('priceFilter').value;
            const minRating = document.getElementById('ratingFilter').value;
            
            const tripCards = document.querySelectorAll('.trip-card');
            let visibleCount = 0;

            tripCards.forEach(card => {
                let isVisible = true;

                // Search filter
                if (searchTerm) {
                    const title = card.dataset.title;
                    const destination = card.dataset.destination;
                    if (!title.includes(searchTerm) && !destination.includes(searchTerm)) {
                        isVisible = false;
                    }
                }

                // Price filter
                if (priceRange && isVisible) {
                    const price = parseFloat(card.dataset.price);
                    if (priceRange === '0-1000' && price >= 1000) isVisible = false;
                    if (priceRange === '1000-3000' && (price < 1000 || price >= 3000)) isVisible = false;
                    if (priceRange === '3000-5000' && (price < 3000 || price >= 5000)) isVisible = false;
                    if (priceRange === '5000+' && price < 5000) isVisible = false;
                }

                // Rating filter
                if (minRating && isVisible) {
                    const rating = parseFloat(card.dataset.rating);
                    if (rating < parseFloat(minRating)) isVisible = false;
                }

                card.style.display = isVisible ? 'block' : 'none';
                if (isVisible) visibleCount++;
            });

            document.getElementById('resultCount').textContent = visibleCount;
        }

        function filterByCategory(category) {
            const tripCards = document.querySelectorAll('.trip-card');
            const filterButtons = document.querySelectorAll('.filter-card');
            
            // Reset button states
            filterButtons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            let visibleCount = 0;

            tripCards.forEach(card => {
                let isVisible = false;
                const price = parseFloat(card.dataset.price);
                const rating = parseFloat(card.dataset.rating);
                const isFeatured = card.dataset.featured === 'true';

                switch(category) {
                    case 'featured':
                        isVisible = isFeatured;
                        break;
                    case 'topRated':
                        isVisible = rating >= 4.0;
                        break;
                    case 'budget':
                        isVisible = price <= 2000;
                        break;
                    case 'luxury':
                        isVisible = price >= 5000;
                        break;
                    default:
                        isVisible = true;
                }

                card.style.display = isVisible ? 'block' : 'none';
                if (isVisible) visibleCount++;
            });

            document.getElementById('resultCount').textContent = visibleCount;
        }

        function sortTrips() {
            const container = document.getElementById('tripsContainer');
            const cards = Array.from(container.querySelectorAll('.trip-card'));
            const sortBy = document.getElementById('sortBy').value;

            cards.sort((a, b) => {
                switch(sortBy) {
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    case 'price-low':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price-high':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    default:
                        return 0; // Keep original order for 'latest' and 'popular'
                }
            });

            cards.forEach(card => container.appendChild(card));
        }

        function toggleView(view) {
            const container = document.getElementById('tripsContainer');
            const gridBtn = document.getElementById('gridBtn');
            const listBtn = document.getElementById('listBtn');

            if (view === 'grid') {
                container.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';
                gridBtn.className = 'view-btn bg-purple-600 text-white p-2 rounded-lg';
                listBtn.className = 'view-btn bg-gray-300 text-gray-600 p-2 rounded-lg';
            } else {
                container.className = 'space-y-6';
                gridBtn.className = 'view-btn bg-gray-300 text-gray-600 p-2 rounded-lg';
                listBtn.className = 'view-btn bg-purple-600 text-white p-2 rounded-lg';
            }
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('priceFilter').value = '';
            document.getElementById('ratingFilter').value = '';
            
            document.querySelectorAll('.filter-card').forEach(btn => btn.classList.remove('active'));
            
            const tripCards = document.querySelectorAll('.trip-card');
            tripCards.forEach(card => card.style.display = 'block');
            
            document.getElementById('resultCount').textContent = tripCards.length;
        }

        function showLoginModal() {
            alert('يرجى تسجيل الدخول أولاً لمشاهدة تفاصيل الرحلة');
            window.location.href = '{{ route("login") }}';
        }

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                applyFilters();
            }, 300);
        });

        // Real-time filter changes
        document.getElementById('priceFilter').addEventListener('change', applyFilters);
        document.getElementById('ratingFilter').addEventListener('change', applyFilters);

        // Initialize tooltips and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all trip cards
            document.querySelectorAll('.trip-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }
        });
    </script>
</body>
</html><!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرحلات المتاحة - سواح</title