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
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
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
                    <!-- Export Buttons -->
                    <button onclick="exportReport('pdf')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-file-pdf ml-2"></i>
                        تصدير PDF
                    </button>
                    <button onclick="exportReport('excel')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-file-excel ml-2"></i>
                        تصدير Excel
                    </button>
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

    <!-- Header Section -->
    <section class="gradient-bg py-12 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center animate-slide-in">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <i class="fas fa-chart-line mb-4"></i>
                    <br>التقارير والإحصائيات الشاملة
                </h1>
                <p class="text-xl mb-8">نظرة شاملة على أداء المنصة وإحصائيات مفصلة</p>
                
                <!-- Date Range Filter -->
                <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 max-w-md mx-auto">
                    <h3 class="text-lg font-semibold mb-4">تصفية بالفترة الزمنية</h3>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <input type="date" id="startDate" class="bg-white bg-opacity-90 text-gray-800 p-2 rounded-lg text-sm">
                            <input type="date" id="endDate" class="bg-white bg-opacity-90 text-gray-800 p-2 rounded-lg text-sm">
                        </div>
                        <button onclick="filterByDateRange()" class="w-full bg-yellow-500 text-purple-900 py-2 px-4 rounded-lg hover:bg-yellow-400 transition-colors font-semibold">
                            <i class="fas fa-filter ml-2"></i>
                            تطبيق التصفية
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Stats -->
    <section class="py-8 -mt-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Key Performance Indicators -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">إجمالي الإيرادات المتوقعة</p>
                            <p class="text-3xl font-bold text-green-600" id="totalRevenue">2,450,000 ريال</p>
                            <p class="text-sm text-green-500 flex items-center mt-1">
                                <i class="fas fa-arrow-up ml-1"></i>
                                +15.3% من الشهر السابق
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">متوسط التقييم العام</p>
                            <p class="text-3xl font-bold text-yellow-600" id="avgRating">4.7</p>
                            <div class="flex items-center mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-yellow-500 text-sm"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-star text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">معدل الموافقة على الطلبات</p>
                            <p class="text-3xl font-bold text-blue-600" id="approvalRate">78.5%</p>
                            <p class="text-sm text-blue-500 flex items-center mt-1">
                                <i class="fas fa-arrow-up ml-1"></i>
                                +5.2% من الأسبوع الماضي
                            </p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">معدل رضا العملاء</p>
                            <p class="text-3xl font-bold text-purple-600" id="satisfactionRate">92.1%</p>
                            <p class="text-sm text-purple-500 flex items-center mt-1">
                                <i class="fas fa-heart ml-1"></i>
                                عملاء راضون
                            </p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-thumbs-up text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue Trends -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">اتجاهات الإيرادات</h3>
                        <div class="flex space-x-2 space-x-reverse">
                            <button onclick="updateChart('revenue', 'month')" class="chart-filter bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">شهري</button>
                            <button onclick="updateChart('revenue', 'quarter')" class="chart-filter bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">ربعي</button>
                        </div>
                    </div>
                    <canvas id="revenueChart" height="300"></canvas>
                </div>

                <!-- Bookings vs Ratings -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">الحجوزات مقابل التقييمات</h3>
                    <canvas id="bookingsRatingsChart" height="300"></canvas>
                </div>
            </div>

            <!-- Detailed Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Top Performing Trips -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">الرحلات الأكثر طلباً</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center mr-3">1</div>
                                <div>
                                    <div class="font-semibold text-gray-800">جزر المالديف</div>
                                    <div class="text-sm text-gray-600">125 طلب</div>
                                </div>
                            </div>
                            <div class="text-green-600 font-bold">4.9★</div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center mr-3">2</div>
                                <div>
                                    <div class="font-semibold text-gray-800">جبال الألب</div>
                                    <div class="text-sm text-gray-600">98 طلب</div>
                                </div>
                            </div>
                            <div class="text-yellow-600 font-bold">4.6★</div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center mr-3">3</div>
                                <div>
                                    <div class="font-semibold text-gray-800">جزر بالي</div>
                                    <div class="text-sm text-gray-600">87 طلب</div>
                                </div>
                            </div>
                            <div class="text-yellow-600 font-bold">4.8★</div>
                        </div>
                    </div>
                    
                    <button onclick="viewFullReport('trips')" class="mt-4 w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                        عرض التقرير الكامل
                    </button>
                </div>

                <!-- Customer Insights -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">رؤى العملاء</h3>
                    
                    <!-- Customer Demographics -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">التركيبة السكانية</h4>
                        <canvas id="demographicsChart" height="200"></canvas>
                    </div>
                    
                    <!-- Active Users -->
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700">المستخدمون النشطون</span>
                            <span class="font-bold text-purple-600">2,847</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700">عملاء جدد هذا الشهر</span>
                            <span class="font-bold text-green-600">+156</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">معدل الاحتفاظ</span>
                            <span class="font-bold text-blue-600">89.3%</span>
                        </div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">الملخص المالي</h3>
                    
                    <div class="space-y-4">
                        <div class="border-b border-gray-100 pb-4">
                            <h4 class="font-semibold text-gray-700 mb-3">إيرادات هذا الشهر</h4>
                            <div class="text-2xl font-bold text-green-600 mb-2">425,000 ريال</div>
                            <div class="flex items-center text-sm text-green-500">
                                <i class="fas fa-arrow-up ml-1"></i>
                                <span>زيادة 23% عن الشهر الماضي</span>
                            </div>
                        </div>
                        
                        <div class="border-b border-gray-100 pb-4">
                            <h4 class="font-semibold text-gray-700 mb-3">متوسط قيمة الحجز</h4>
                            <div class="text-2xl font-bold text-blue-600 mb-2">2,450 ريال</div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-chart-line ml-1"></i>
                                <span>نمو مستقر</span>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-gray-700 text-sm">الهدف الشهري</span>
                                <span class="font-semibold text-yellow-600">500,000 ريال</span>
                            </div>
                            <div class="w-full bg-yellow-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            <div class="text-xs text-gray-600 mt-1">85% من الهدف المحقق</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">مؤشرات الأداء الرئيسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">98.7%</div>
                        <div class="text-gray-600 text-sm">وقت تشغيل الموقع</div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-purple-600 h-1 rounded-full" style="width: 98.7%"></div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">1.2s</div>
                        <div class="text-gray-600 text-sm">متوسط وقت التحميل</div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-green-600 h-1 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">4.2min</div>
                        <div class="text-gray-600 text-sm">متوسط وقت التصفح</div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-blue-600 h-1 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">12.3%</div>
                        <div class="text-gray-600 text-sm">معدل التحويل</div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-yellow-600 h-1 rounded-full" style="width: 82%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Timeline -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <h3 class="text-lg font-bold text-gray-800 mb-6">الأنشطة الأخيرة</h3>
                
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute right-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="relative z-10 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center ml-4">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">تم الموافقة على 5 طلبات جديدة</div>
                                <div class="text-gray-600 text-sm">منذ ساعتين</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="relative z-10 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center ml-4">
                                <i class="fas fa-star text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">استلام 12 تقييم جديد</div>
                                <div class="text-gray-600 text-sm">منذ 4 ساعات</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="relative z-10 w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center ml-4">
                                <i class="fas fa-plus text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">إضافة رحلة جديدة: "سفاري كينيا"</div>
                                <div class="text-gray-600 text-sm">أمس</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="relative z-10 w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center ml-4">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">انضمام 23 عضو جديد</div>
                                <div class="text-gray-600 text-sm">منذ يومين</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                    datasets: [{
                        label: 'الإيرادات (بالآلاف)',
                        data: [320, 285, 390, 410, 425, 445],
                        borderColor: '#8B5CF6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                color: '#f3f4f6'
                            }
                        }
                    }
                }
            });

            // Bookings vs Ratings Chart
            const bookingsCtx = document.getElementById('bookingsRatingsChart').getContext('2d');
            new Chart(bookingsCtx, {
                type: 'bar',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                    datasets: [{
                        label: 'الطلبات',
                        data: [45, 52, 38, 67, 73, 82],
                        backgroundColor: '#3B82F6'
                    }, {
                        label: 'التقييمات',
                        data: [38, 45, 32, 58, 65, 75],
                        backgroundColor: '#F59E0B'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Demographics Chart
            const demographicsCtx = document.getElementById('demographicsChart').getContext('2d');
            new Chart(demographicsCtx, {
                type: 'pie',
                data: {
                    labels: ['18-25', '26-35', '36-45', '46+'],
                    datasets: [{
                        data: [25, 45, 20, 10],
                        backgroundColor: ['#EF4444', '#F59E0B', '#10B981', '#3B82F6']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Filter functions
        function filterByDateRange() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (startDate && endDate) {
                // Here you would typically make an AJAX call to filter data
                alert(`تصفية البيانات من ${startDate} إلى ${endDate}`);
                // Refresh charts with filtered data
            } else {
                alert('يرجى اختيار تاريخ البداية والنهاية');
            }
        }

        function updateChart(chartType, period) {
            // Update chart filter buttons
            event.target.parentElement.querySelectorAll('.chart-filter').forEach(btn => {
                btn.classList.remove('bg-purple-100', 'text-purple-700');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });
            event.target.classList.add('bg-purple-100', 'text-purple-700');
            event.target.classList.remove('bg-gray-100', 'text-gray-600');
            
            // Here you would update the chart data based on the selected period
            console.log(`Updating ${chartType} chart for ${period} period`);
        }

        function exportReport(format) {
            // Export functionality
            if (format === 'pdf') {
                alert('جاري تصدير التقرير كـ PDF...');
                // Implement PDF export
            } else if (format === 'excel') {
                alert('جاري تصدير التقرير كـ Excel...');
                // Implement Excel export
            }
        }

        function viewFullReport(type) {
            alert(`عرض التقرير الكامل لـ ${type}`);
            // Navigate to detailed report page
        }

        // Set default dates (last 30 days)
        const today = new Date();
        const lastMonth = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
        
        document.getElementById('endDate').value = today.toISOString().split('T')[0];
        document.getElementById('startDate').value = lastMonth.toISOString().split('T')[0];

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-in');
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.card-hover').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>