<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات الموقع - سواح</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .settings-card {
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #8B5CF6;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
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
                        <span>إعدادات الموقع</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <button onclick="saveAllSettings()" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ جميع الإعدادات
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">إعدادات الموقع</h1>
                    <p class="text-gray-600">إدارة جميع إعدادات وخصائص موقع سواح</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-info-circle ml-2"></i>
                        تأكد من حفظ التغييرات
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Settings Content -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- General Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-cog text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">الإعدادات العامة</h3>
                            <p class="text-gray-600 text-sm">إعدادات أساسية للموقع</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">اسم الموقع</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="سواح - دليل الرحلات السياحية" placeholder="اسم الموقع">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">وصف الموقع</label>
                            <textarea class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                      rows="3" placeholder="وصف مختصر عن الموقع">أفضل موقع لاستكشاف وتقييم الرحلات السياحية حول العالم</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">البريد الإلكتروني للتواصل</label>
                            <input type="email" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="info@souh.sa" placeholder="البريد الإلكتروني">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">رقم الهاتف</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="+966 11 123 4567" placeholder="رقم الهاتف">
                        </div>
                    </div>
                </div>

                <!-- Rating Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-star text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">إعدادات التقييم</h3>
                            <p class="text-gray-600 text-sm">ضوابط نظام التقييمات</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">السماح بالتقييمات المتعددة</label>
                                <p class="text-gray-500 text-sm">هل يمكن للمستخدم تقييم الرحلة أكثر من مرة؟</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">مراجعة التقييمات قبل النشر</label>
                                <p class="text-gray-500 text-sm">هل تحتاج التقييمات لموافقة المدير؟</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">الحد الأدنى لطول المراجعة</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="10" min="0" max="500">
                            <p class="text-gray-500 text-xs mt-1">عدد الأحرف المطلوبة كحد أدنى للمراجعة</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">الحد الأقصى لطول المراجعة</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="1000" min="100" max="5000">
                            <p class="text-gray-500 text-xs mt-1">عدد الأحرف المسموح بها كحد أقصى للمراجعة</p>
                        </div>
                    </div>
                </div>

                <!-- Trip Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-plane text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">إعدادات الرحلات</h3>
                            <p class="text-gray-600 text-sm">خيارات إدارة الرحلات</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">تفعيل الرحلات المميزة</label>
                                <p class="text-gray-500 text-sm">إظهار الرحلات المميزة في الصفحة الرئيسية</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">السماح بطلب الرحلات المنتهية</label>
                                <p class="text-gray-500 text-sm">هل يمكن طلب رحلة انتهت مدتها؟</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">عدد الرحلات في الصفحة الواحدة</label>
                            <select class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <option value="12" selected>12 رحلة</option>
                                <option value="20">20 رحلة</option>
                                <option value="30">30 رحلة</option>
                                <option value="50">50 رحلة</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ترتيب الرحلات الافتراضي</label>
                            <select class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <option value="newest">الأحدث أولاً</option>
                                <option value="rating" selected>الأعلى تقييماً</option>
                                <option value="price_low">الأرخص أولاً</option>
                                <option value="price_high">الأغلى أولاً</option>
                                <option value="featured">المميزة أولاً</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- User Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">إعدادات المستخدمين</h3>
                            <p class="text-gray-600 text-sm">خيارات حسابات المستخدمين</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">تفعيل التسجيل الجديد</label>
                                <p class="text-gray-500 text-sm">السماح بإنشاء حسابات جديدة</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">تأكيد البريد الإلكتروني</label>
                                <p class="text-gray-500 text-sm">إجبار المستخدمين على تأكيد بريدهم</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">الحد الأقصى لطلبات الرحلات للمستخدم الواحد</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="10" min="1" max="100">
                            <p class="text-gray-500 text-xs mt-1">عدد الطلبات المسموح بها شهرياً للمستخدم الواحد</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">فترة انتظار بين الطلبات (بالساعات)</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="24" min="0" max="168">
                            <p class="text-gray-500 text-xs mt-1">المدة المطلوب انتظارها بين طلب وآخر</p>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-bell text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">إعدادات الإشعارات</h3>
                            <p class="text-gray-600 text-sm">خيارات التنبيهات والإشعارات</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">إشعار طلب جديد</label>
                                <p class="text-gray-500 text-sm">إرسال إشعار عند استلام طلب رحلة جديد</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">إشعار تقييم جديد</label>
                                <p class="text-gray-500 text-sm">إرسال إشعار عند استلام تقييم جديد</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">إشعار تسجيل مستخدم جديد</label>
                                <p class="text-gray-500 text-sm">إرسال إشعار عند تسجيل عضو جديد</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">البريد الإلكتروني لاستقبال الإشعارات</label>
                            <input type="email" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="admin@souh.sa" placeholder="البريد الإلكتروني">
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="settings-card bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center ml-4">
                            <i class="fas fa-shield-alt text-gray-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">إعدادات الأمان</h3>
                            <p class="text-gray-600 text-sm">خيارات الحماية والأمان</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">تفعيل الحماية من البريد المزعج</label>
                                <p class="text-gray-500 text-sm">منع الرسائل المتكررة والمشبوهة</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-gray-700 font-semibold">تسجيل الأنشطة</label>
                                <p class="text-gray-500 text-sm">حفظ سجل بجميع العمليات المهمة</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">مدة الجلسة (بالدقائق)</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                   value="120" min="30" max="1440">
                            <p class="text-gray-500 text-xs mt-1">المدة المسموحة للبقاء متصلاً بدون نشاط</p>
                        </div>
                        
                        <div>
                            <button class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                <i class="fas fa-trash ml-2"></i>
                                مسح بيانات الجلسات المنتهية
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-center space-x-4 space-x-reverse">
                <button onclick="saveAllSettings()" class="bg-green-600 text-white px-8 py-3 rounded-full hover:bg-green-700 transition-colors font-semibold">
                    <i class="fas fa-save ml-2"></i>
                    حفظ جميع الإعدادات
                </button>
                <button onclick="resetToDefaults()" class="bg-gray-600 text-white px-8 py-3 rounded-full hover:bg-gray-700 transition-colors font-semibold">
                    <i class="fas fa-undo ml-2"></i>
                    إعادة تعيين للافتراضي
                </button>
                <button onclick="exportSettings()" class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition-colors font-semibold">
                    <i class="fas fa-download ml-2"></i>
                    تصدير الإعدادات
                </button>
            </div>
        </div>
    </section>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">تم الحفظ بنجاح!</h3>
                <p class="text-gray-600 mb-6">تم حفظ جميع الإعدادات بنجاح</p>
                <button onclick="closeSuccessModal()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    موافق
                </button>
            </div>
        </div>
    </div>

    <script>
        function saveAllSettings() {
            // Show loading
            const saveBtn = document.querySelector('button[onclick="saveAllSettings()"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i>جاري الحفظ...';
            saveBtn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
                showSuccessModal();
            }, 2000);
        }

        function resetToDefaults() {
            if (confirm('هل أنت متأكد من إعادة تعيين جميع الإعدادات إلى القيم الافتراضية؟')) {
                // Reset all form fields to default values
                location.reload();
            }
        }

        function exportSettings() {
            // Create a simple export functionality
            const settings = {
                siteName: 'سواح - دليل الرحلات السياحية',
                siteDescription: 'أفضل موقع لاستكشاف وتقييم الرحلات السياحية حول العالم',
                contactEmail: 'info@souh.sa',
                contactPhone: '+966 11 123 4567',
                exportDate: new Date().toISOString()
            };

            const dataStr = JSON.stringify(settings, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = 'souh-settings.json';
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
        }

        function showSuccessModal() {
            document.getElementById('successModal').classList.remove('hidden');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        // Auto-save functionality (optional)
        let autoSaveTimeout;
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('change', () => {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Auto-save logic here
                    console.log('Auto-saving settings...');
                }, 3000);
            });
        });
    </script>
</body>
</html>