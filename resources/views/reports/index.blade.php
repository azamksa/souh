<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير والإحصائيات - سواح</title>
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
        .gradient-bg-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-bg-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .gradient-bg-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .gradient-bg-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .activity-item {
            transition: all 0.2s ease;
        }
        .activity-item:hover {
            transform: translateX(-5px);
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
                        <span>التقارير والإحصائيات</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <button onclick="exportData('all')" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-download ml-2"></i>
                        تصدير البيانات
                    </button>
                    <button onclick="refreshData()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-sync-alt ml-2"></i>
                        تحديث
                    </button>
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

    <!-- Page Header -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">التقارير والإحصائيات الشاملة</h1>
                    <p class="text-gray-600">نظرة شاملة على أداء الموقع والمؤشرات المهمة</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="text-sm text-gray-500">آخر تحديث: {{ now()->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Stats Cards -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- الرحلات -->
                <div class="gradient-bg-1 text-white rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold mb-2">{{ $stats['total_trips'] }}</div>
                            <div class="text-sm opacity-90">إجمالي الرحلات</div>
                            <div class="mt-2 text-xs">
                                <span class="bg-white bg-opacity-20 px-2 py-1 rounded">{{ $stats['active_trips'] }} نشطة</span>
                            </div>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-plane"></i>
                        </div>
                    </div>
                </div>

                <!-- المستخدمين -->
                <div class="gradient-bg-2 text-white rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold mb-2">{{ $stats['total_users'] }}</div>
                            <div class="text-sm opacity-90">إجمالي المستخدمين</div>
                            <div class="mt-2 text-xs">
                                <span class="bg-white bg-opacity-20 px-2 py-1 rounded">{{ $stats['active_users'] ?? 0 }} نشط</span>
                            </div>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- الطلبات -->
                <div class="gradient-bg-3 text-white rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold mb-2">{{ $stats['total_requests'] }}</div>
                            <div class="text-sm opacity-90">إجمالي الطلبات</div>
                            <div class="mt-2 text-xs">
                                <span class="bg-white bg-opacity-20 px-2 py-1 rounded">{{ $stats['pending_requests'] }} معلق</span>
                            </div>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>

                <!-- التقييمات -->
                <div class="gradient-bg-4 text-white rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-bold mb-2">{{ $stats['total_ratings'] }}</div>
                            <div class="text-sm opacity-90">إجمالي التقييمات</div>
                            <div class="mt-2 text-xs">
                                <span class="bg-white bg-opacity-20 px-2 py-1 rounded">{{ number_format($stats['average_rating'], 1) }} متوسط</span>
                            </div>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['featured_trips'] }}</div>
                    <div class="text-sm text-gray-600">رحلات مميزة</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['approved_requests'] }}</div>
                    <div class="text-sm text-gray-600">طلبات موافقة</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['five_star_ratings'] }}</div>
                    <div class="text-sm text-gray-600">تقييم 5 نجوم</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['ratings_with_reviews'] }}</div>
                    <div class="text-sm text-gray-600">تقييم مع مراجعة</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Monthly Statistics Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">الإحصائيات الشهرية</h3>
                    <canvas id="monthlyChart" height="300"></canvas>
                </div>

                <!-- Rating Distribution Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">توزيع التقييمات</h3>
                    <canvas id="ratingChart" height="300"></canvas>
                </div>
            </div>

            <!-- Request Status Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">حالة الطلبات</h3>
                    <canvas id="requestsChart" height="300"></canvas>
                </div>

                <!-- Destination Statistics -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">إحصائيات الوجهات</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($destinationStats as $dest)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-600 ml-3"></i>
                                <div>
                                    <div class="font-semibold">{{ $dest->destination }}</div>
                                    <div class="text-sm text-gray-500">{{ $dest->trips_count }} رحلة</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center">
                                    @if($dest->avg_rating > 0)
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $dest->avg_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                        <span class="mr-1 text-sm">{{ number_format($dest->avg_rating, 1) }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">لا توجد تقييمات</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">{{ $dest->total_ratings }} تقييم</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Rated Trips -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">أفضل الرحلات تقييماً</h3>
                    <div class="space-y-3">
                        @foreach($topRatedTrips->take(8) as $trip)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center ml-3">
                                    <i class="fas fa-plane text-purple-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ Str::limit($trip->title, 30) }}</div>
                                    <div class="text-sm text-gray-500">{{ $trip->destination }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $trip->ratings_avg_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                    <span class="mr-1 text-sm font-bold">{{ number_format($trip->ratings_avg_rating, 1) }}</span>
                                </div>
                                <div class="text-xs text-gray-500">{{ $trip->ratings_count }} تقييم</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Most Requested Trips -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">أكثر الرحلات طلباً</h3>
                    <div class="space-y-3">
                        @foreach($mostRequestedTrips->take(8) as $trip)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                                    <i class="fas fa-fire text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ Str::limit($trip->title, 30) }}</div>
                                    <div class="text-sm text-gray-500">{{ $trip->destination }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-blue-600">{{ $trip->requests_count }}</div>
                                <div class="text-xs text-gray-500">طلب</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">الأنشطة الأخيرة</h3>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($recentActivities as $activity)
                        <div class="activity-item flex items-center p-3 border-r-4 border-{{ $activity['color'] }}-500 bg-{{ $activity['color'] }}-50 rounded-lg">
                            <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center ml-3">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">{{ $activity['title'] }}</div>
                                <div class="text-sm text-gray-600">{{ $activity['description'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $activity['time']->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Ratings with Details -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">أحدث التقييمات</h3>
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($recentRatings as $rating)
                        <div class="border border-gray-100 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center ml-2">
                                        <i class="fas fa-user text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">{{ $rating->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="text-sm text-gray-700 mb-2">{{ Str::limit($rating->trip->title, 40) }}</div>
                            @if($rating->review)
                                <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded italic">
                                    "{{ Str::limit($rating->review, 60) }}"
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Monthly Statistics Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyStats->pluck('month_ar')) !!},
                datasets: [{
                    label: 'الرحلات',
                    data: {!! json_encode($monthlyStats->pluck('trips')) !!},
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4
                }, {
                    label: 'الطلبات',
                    data: {!! json_encode($monthlyStats->pluck('requests')) !!},
                    borderColor: '#06B6D4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    tension: 0.4
                }, {
                    label: 'التقييمات',
                    data: {!! json_encode($monthlyStats->pluck('ratings')) !!},
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Rating Distribution Chart
        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        new Chart(ratingCtx, {
            type: 'doughnut',
            data: {
                labels: ['5 نجوم', '4 نجوم', '3 نجوم', '2 نجمة', '1 نجمة'],
                datasets: [{
                    data: [
                        {{ $ratingDistribution[5] ?? 0 }},
                        {{ $ratingDistribution[4] ?? 0 }},
                        {{ $ratingDistribution[3] ?? 0 }},
                        {{ $ratingDistribution[2] ?? 0 }},
                        {{ $ratingDistribution[1] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#10B981',
                        '#22C55E', 
                        '#FCD34D',
                        '#F97316',
                        '#EF4444'
                    ],
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

        // Requests Status Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'pie',
            data: {
                labels: ['معلقة', 'موافقة', 'مرفوضة'],
                datasets: [{
                    data: [
                        {{ $stats['pending_requests'] }},
                        {{ $stats['approved_requests'] }},
                        {{ $stats['rejected_requests'] }}
                    ],
                    backgroundColor: ['#FCD34D', '#10B981', '#EF4444'],
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

        // Export Data Function
        function exportData(type) {
            fetch(`{{ route('admin.reports.export') }}?type=${type}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                } else {
                    alert('حدث خطأ أثناء التصدير');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء التصدير');
            });
        }

        // Refresh Data Function
        function refreshData() {
            location.reload();
        }

        // Auto refresh every 5 minutes
        setInterval(function() {
            const refreshBtn = document.querySelector('button[onclick="refreshData()"]');
            if (refreshBtn) {
                refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i>جاري التحديث...';
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }, 300000); // 5 minutes
    </script>
</body>
</html>