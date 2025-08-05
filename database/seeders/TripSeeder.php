<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run()
    {
        $trips = [
            [
                'title' => 'رحلة إلى جزر المالديف',
                'description' => 'استمتع بأجمل الشواطئ والمياه الفيروزية في جنة على الأرض. تجربة لا تُنسى مع المنتجعات الفاخرة والأنشطة المائية المتنوعة.',
                'destination' => 'جزر المالديف',
                'price' => 2500.00,
                'start_date' => '2025-09-01',
                'end_date' => '2025-09-07',
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'مغامرة في جبال الألب السويسرية',
                'description' => 'تسلق أعلى القمم واستمتع بالطبيعة الخلابة والهواء النقي. رحلة مثالية لعشاق المغامرة والطبيعة.',
                'destination' => 'سويسرا - جبال الألب',
                'price' => 3200.00,
                'start_date' => '2025-10-15',
                'end_date' => '2025-10-22',
                'image_url' => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'استرخاء في جزيرة بالي',
                'description' => 'شواطئ ساحرة، ثقافة غنية، ومنتجعات فاخرة في جزيرة الآلهة. مكان مثالي للاسترخاء والتجديد.',
                'destination' => 'بالي، إندونيسيا',
                'price' => 1800.00,
                'start_date' => '2025-08-20',
                'end_date' => '2025-08-27',
                'image_url' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'جولة في شوارع طوكيو',
                'description' => 'اكتشف عاصمة اليابان النابضة بالحياة، من المعابد التقليدية إلى ناطحات السحاب الحديثة. تجربة ثقافية فريدة.',
                'destination' => 'طوكيو، اليابان',
                'price' => 2800.00,
                'start_date' => '2025-11-10',
                'end_date' => '2025-11-17',
                'image_url' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'سحر مدينة باريس',
                'description' => 'مدينة الأنوار والحب، استكشف برج إيفل ومتحف اللوفر والشانزليزيه. رحلة رومانسية لا تُنسى.',
                'destination' => 'باريس، فرنسا',
                'price' => 2200.00,
                'start_date' => '2025-09-15',
                'end_date' => '2025-09-20',
                'image_url' => 'https://images.unsplash.com/photo-1502602898536-47ad22581b52?w=800',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'رحلة سفاري في كينيا',
                'description' => 'شاهد الحيوانات البرية في بيئتها الطبيعية في محمية ماساي مارا. مغامرة أفريقية أصيلة.',
                'destination' => 'نيروبي، كينيا',
                'price' => 3500.00,
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-08',
                'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'استكشاف معالم روما',
                'description' => 'تجول في المدينة الخالدة واستكشف الكولوسيوم والفاتيكان ونافورة تريفي. رحلة عبر التاريخ.',
                'destination' => 'روما، إيطاليا',
                'price' => 1950.00,
                'start_date' => '2025-10-05',
                'end_date' => '2025-10-10',
                'image_url' => 'https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'جزر اليونان الساحرة',
                'description' => 'استمتع بجمال جزر سانتوريني وميكونوس، مع الشواطئ الرملية والقرى البيضاء الخلابة.',
                'destination' => 'سانتوريني، اليونان',
                'price' => 2100.00,
                'start_date' => '2025-08-10',
                'end_date' => '2025-08-16',
                'image_url' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49e?w=800',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'رحلة إلى مدينة دبي',
                'description' => 'اكتشف عجائب دبي الحديثة من برج خليفة إلى نخلة جميرا. مزيج رائع من التقليد والحداثة.',
                'destination' => 'دبي، الإمارات',
                'price' => 1200.00,
                'start_date' => '2025-09-25',
                'end_date' => '2025-09-29',
                'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'تركيا بين التاريخ والطبيعة',
                'description' => 'استكشف إسطنبول وكابادوكيا، حيث يلتقي التاريخ العريق بالطبيعة الساحرة والثقافة الغنية.',
                'destination' => 'إسطنبول، تركيا',
                'price' => 1600.00,
                'start_date' => '2025-11-20',
                'end_date' => '2025-11-26',
                'image_url' => 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?w=800',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}