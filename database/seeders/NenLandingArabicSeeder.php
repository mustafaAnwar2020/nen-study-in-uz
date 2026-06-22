<?php

namespace Database\Seeders;

use App\Models\NenLandingAgency;
use App\Models\NenLandingDocument;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingFeatureCard;
use App\Models\NenLandingHowItWorksStep;
use App\Models\NenLandingPartnerItem;
use App\Models\NenLandingSetting;
use Illuminate\Database\Seeder;

class NenLandingArabicSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettingsArabic();
        $this->seedPartnersArabic();
        $this->seedFeatureCardsArabic();
        $this->seedHowItWorksArabic();
        $this->seedTranslationAgenciesArabic();
        $this->seedTrustedAgenciesArabic();
        $this->seedDocumentsArabic();
        $this->seedFaqsArabic();
    }

    private function seedSettingsArabic(): void
    {
        NenLandingSetting::getInstance()->update([
            'hero_product_title_ar'  => 'أوزباكستان.',
            'hero_subtitle_ar'       => 'انضم إلى شبكة التعليم المثالية حيث يلتقي الطلاب وأفضل الجامعات والبرامج العالمية! استعد لبدء نجاحك الأكاديمي.',
            'hero_btn_text_ar'       => 'مراكز القبول',
            'hero_official_label_ar' => 'شريك رسمي',
            'about_label_ar'         => 'عن البرنامج',
            'about_title_ar'         => 'عن الدراسة في أوزبكستان؟',
            'about_description_ar'   => 'الدراسة في أوزبكستان مبادرة رسمية من وزارة التعليم العالي لجذب الطلاب الدوليين إلى جامعات عالمية المستوى. من خلال البوابة الرسمية، يمكنك استكشاف البرامج والمتطلبات وفرص المنح الدراسية.',
            'about_stat_label_ar'    => 'سنوات من الخبرة',
            'about_metric1_label_ar' => 'جامعات عالمية',
            'about_metric2_label_ar' => 'دول حول العالم',
            'header_register_text_ar' => 'قدّم الآن',
            'features_title_ar'            => 'لماذا الدراسة في أوزبكستان؟',
            'features_subtitle_ar'         => 'اكتشف مزايا التعليم العالمي في أوزبكستان',
            'how_it_works_title_ar'        => 'رحلتك الدراسية تبدأ هنا',
            'how_it_works_subtitle_ar'     => 'من التسجيل إلى الحصول على التأشيرة، نرافقك خطوة بخطوة نحو الدراسة في أوزبكستان.',
            'how_it_works_btn_text_ar'     => 'قدّم الآن',
            'milestones_title_ar'          => 'عن NEN',
            'milestones_subtitle_ar'       => '',
            'milestones_description_ar'    => '',
            'milestones_cta_text_ar'       => 'مراكز القبول',
            'agencies_title_ar'            => 'وكالات الترجمة المعتمدة',
            'agencies_subtitle_ar'         => 'ترجم مستنداتك الرسمية بسرعة وأمان عبر شبكة مكاتب الترجمة المعتمدة والموثوقة.',
            'documents_title_ar'           => 'مستندات التقديم المطلوبة',
            'documents_subtitle_ar'        => 'جهّز أوراقك الرسمية لإكمال طلبك الجامعي بسلاسة.',
            'trusted_agencies_title_ar'    => 'وكالات الدراسة بالخارج الموثوقة',
            'trusted_agencies_subtitle_ar' => 'تواصل مع مستشارين معتمدين لتبسيط قبولك الجامعي.',
            'faq_title_ar'                 => 'الأسئلة المتكررة',
            'university_logos_title_ar'    => 'شركاء النجاح',
            'footer_tagline_ar'            => 'الشبكة الأهلية للتعليم (NEN)، الشريك الرسمي لوزارة التعليم العالي ومبادرة "الدراسة في أوزبكستان" في الشرق الأوسط، تربط الطلاب بجامعات معترف بها دوليًا وتوفر لهم فرصًا تعليمية متميزة في مختلف أنحاء أوزبكستان.',
            'footer_copyright_ar'          => 'Copyright © ' . date('Y') . ' NEN | National Education Network',
        ]);
    }

    private function seedPartnersArabic(): void
    {
        $map = [
            'Namangan Regional Administration'      => ['name_ar' => 'إدارة منطقة نمنغان', 'description_ar' => 'مزيد من المعلومات'],
            'Namangan State Technical University'     => ['name_ar' => 'جامعة نمنغان التقنية الحكومية', 'description_ar' => 'جامعة نمنغان التقنية الحكومية'],
            'Namangan state pedagogical institute'    => ['name_ar' => 'معهد نمنغان التربوي الحكومي', 'description_ar' => 'معهد نمنغان التربوي الحكومي'],
            'Ministry of Higher Education'            => ['name_ar' => 'وزارة التعليم العالي', 'description_ar' => 'جمهورية أوزبكستان'],
            'Prime Minister\'s Office'                => ['name_ar' => 'مكتب رئيس الوزراء', 'description_ar' => 'جمهورية أوزبكستان'],
        ];

        foreach ($map as $name => $ar) {
            NenLandingPartnerItem::query()->where('name', $name)->update($ar);
        }
    }

    private function seedFeatureCardsArabic(): void
    {
        $map = [
            0 => [
                'stat_label_ar'  => 'جامعات',
                'title_ar'       => 'تعليم عالي الجودة',
                'description_ar' => 'جامعات معترف بها دوليًا، توفر بيئة تعليمية حديثة وبرامج أكاديمية متنوعة باللغة الإنجليزية.',
            ],
            1 => [
                'stat_label_ar'  => 'توفير في التكاليف',
                'title_ar'       => 'تكاليف دراسية ومعيشية ميسرة',
                'description_ar' => 'يمكن للطلاب توفير ما يصل إلى 50٪ من تكاليف الدراسة والمعيشة مقارنة بالعديد من الوجهات التعليمية الأخرى.',
            ],
            2 => [
                'stat_label_ar'  => 'جنسيات',
                'title_ar'       => 'بيئة دولية متنوعة',
                'description_ar' => 'مجتمع طلابي دولي متنامٍ يضم طلابًا من مختلف الجنسيات، مع تزايد عدد البرامج المقدمة باللغة الإنجليزية.',
            ],
            3 => [
                'stat_label_ar'  => 'مؤشر الأمان',
                'title_ar'       => 'بيئة آمنة ومضيافة',
                'description_ar' => 'دولة آمنة ومرحبة بالطلاب الدوليين، تجمع بين جودة الحياة والتراث الثقافي الغني والتجربة التعليمية المتميزة.',
            ],
        ];

        foreach ($map as $sortOrder => $ar) {
            NenLandingFeatureCard::query()->where('sort_order', $sortOrder)->update($ar);
        }
    }

    private function seedHowItWorksArabic(): void
    {
        $map = [
            1 => [
                'title_ar'       => 'التسجيل',
                'description_ar' => 'أنشئ حسابك على بوابة الدراسة في أوزبكستان.',
            ],
            2 => [
                'title_ar'       => 'اختيار التخصص والجامعة',
                'description_ar' => 'اختر الجامعة والتخصص المناسبين لأهدافك الأكاديمية.',
            ],
            3 => [
                'title_ar'       => 'تقديم المستندات',
                'description_ar' => 'قم بتجهيز وتسليم المستندات المطلوبة من خلال مراكز القبول المعتمدة.',
            ],
            4 => [
                'title_ar'       => 'التحقق من المستندات',
                'description_ar' => 'نتولى مراجعة المستندات والتحقق منها والتنسيق مع الجهات المختصة.',
            ],
            5 => [
                'title_ar'       => 'إجراءات القبول',
                'description_ar' => 'تابع حالة طلبك واستلم تحديثات القبول والدعم اللازم خلال العملية.',
            ],
            6 => [
                'title_ar'       => 'الحصول على التأشيرة',
                'description_ar' => 'استكمل إجراءات التأشيرة واستعد لبدء رحلتك الدراسية في أوزبكستان.',
            ],
        ];

        foreach ($map as $stepNumber => $ar) {
            NenLandingHowItWorksStep::query()->where('step_number', $stepNumber)->update($ar);
        }
    }

    private function seedTranslationAgenciesArabic(): void
    {
        $map = [
            'ArabTrans Egypt' => [
                'name_ar'                => 'ArabTrans مصر',
                'service_description_ar' => 'خدمات ترجمة معتمدة',
                'location_ar'            => 'القاهرة',
            ],
            'Alex Docs' => [
                'name_ar'                => 'Alex Docs',
                'service_description_ar' => 'ترجمة أكاديمية وقانونية',
                'location_ar'            => 'الإسكندرية',
            ],
            'Giza Translate' => [
                'name_ar'                => 'Giza Translate',
                'service_description_ar' => 'مركز ترجمة المستندات الرسمية',
                'location_ar'            => 'الجيزة',
            ],
            'Future Translate' => [
                'name_ar'                => 'Future Translate',
                'service_description_ar' => 'حلول ترجمة معتمدة',
                'location_ar'            => 'القاهرة',
            ],
        ];

        foreach ($map as $name => $ar) {
            NenLandingAgency::query()
                ->where('type', NenLandingAgency::TYPE_TRANSLATION)
                ->where('name', $name)
                ->update($ar);
        }
    }

    private function seedTrustedAgenciesArabic(): void
    {
        $locationMap = [
            'Giza'       => 'الجيزة',
            'Cairo'      => 'القاهرة',
            'Alexandria' => 'الإسكندرية',
        ];

        NenLandingAgency::query()
            ->where('type', NenLandingAgency::TYPE_TRUSTED)
            ->each(function (NenLandingAgency $agency) use ($locationMap) {
                $agency->update([
                    'service_description_ar' => 'استشارات الدراسة بالخارج',
                    'location_ar'            => $locationMap[$agency->location] ?? $agency->location,
                ]);
            });
    }

    private function seedDocumentsArabic(): void
    {
        $map = [
            'Valid Passport' => 'جواز سفر ساري',
            'Secondary School Certificate' => 'شهادة الثانوية العامة',
            'Language Certificate (If available)' => 'شهادة لغة (إن وُجدت)',
            'National ID Card' => 'بطاقة الهوية الوطنية',
            'Academic Transcripts' => 'كشوف الدرجات الأكاديمية',
            'Medical Certificate (If required)' => 'شهادة طبية (إن لزم)',
            'Passport Size Photos' => 'صور بحجم جواز السفر',
            "Bachelor's Degree (For Postgraduate Applicants)" => 'شهادة البكالوريوس (للدراسات العليا)',
            'Original documents required for immediate verification.' => 'المستندات الأصلية مطلوبة للتحقق الفوري.',
        ];

        foreach ($map as $title => $titleAr) {
            NenLandingDocument::query()->where('title', $title)->update(['title_ar' => $titleAr]);
        }
    }

    private function seedFaqsArabic(): void
    {
        $map = [
            'Are the degrees globally accredited and recognized?' => [
                'question_ar' => 'هل الشهادات معترف بها ومعتمدة عالمياً؟',
                'answer_ar'   => 'نعم. جميع الجامعات المدرجة على بوابة الدراسة في أوزبكستان تحمل اعتماداً دولياً معترفاً به من قبل الهيئات الأكاديمية العالمية.',
            ],
            'What languages are used for teaching programs?' => [
                'question_ar' => 'ما اللغات المستخدمة في برامج التدريس؟',
                'answer_ar'   => 'تُقدَّم البرامج بالأوزبكية والروسية والإنجليزية، حسب الجامعة والكلية المختارة.',
            ],
            'Does this scholarship cover all living expenses?' => [
                'question_ar' => 'هل تغطي المنحة جميع نفقات المعيشة؟',
                'answer_ar'   => 'المنح الممولة بالكامل تغطي الرسوم الدراسية والسكن الجامعي وبدلاً شهرياً. المنح الجزئية قد تغطي الرسوم الدراسية فقط.',
            ],
            'How long does the application process take?' => [
                'question_ar' => 'كم تستغرق عملية التقديم؟',
                'answer_ar'   => 'تستغرق عملية التقديم القياسية من 4 إلى 8 أسابيع من تقديم المستندات إلى تأكيد القبول.',
            ],
            'What are the scholarship requirements and how to apply?' => [
                'question_ar' => 'ما متطلبات المنحة وكيف أقدّم؟',
                'answer_ar'   => 'المنح ممولة بالكامل وتغطي الرسوم والسكن وبدلاً شهرياً دون رسوم خفية. يطور الطلاب مهاراتهم عبر هياكل أكاديمية متقدمة.',
            ],
            'Can I update my documents after submission?' => [
                'question_ar' => 'هل يمكنني تحديث مستنداتي بعد التقديم؟',
                'answer_ar'   => 'يُقبل تحديث المستندات خلال 48 ساعة من التقديم الأولي. تواصل مع نقطة تجميع NEN للمساعدة.',
            ],
            'Is there any age limit for applicants?' => [
                'question_ar' => 'هل يوجد حد عمرى للمتقدمين؟',
                'answer_ar'   => 'برامج البكالوريوس تقبل المتقدمين من 17 إلى 25 سنة. برامج الدراسات العليا لا حد عمرى صارم لها.',
            ],
            'Is there a fee to attend the conference?' => [
                'question_ar' => 'هل هناك رسوم لحضور المؤتمر؟',
                'answer_ar'   => 'تختلف تفاصيل التسجيل حسب الفعالية. يرجى مراجعة صفحة الفعالية للأسعار.',
            ],
            'Can I return or exchange products' => [
                'question_ar' => 'هل يمكنني إرجاع أو استبدال المنتجات؟',
                'answer_ar'   => 'نعم، يمكنك الإرجاع أو الاستبدال خلال 14 يوماً بشرط أن تكون بحالتها الأصلية.',
            ],
            'Is payment secure?' => [
                'question_ar' => 'هل الدفع آمن؟',
                'answer_ar'   => 'بالتأكيد. تُعالَج جميع المعاملات عبر بوابات دفع موثوقة وآمنة.',
            ],
        ];

        foreach ($map as $question => $ar) {
            NenLandingFaqItem::query()->where('question', $question)->update($ar);
        }
    }
}
