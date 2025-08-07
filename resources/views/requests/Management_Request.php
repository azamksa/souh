<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
        }
        .status-badge {
            transition: all 0.2s ease;
        }
        .modal {
            transition: opacity 0.3s ease;
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
                        <span>إدارة الطلبات</span>
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">إدارة طلبات الرحلات</h1>
                    <p class="text-gray-600">مراجعة وإدارة جميع طلبات المسافرين</p>
                </div>
                
                <!-- Filter Tabs -->
                <div class="flex space-x-2 space-x-reverse mt-4 lg:mt-0">
                    <button onclick="filterRequests('all')" class="filter-btn bg-purple-600 text-white px-4 py-2 rounded-full font-semibold active">
                        الكل ({{ $requests->count() }})
                    </button>
                    <button onclick="filterRequests('pending')" class="filter-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-semibold">
                        معلقة ({{ $requests->where('status', 'pending')->count() }})
                    </button>
                    <button onclick="filterRequests('approved')" class="filter-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                        موافقة ({{ $requests->where('status', 'approved')->count() }})
                    </button>
                    <button onclick="filterRequests('rejected')" class="filter-btn bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">
                        مرفوضة ({{ $requests->where('status', 'rejected')->count() }})
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-list text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $requests->count() }}</div>
                            <div class="text-sm opacity-90">إجمالي الطلبات</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $requests->where('status', 'pending')->count() }}</div>
                            <div class="text-sm opacity-90">في انتظار المراجعة</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $requests->where('status', 'approved')->count() }}</div>
                            <div class="text-sm opacity-90">تم الموافقة عليها</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-times text-2xl opacity-80 ml-3"></i>
                        <div>
                            <div class="text-2xl font-bold">{{ $requests->where('status', 'rejected')->count() }}</div>
                            <div class="text-sm opacity-90">تم رفضها</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requests List -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="space-y-4">
                @foreach($requests as $request)
                <div class="request-card bg-white rounded-xl shadow-lg p-6 card-hover" data-status="{{ $request->status }}">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <!-- Request Info -->
                        <div class="lg:col-span-2">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $request->trip->title }}</h3>
                                    <div class="flex items-center text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt ml-2"></i>
                                        <span>{{ $request->trip->destination }}</span>
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-money-bill-wave ml-1"></i>
                                        <span>{{ number_format($request->trip->price) }} ريال</span>
                                    </div>
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <i class="fas fa-calendar-alt ml-2"></i>
                                        <span>من {{ $request->trip->start_date->format('d/m/Y') }} إلى {{ $request->trip->end_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                
                                <span class="status-badge px-3 py-1 rounded-full text-sm font-bold {{ $request->status_color == 'yellow' ? 'bg-yellow-100 text-yellow-800' : ($request->status_color == 'green' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    <i class="{{ $request->status_icon }} ml-1"></i>
                                    {{ $request->status_in_arabic }}
                                </span>
                            </div>

                            <!-- User Info -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">معلومات الطالب</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-purple-600 ml-2"></i>
                                        <span>{{ $request->user->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-purple-600 ml-2"></i>
                                        <span>{{ $request->user->email }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-purple-600 ml-2"></i>
                                        <span>{{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-purple-600 ml-2"></i>
                                        <span>{{ $request->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($request->notes)
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">ملاحظات الطالب</h4>
                                <p class="text-blue-700">{{ $request->notes }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Action Panel -->
                        <div class="lg:col-span-2">
                            @if($request->status === 'pending')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-yellow-800 mb-3">إجراءات الطلب</h4>
                                <div class="space-y-3">
                                    <button onclick="openActionModal('{{ $request->id }}', 'approve')" 
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-check ml-2"></i>
                                        الموافقة على الطلب
                                    </button>
                                    <button onclick="openActionModal('{{ $request->id }}', 'reject')" 
                                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-times ml-2"></i>
                                        رفض الطلب
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-gray-700 mb-2">حالة الطلب</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-gray-500 ml-2"></i>
                                        <span class="text-gray-600">تم {{ $request->status == 'approved' ? 'الموافقة على' : 'رفض' }} هذا الطلب</span>
                                    </div>
                                    @if($request->processed_at)
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-gray-500 ml-2"></i>
                                        <span class="text-gray-600">{{ $request->processed_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                                <button onclick="openActionModal('{{ $request->id }}', 'update')" 
                                        class="mt-3 w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    <i class="fas fa-edit ml-2"></i>
                                    تعديل الحالة
                                </button>
                            </div>
                            @endif

                            @if($request->admin_notes)
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <h4 class="font-semibold text-purple-800 mb-2">ملاحظات الإدارة</h4>
                                <p class="text-purple-700">{{ $request->admin_notes }}</p>
                            </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="mt-4 flex space-x-2 space-x-reverse">
                                <a href="mailto:{{ $request->user->email }}" 
                                   class="flex-1 bg-blue-100 text-blue-700 py-2 px-3 rounded-lg hover:bg-blue-200 transition-colors text-center">
                                    <i class="fas fa-envelope text-sm"></i>
                                    <span class="hidden sm:inline mr-1">راسل العميل</span>
                                </a>
                                <a href="{{ route('trips.show', $request->trip) }}" target="_blank"
                                   class="flex-1 bg-gray-100 text-gray-700 py-2 px-3 rounded-lg hover:bg-gray-200 transition-colors text-center">
                                    <i class="fas fa-eye text-sm"></i>
                                    <span class="hidden sm:inline mr-1">عرض الرحلة</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($requests->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">لا توجد طلبات</h3>
                    <p class="text-gray-500">لم يتم استلام أي طلبات حتى الآن</p>
                </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- Action Modal -->
    <div id="actionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden modal">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modalTitle" class="text-lg font-bold text-gray-800"></h3>
                    <button onclick="closeActionModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form id="actionForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <input type="hidden" name="status" id="actionStatus">
                    
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-gray-700 font-semibold mb-2">ملاحظات الإدارة</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4" 
                                  class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
                                  placeholder="اكتب أي ملاحظات أو تعليقات..."></textarea>
                    </div>

                    <div class="flex space-x-3 space-x-reverse">
                        <button type="submit" id="confirmButton" 
                                class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                            تأكيد
                        </button>
                        <button type="button" onclick="closeActionModal()" 
                                class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        function filterRequests(status) {
            const cards = document.querySelectorAll('.request-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('bg-purple-600', 'text-white', 'active');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
            event.target.classList.add('bg-purple-600', 'text-white', 'active');
            
            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Modal functionality
        function openActionModal(requestId, action) {
            const modal = document.getElementById('actionModal');
            const form = document.getElementById('actionForm');
            const title = document.getElementById('modalTitle');
            const statusInput = document.getElementById('actionStatus');
            const confirmButton = document.getElementById('confirmButton');
            
            form.action = `/admin/requests/${requestId}/status`;
            
            if (action === 'approve') {
                title.textContent = 'الموافقة على الطلب';
                statusInput.value = 'approved';
                confirmButton.textContent = 'موافقة';
                confirmButton.className = 'flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-semibold';
            } else if (action === 'reject') {
                title.textContent = 'رفض الطلب';
                statusInput.value = 'rejected';
                confirmButton.textContent = 'رفض';
                confirmButton.className = 'flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold';
            } else {
                title.textContent = 'تعديل حالة الطلب';
                statusInput.value = 'pending';
                confirmButton.textContent = 'تعديل';
                confirmButton.className = 'flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors font-semibold';
            }
            
            modal.classList.remove('hidden');
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
        }

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
        document.getElementById('actionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeActionModal();
            }
        });
    </script>
</body>
</html>