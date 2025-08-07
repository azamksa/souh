<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .sidebar {
            transition: transform 0.3s ease;
        }
        .sidebar.hidden {
            transform: translateX(100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-purple-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="text-2xl font-bold text-purple-600">
                        <i class="fas fa-plane ml-2"></i>
                        <span>سواح - لوحة التحكم</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600" target="_blank">
                        <i class="fas fa-external-link-alt ml-1"></i>
                        زيارة الموقع
                    </a>
                    <div class="relative">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="text-gray-700">مرحباً، {{ auth()->user()->name }}</span>
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
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar fixed lg:relative top-0 right-0 h-full w-80 bg-white shadow-lg z-40 lg:z-auto">
            <div class="p-6">
                <div class="gradient-bg text-white p-4 rounded-lg mb-6 text-center">
                    <i class="fas fa-user-shield text-3xl mb-2"></i>
                    <h3 class="text-lg font-bold">لوحة التحكم الإدارية</h3>
                    <p class="text-sm opacity-90">إدارة شاملة للموقع</p>
                </div>

                <nav class="space-y-2">
                    <a href="#dashboard" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors active">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span class="mr-3">الرئيسية</span>
                    </a>
                    <a href="#trips" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-plane w-5"></i>
                        <span class="mr-3">إدارة الرحلات</span>
                    </a>
                    <a href="#requests" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span class="mr-3">طلبات الرحلات</span>
                        <span class="mr-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $stats['pending_requests'] }}</span>
                    </a>
                    <a href="#ratings" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-star w-5"></i>
                        <span class="mr-3">التقييمات</span>
                    </a>
                    <a href="#users" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-users w-5"></i>
                        <span class="mr-3">المستخدمين</span>
                    </a>
                    <a href="#reports" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span class="mr-3">التقارير</span>
                    </a>
                    <a href="#settings" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                        <i class="fas fa-cog w-5"></i>
                        <span class="mr-3">الإعدادات</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:mr-80">
            <div class="p-6">
                <!-- Stats Cards -->
                <div id="dashboard" class="content-section">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">إجمالي الرحلات</p>
                                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_trips'] }}</p>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i class="fas fa-plane text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">طلبات الرحلات</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_requests'] }}</p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">المستخدمين</p>
                                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_users'] }}</p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-users text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">التقييمات</p>
                                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_ratings'] }}</p>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">إحصائيات الطلبات</h3>
                            <canvas id="requestsChart"></canvas>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">متوسط التقييمات</h3>
                            <canvas id="ratingsChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">أحدث الطلبات</h3>
                                <a href="#requests" class="text-purple-600 text-sm hover:underline">عرض الكل</a>
                            </div>
                            <div class="space-y-3">
                                @foreach($stats['recent_requests'] as $request)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center ml-3">
                                            <i class="fas fa-user text-purple-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $request->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $request->trip->title }}</p>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status == 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $request->status == 'pending' ? 'معلق' : ($request->status == 'approved' ? 'موافق' : 'مرفوض') }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $request->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">أحدث التقييمات</h3>
                                <a href="#ratings" class="text-purple-600 text-sm hover:underline">عرض الكل</a>
                            </div>
                            <div class="space-y-3">
                                @foreach($stats['recent_ratings'] as $rating)
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center ml-2">
                                                <i class="fas fa-user text-yellow-600 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-800">{{ $rating->user->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">{{ $rating->trip->title }}</p>
                                    @if($rating->review)
                                        <p class="text-sm text-gray-700 italic">"{{ Str::limit($rating->review, 50) }}"</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other sections (hidden by default) -->
                <div id="trips" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">إدارة الرحلات</h2>
                    <!-- محتوى إدارة الرحلات -->
                </div>

                <div id="requests" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">طلبات الرحلات</h2>
                    <!-- محتوى طلبات الرحلات -->
                </div>

                <div id="ratings" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">التقييمات والمراجعات</h2>
                    <!-- محتوى التقييمات -->
                </div>

                <div id="users" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">إدارة المستخدمين</h2>
                    <!-- محتوى إدارة المستخدمين -->
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('hidden');
            sidebarOverlay.classList.add('hidden');
        });

        // Navigation
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href').substring(1);
                
                // Hide all sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.add('hidden');
                });
                
                // Show target section
                document.getElementById(targetId).classList.remove('hidden');
                
                // Update active nav
                document.querySelectorAll('nav a').forEach(navLink => {
                    navLink.classList.remove('active', 'bg-purple-50', 'text-purple-600');
                });
                link.classList.add('active', 'bg-purple-50', 'text-purple-600');
            });
        });

        // Charts
        // Requests Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'doughnut',
            data: {
                labels: ['معلقة', 'موافقة', 'مرفوضة'],
                datasets: [{
                    data: [{{ $stats['pending_requests'] }}, 25, 10], // Example data
                    backgroundColor: ['#FEF3C7', '#D1FAE5', '#FEE2E2'],
                    borderColor: ['#F59E0B', '#10B981', '#EF4444'],
                    borderWidth: 2
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

        // Ratings Chart
        const ratingsCtx = document.getElementById('ratingsChart').getContext('2d');
        new Chart(ratingsCtx, {
            type: 'bar',
            data: {
                labels: ['1 نجمة', '2 نجمة', '3 نجمة', '4 نجمة', '5 نجمة'],
                datasets: [{
                    label: 'عدد التقييمات',
                    data: [2, 5, 15, 35, 43], // Example data
                    backgroundColor: '#8B5CF6',
                    borderColor: '#7C3AED',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>