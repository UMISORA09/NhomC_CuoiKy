<?php
/**
 * Seeder Dữ Liệu Việc Làm - Nhóm C JobScout
 * Tạo hàng loạt jobs chất lượng cao, chuẩn cấu trúc Figma 100%
 * Cách dùng: php seed_jobs.php
 */

require_once __DIR__ . '/wp-load.php';

if ( php_sapi_name() !== 'cli' && ! current_user_can( 'manage_options' ) ) {
    die( 'Chỉ quản trị viên hoặc dòng lệnh CLI mới có thể chạy Seeder.' );
}

echo "================================================================================\n";
echo "   JOBSCOUT SEEDER - TẠO HÀNG LOẠT VIỆC LÀM CHUẨN ĐỒ ÁN NHÓM C (FIT-TDC)\n";
echo "================================================================================\n\n";

// 1. Danh sách Danh mục chuẩn
$categories = array(
    'Hotel Management'        => 'Quản lý khách sạn & resort cao cấp',
    'Hospitality & Tourism'   => 'Dịch vụ du lịch, lữ hành và khách sạn',
    'Food & Beverage'         => 'Ẩm thực, quầy bar & nhà hàng cao cấp',
    'Information Technology'  => 'Công nghệ thông tin, lập trình & hệ thống',
    'Marketing & Sales'       => 'Tiếp thị số, truyền thông & phát triển kinh doanh',
    'Operations & Logistics'  => 'Vận hành, giám sát an ninh & hậu cần',
    'Human Resources'         => 'Nhân sự, đào tạo & phát triển nhân tài',
    'Finance & Accounting'    => 'Tài chính, kế toán & phân tích doanh thu'
);

$cat_term_ids = array();
foreach ( $categories as $cat_name => $cat_desc ) {
    $term = get_term_by( 'name', $cat_name, 'job_listing_category' );
    if ( ! $term ) {
        $res = wp_insert_term( $cat_name, 'job_listing_category', array( 'description' => $cat_desc ) );
        if ( ! is_wp_error( $res ) ) {
            $cat_term_ids[$cat_name] = $res['term_id'];
        }
    } else {
        $cat_term_ids[$cat_name] = $term->term_id;
    }
}

// 2. Danh sách Hình thức làm việc
$job_types = array(
    'Fulltime'   => 'Toàn thời gian cố định',
    'Part Time'  => 'Bán thời gian linh hoạt',
    'Freelance'  => 'Làm việc tự do theo dự án',
    'Internship' => 'Thực tập sinh tiềm năng',
    'Temporary'  => 'Hợp đồng ngắn hạn thời vụ'
);

$type_term_ids = array();
foreach ( $job_types as $t_name => $t_desc ) {
    $term = get_term_by( 'name', $t_name, 'job_listing_type' );
    if ( ! $term ) {
        $res = wp_insert_term( $t_name, 'job_listing_type', array( 'description' => $t_desc ) );
        if ( ! is_wp_error( $res ) ) {
            $type_term_ids[$t_name] = $res['term_id'];
        }
    } else {
        $type_term_ids[$t_name] = $term->term_id;
    }
}

// 3. Danh sách Công ty đối tác & Brands
$companies_info = array(
    'THE SODOH' => array(
        'website' => 'https://thesodoh.com',
        'tagline' => 'Historic Luxury Property in Kyoto',
        'rating'  => '4.8',
        'city'    => 'Ho Chi Minh City / Kyoto'
    ),
    'FORTUNE GARDEN' => array(
        'website' => 'https://fortunegarden.com',
        'tagline' => 'Iconic Heritage Garden Hotel & Dining',
        'rating'  => '4.7',
        'city'    => 'Ha Noi / Kyoto'
    ),
    'BANQUET EVENTS' => array(
        'website' => 'https://banquet-events.jp',
        'tagline' => 'Premier Event & Wedding Operations',
        'rating'  => '4.6',
        'city'    => 'Ho Chi Minh City'
    ),
    'SEVEN HOUSE' => array(
        'website' => 'https://sevenhouse.com',
        'tagline' => 'Boutique Lifestyle Accommodation',
        'rating'  => '4.5',
        'city'    => 'Da Nang / Ho Chi Minh'
    ),
    'PHO THIN TOKYO' => array(
        'website' => 'https://phothin-tokyo.jp',
        'tagline' => 'Authentic Vietnamese Heritage Dining',
        'rating'  => '4.7',
        'city'    => 'Tokyo / Ho Chi Minh City'
    ),
    'STAND GLOBAL' => array(
        'website' => 'https://fromwhereistand.jp',
        'tagline' => 'Global Hospitality & Lifestyle Group',
        'rating'  => '4.4',
        'city'    => 'Ho Chi Minh City'
    ),
    'MoMo Financial Technology' => array(
        'website' => 'https://momo.vn',
        'tagline' => 'Super App & Fintech Platform',
        'rating'  => '4.6',
        'city'    => 'Ho Chi Minh City'
    ),
    'FPT Software Vietnam' => array(
        'website' => 'https://fpt-software.com',
        'tagline' => 'Leading IT & Digital Transformation Enterprise',
        'rating'  => '4.5',
        'city'    => 'Ha Noi / Da Nang / HCM'
    ),
    'VNG Corporation' => array(
        'website' => 'https://vng.com.vn',
        'tagline' => 'Digital Entertainment & Cloud Solutions',
        'rating'  => '4.5',
        'city'    => 'Ho Chi Minh City'
    ),
    'Viettel Digital Solutions' => array(
        'website' => 'https://viettel.vn',
        'tagline' => 'Pioneer in Digital Ecosystem & Big Data',
        'rating'  => '4.6',
        'city'    => 'Ha Noi'
    ),
);

// 4. Danh sách 36 Việc làm đa dạng chuẩn phong cách Figma
$seed_jobs = array(
    // THE SODOH (Hotel & Hospitality)
    array(
        'title'    => 'HOTEL MANAGER',
        'company'  => 'THE SODOH',
        'location' => 'Ho Chi Minh City',
        'category' => 'Hotel Management',
        'type'     => 'Fulltime',
        'rating'   => '4.8',
        'date'     => '2026-10-01 09:00:00',
        'overview' => 'The Sodoh Higashiyama Kyoto is a premier historic hospitality venue blending traditional Japanese architecture with modern boutique luxury services.',
        'skills'   => array(
            'Over 7 years of proven executive leadership in 5-star international hotels or luxury boutique properties.',
            'Exceptional command of guest journey orchestration, room division management, and financial budgeting.',
            'Fluent bilingual proficiency in English and Vietnamese; Japanese communication is a huge advantage.'
        )
    ),
    array(
        'title'    => 'GENERAL MANAGER - LEADING HOTEL CHAIN',
        'company'  => 'THE SODOH',
        'location' => 'Ho Chi Minh City / Kyoto',
        'category' => 'Hotel Management',
        'type'     => 'Fulltime',
        'rating'   => '4.9',
        'date'     => '2026-10-02 10:15:00',
        'overview' => 'We are seeking an inspirational General Manager to drive strategic operations and maintain the highest benchmarks of Omotenashi guest service across our properties.',
        'skills'   => array(
            'Demonstrated track record directing multi-outlet luxury resort or boutique hotel operations.',
            'Strong acumen in revenue management, P&L stewardship, and staff leadership.',
            'Inspiring executive presence and outstanding interpersonal negotiation capabilities.'
        )
    ),
    array(
        'title'    => 'EXECUTIVE SOUS CHEF',
        'company'  => 'THE SODOH',
        'location' => 'Ho Chi Minh City',
        'category' => 'Food & Beverage',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-10-03 14:30:00',
        'overview' => 'The Sodoh culinary department delivers world-class dining experiences combining classic Italian flair with refined Japanese seasonal ingredients.',
        'skills'   => array(
            'Culinary arts degree with minimum 5 years supervisory experience in fine dining kitchens.',
            'Deep expertise in kitchen inventory optimization, HACCP food hygiene compliance, and team mentoring.',
            'Passion for aesthetic menu curation and seasonal ingredient pairing.'
        )
    ),
    array(
        'title'    => 'GUEST RELATIONS MANAGER',
        'company'  => 'THE SODOH',
        'location' => 'Ho Chi Minh City',
        'category' => 'Hospitality & Tourism',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-10-04 11:00:00',
        'overview' => 'Be the ambassador of first impressions, ensuring VIP guests receive bespoke attention and unforgettable cultural hospitality during their stay.',
        'skills'   => array(
            'Extensive experience managing VIP concierge and front office hospitality relations.',
            'Calm problem-solving attitude with empathetic communication and active listening.',
            'Fluency in English and communicative Japanese or French is highly preferred.'
        )
    ),

    // FORTUNE GARDEN
    array(
        'title'    => 'BUSINESS DEVELOPMENT MANAGER',
        'company'  => 'FORTUNE GARDEN',
        'location' => 'Ha Noi',
        'category' => 'Marketing & Sales',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-09-28 08:30:00',
        'overview' => 'Fortune Garden Kyoto is renowned for iconic garden-facing architecture, luxury private events, and gourmet banquet receptions.',
        'skills'   => array(
            'Strong background establishing B2B corporate partnerships and high-value event sales contracts.',
            'Data-driven approach to market trends, pipeline analytics, and client relationship management.',
            'High emotional intelligence with polished pitching and presentation capabilities.'
        )
    ),
    array(
        'title'    => 'EVENT SALES EXECUTIVE',
        'company'  => 'FORTUNE GARDEN',
        'location' => 'Ha Noi',
        'category' => 'Marketing & Sales',
        'type'     => 'Fulltime',
        'rating'   => '4.5',
        'date'     => '2026-09-29 09:45:00',
        'overview' => 'Work closely with clients to curate tailor-made luxury celebrations, wedding receptions, and high-profile corporate galas in an exquisite garden ambiance.',
        'skills'   => array(
            '2+ years in hospitality event coordination or luxury wedding consultation.',
            'Organized attention to detail with proactive timeline and vendor management skills.',
            'Energetic, customer-centric mindset with goal-oriented sales motivation.'
        )
    ),
    array(
        'title'    => 'PASTRY CHEF & DESSERT DESIGNER',
        'company'  => 'FORTUNE GARDEN',
        'location' => 'Ha Noi',
        'category' => 'Food & Beverage',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-10-01 15:00:00',
        'overview' => 'Create artisan desserts, seasonal afternoon teas, and bespoke wedding cakes that elevate the visual and gastronomic dining journey.',
        'skills'   => array(
            'Proven mastery of French and Japanese pastry techniques, chocolate sculpting, and modern plating.',
            'Creativity in experimenting with exotic fruits, matcha, and organic ingredients.',
            'Strong kitchen discipline and sanitation compliance.'
        )
    ),

    // BANQUET EVENTS
    array(
        'title'    => 'BANQUET MANAGER',
        'company'  => 'BANQUET EVENTS',
        'location' => 'Ho Chi Minh City',
        'category' => 'Hospitality & Tourism',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-09-26 10:00:00',
        'overview' => 'Banquet Events specializes in delivering five-star banquet execution for private banquets, celebrity receptions, and multinational corporate conventions.',
        'skills'   => array(
            'Direct experience coordinating large-scale banquet floor service exceeding 500 attendees.',
            'Ability to guide and motivate casual banquet waitstaff to uphold Michelin-level service etiquette.',
            'Sharp real-time crisis resolution and logistics synchronization capabilities.'
        )
    ),
    array(
        'title'    => 'WEDDING PLANNER SPECIALIST',
        'company'  => 'BANQUET EVENTS',
        'location' => 'Ho Chi Minh City',
        'category' => 'Hospitality & Tourism',
        'type'     => 'Fulltime',
        'rating'   => '4.8',
        'date'     => '2026-09-27 13:30:00',
        'overview' => 'Turn couples’ dream wedding visions into reality through meticulous ceremony design, emotional storytelling, and seamless day-of execution.',
        'skills'   => array(
            'Deep aesthetic taste in floral decor, lighting arrangements, and thematic ceremony design.',
            'Empathetic client communication with flawless budget tracking and vendor coordination.',
            'End-to-end event production experience in premium hospitality venues.'
        )
    ),
    array(
        'title'    => 'AUDIO VISUAL (AV) TECHNICIAN',
        'company'  => 'BANQUET EVENTS',
        'location' => 'Ho Chi Minh City',
        'category' => 'Operations & Logistics',
        'type'     => 'Part Time',
        'rating'   => '4.3',
        'date'     => '2026-09-28 14:00:00',
        'overview' => 'Manage state-of-the-art stage lighting, digital soundboards, and LED displays for luxury weddings and corporate galas.',
        'skills'   => array(
            'Proficiency operating professional DMX lighting consoles, audio mixers, and presentation switchers.',
            'Quick troubleshooting skills during live event broadcasts.',
            'Physical fitness and flexibility to support weekend event schedules.'
        )
    ),

    // SEVEN HOUSE
    array(
        'title'    => 'BELLMAN & CONCIERGE ASSISTANT',
        'company'  => 'SEVEN HOUSE',
        'location' => 'Da Nang / Ho Chi Minh',
        'category' => 'Hospitality & Tourism',
        'type'     => 'Fulltime',
        'rating'   => '4.5',
        'date'     => '2026-10-02 08:00:00',
        'overview' => 'Provide warm, courteous assistance with luggage handling, transport arrangements, and neighborhood recommendations for boutique hotel travelers.',
        'skills'   => array(
            'Energetic, cheerful demeanor with passionate pride in hospitality etiquette.',
            'Good conversational English skills; understanding of local sightseeing hotspots.',
            'Valid driver license is an advantageous asset.'
        )
    ),
    array(
        'title'    => 'FRONT DESK SUPERVISOR',
        'company'  => 'SEVEN HOUSE',
        'location' => 'Da Nang',
        'category' => 'Hotel Management',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-10-03 09:30:00',
        'overview' => 'Supervise daily front office shifts, guest check-in/out procedures, and ensure exceptional guest satisfaction ratings on booking platforms.',
        'skills'   => array(
            '3+ years experience with PMS software (Opera, Cloudbeds, or Hotelogix).',
            'Solid leadership capability in coaching front desk agents and managing room allocations.',
            'Exceptional written and oral communication in English.'
        )
    ),
    array(
        'title'    => 'HOUSEKEEPING QUALITY INSPECTOR',
        'company'  => 'SEVEN HOUSE',
        'location' => 'Da Nang',
        'category' => 'Operations & Logistics',
        'type'     => 'Fulltime',
        'rating'   => '4.4',
        'date'     => '2026-10-04 10:45:00',
        'overview' => 'Inspect guest rooms and public spaces to guarantee pristine cleanliness, linen quality, and luxurious room amenity replenishment.',
        'skills'   => array(
            'High vigilance and scrutiny in cleanliness standards and preventive room maintenance.',
            'Fair and supportive team leadership to guide housekeeping attendants efficiently.',
            'Familiarity with green hotel sanitation practices.'
        )
    ),

    // PHO THIN TOKYO
    array(
        'title'    => 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN',
        'company'  => 'PHO THIN TOKYO',
        'location' => 'Ho Chi Minh City / Tokyo',
        'category' => 'Hotel Management',
        'type'     => 'Fulltime',
        'rating'   => '4.9',
        'date'     => '2026-10-05 11:30:00',
        'overview' => 'Leading the expansion of cross-border culinary and boutique stay concepts, bridging Vietnamese cultural gastronomy with Japanese operational discipline.',
        'skills'   => array(
            'Senior executive credentials steering multi-brand hospitality and F&B franchise operations.',
            'Mastery of supply chain governance, labor optimization, and regional expansion strategy.',
            'Bilingual executive negotiation fluency in English and Vietnamese.'
        )
    ),
    array(
        'title'    => 'RESTAURANT MANAGER',
        'company'  => 'PHO THIN TOKYO',
        'location' => 'Tokyo / Ho Chi Minh City',
        'category' => 'Food & Beverage',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-10-06 14:00:00',
        'overview' => 'Lead restaurant floor operations, customer delight metrics, and maintain strict recipe fidelity for authentic Vietnamese heritage pho.',
        'skills'   => array(
            'Strong leadership experience managing high-traffic casual dining restaurants.',
            'Inventory control, staff roster scheduling, and cash management mastery.',
            'Warm, hospitable demeanor with strong intercultural communication.'
        )
    ),
    array(
        'title'    => 'SUPPLY CHAIN & PROCUREMENT SPECIALIST',
        'company'  => 'PHO THIN TOKYO',
        'location' => 'Ho Chi Minh City',
        'category' => 'Operations & Logistics',
        'type'     => 'Fulltime',
        'rating'   => '4.5',
        'date'     => '2026-10-07 15:30:00',
        'overview' => 'Oversee ingredient sourcing, international export compliance, and cold-chain logistics across Southeast Asian and Japanese outlets.',
        'skills'   => array(
            '3+ years in food service supply chain, vendor negotiation, and customs documentation.',
            'Analytical capability to control raw material cost volatility.',
            'Working knowledge of ERP procurement modules.'
        )
    ),

    // STAND GLOBAL
    array(
        'title'    => 'LOSS PREVENTION OFFICER',
        'company'  => 'STAND GLOBAL',
        'location' => 'Ho Chi Minh City',
        'category' => 'Operations & Logistics',
        'type'     => 'Fulltime',
        'rating'   => '4.4',
        'date'     => '2026-09-25 08:30:00',
        'overview' => 'Ensure the physical security, asset safety, and emergency response readiness across boutique lifestyle retail and accommodation properties.',
        'skills'   => array(
            'Certified training in physical security management, CCTV monitoring, and fire safety systems.',
            'Calm crisis de-escalation attitude and discreet observation discipline.',
            'Honest, responsible, and observant personality.'
        )
    ),
    array(
        'title'    => 'OPERATIONS ANALYST',
        'company'  => 'STAND GLOBAL',
        'location' => 'Ho Chi Minh City',
        'category' => 'Operations & Logistics',
        'type'     => 'Fulltime',
        'rating'   => '4.5',
        'date'     => '2026-09-30 09:15:00',
        'overview' => 'Analyze operational metrics, labor productivity, and guest feedback indices to formulate actionable performance enhancement proposals.',
        'skills'   => array(
            'Solid capability with Excel, SQL, and PowerBI visualization tools.',
            'Critical thinking to uncover cost bottlenecks and streamline service workflows.',
            'Strong presentation skills to communicate insights to department heads.'
        )
    ),

    // MoMo Financial Technology (Fintech)
    array(
        'title'    => 'CUSTOMER EXPERIENCE SUPERVISOR',
        'company'  => 'MoMo Financial Technology',
        'location' => 'Ho Chi Minh City',
        'category' => 'Operations & Logistics',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-10-07 09:00:00',
        'overview' => 'MoMo is Vietnam’s number one digital fintech ecosystem empowering over 31 million users with seamless payment and financial services.',
        'skills'   => array(
            'Proven track record leading customer care quality assurance in fintech, banking, or telecom.',
            'Proficiency in omnichannel ticketing systems (Zendesk, Freshdesk) and CSAT/NPS optimization.',
            'Empathetic coaching attitude and strong conflict mediation skills.'
        )
    ),
    array(
        'title'    => 'DATA SCIENTIST – FRAUD DETECTION',
        'company'  => 'MoMo Financial Technology',
        'location' => 'Ho Chi Minh City',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.8',
        'date'     => '2026-10-06 10:30:00',
        'overview' => 'Develop real-time machine learning models to detect fraudulent transactions, account takeovers, and protect user financial assets.',
        'skills'   => array(
            'Strong foundation in Python, PyTorch/TensorFlow, Scikit-learn, and SQL.',
            'Hands-on experience with anomaly detection, graph neural networks, or XGBoost algorithms.',
            'Familiarity with distributed streaming pipelines (Kafka, Spark Streaming).'
        )
    ),
    array(
        'title'    => 'FINTECH PRODUCT MANAGER',
        'company'  => 'MoMo Financial Technology',
        'location' => 'Ho Chi Minh City',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-10-05 13:00:00',
        'overview' => 'Own the end-to-end product lifecycle for micro-lending, investment, or digital insurance features in the MoMo ecosystem.',
        'skills'   => array(
            '4+ years product management experience in mobile apps, fintech, or payment gateways.',
            'Sharp intuition for UX wireframing, A/B testing experimentation, and business metric drivers.',
            'Agile/Scrum certification and cross-functional engineering alignment prowess.'
        )
    ),

    // FPT Software Vietnam (IT & Engineering)
    array(
        'title'    => 'SENIOR FULLSTACK DEVELOPER (PHP / REACT)',
        'company'  => 'FPT Software Vietnam',
        'location' => 'Ha Noi / Da Nang / HCM',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-10-04 14:15:00',
        'overview' => 'FPT Software is a global technology powerhouse delivering world-class digital transformation solutions to Fortune 500 enterprises.',
        'skills'   => array(
            'Expert mastery of modern PHP 8.x (Laravel/WordPress core) and ReactJS/TypeScript.',
            'Solid comprehension of microservices, RESTful/GraphQL APIs, and Docker containerization.',
            'Clean code discipline with CI/CD automated testing workflows.'
        )
    ),
    array(
        'title'    => 'LEAD FRONTEND ENGINEER (NEXTJS / VUE)',
        'company'  => 'FPT Software Vietnam',
        'location' => 'Ho Chi Minh City',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-10-03 16:00:00',
        'overview' => 'Architect high-performance web applications, progressive design systems, and responsive user experiences for overseas enterprise clients.',
        'skills'   => array(
            'Deep expertise in Next.js SSR, Vue 3 Composition API, Tailwind CSS, and Webpack/Vite.',
            'Lighthouse performance tuning, accessibility (WCAG), and SEO best practices.',
            'Mentoring junior engineers and conducting high-standard code reviews.'
        )
    ),
    array(
        'title'    => 'CLOUD DEVOPS ENGINEER (AWS / DOCKER)',
        'company'  => 'FPT Software Vietnam',
        'location' => 'Ha Noi',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-10-02 11:20:00',
        'overview' => 'Build automated, resilient cloud infrastructure pipelines and manage Kubernetes container clusters for global client projects.',
        'skills'   => array(
            'AWS Certified Solutions Architect or DevOps Engineer certification is an advantage.',
            'Hands-on expertise with Terraform, Docker Compose, Kubernetes, and GitLab CI/CD.',
            'Linux system administration and Prometheus/Grafana infrastructure observability.'
        )
    ),
    array(
        'title'    => 'IT PROJECT MANAGER (PMP / AGILE)',
        'company'  => 'FPT Software Vietnam',
        'location' => 'Da Nang',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.8',
        'date'     => '2026-10-01 10:00:00',
        'overview' => 'Lead international development teams to deliver enterprise software projects on schedule, within scope, and exceeding client expectations.',
        'skills'   => array(
            'PMP or PMI-ACP certification with 5+ years managing offshore delivery engagements.',
            'Strong English communication with European, US, and Japanese stakeholders.',
            'Pragmatic risk management, sprint velocity tracking, and budget governance.'
        )
    ),

    // VNG Corporation
    array(
        'title'    => 'AI & DATA ENGINEER',
        'company'  => 'VNG Corporation',
        'location' => 'Ho Chi Minh City',
        'category' => 'Information Technology',
        'type'     => 'Fulltime',
        'rating'   => '4.7',
        'date'     => '2026-09-29 11:00:00',
        'overview' => 'VNG is Vietnam’s leading homegrown technology unicorn with flagship platforms across gaming, Zalo messaging, and artificial intelligence.',
        'skills'   => array(
            'Proficiency in building scalable data pipelines using Apache Spark, Kafka, and Delta Lake.',
            'Experience serving LLM models and high-throughput inference endpoints.',
            'Strong grasp of data warehousing modeling and real-time analytical indexing.'
        )
    ),
    array(
        'title'    => 'SENIOR UI/UX PRODUCT DESIGNER',
        'company'  => 'VNG Corporation',
        'location' => 'Ho Chi Minh City',
        'category' => 'Marketing & Sales',
        'type'     => 'Fulltime',
        'rating'   => '4.8',
        'date'     => '2026-09-30 14:45:00',
        'overview' => 'Craft intuitive user interfaces, micro-interactions, and coherent design systems for applications serving tens of millions of daily active users.',
        'skills'   => array(
            'High proficiency in Figma, design token systems, and interactive prototyping.',
            'Human-centered design thinking validated through usability testing and behavioral analytics.',
            'A rich portfolio showcasing mobile and desktop application masterpieces.'
        )
    ),

    // Viettel Digital Solutions
    array(
        'title'    => 'DIGITAL MARKETING LEAD',
        'company'  => 'Viettel Digital Solutions',
        'location' => 'Ha Noi',
        'category' => 'Marketing & Sales',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-09-28 16:30:00',
        'overview' => 'Drive growth marketing, performance advertising, and organic acquisition strategies across Viettel digital finance platforms.',
        'skills'   => array(
            '5+ years leading omnichannel digital marketing campaigns (Google Ads, Meta, TikTok, SEO).',
            'Analytical attribution modeling and CAC/LTV conversion optimization.',
            'Strategic creative storytelling and agency management capability.'
        )
    ),
    array(
        'title'    => 'HUMAN RESOURCES BUSINESS PARTNER (HRBP)',
        'company'  => 'Viettel Digital Solutions',
        'location' => 'Ha Noi',
        'category' => 'Human Resources',
        'type'     => 'Fulltime',
        'rating'   => '4.5',
        'date'     => '2026-09-27 10:15:00',
        'overview' => 'Partner with technology directors to execute talent acquisition, leadership development programs, and organizational culture building.',
        'skills'   => array(
            'Deep expertise in tech talent recruitment, OKR compensation systems, and employee engagement.',
            'High emotional intelligence with empathetic counseling and conflict resolution skills.',
            'Working understanding of Vietnamese labor legal regulations.'
        )
    ),
    array(
        'title'    => 'FINANCIAL PLANNING & ANALYSIS (FP&A) SPECIALIST',
        'company'  => 'Viettel Digital Solutions',
        'location' => 'Ha Noi',
        'category' => 'Finance & Accounting',
        'type'     => 'Fulltime',
        'rating'   => '4.6',
        'date'     => '2026-09-26 15:45:00',
        'overview' => 'Develop financial models, monthly operational budget forecasts, and strategic capital expenditure analysis for digital investment projects.',
        'skills'   => array(
            'CPA or CFA qualification or equivalent bachelor degree in corporate finance.',
            'Mastery of advanced financial scenario modeling and cost variance analysis.',
            'High integrity, meticulous precision, and executive presentation clarity.'
        )
    )
);

$created_count = 0;
$updated_count = 0;

foreach ( $seed_jobs as $job_data ) {
    $title     = trim( $job_data['title'] );
    $comp_name = $job_data['company'];
    $location  = $job_data['location'];
    $cat_name  = $job_data['category'];
    $type_name = $job_data['type'];
    $rating    = isset( $job_data['rating'] ) ? $job_data['rating'] : '4.5';
    $post_date = isset( $job_data['date'] ) ? $job_data['date'] : current_time( 'mysql' );

    $comp_meta = isset( $companies_info[$comp_name] ) ? $companies_info[$comp_name] : array(
        'website' => 'https://nhomc.fit.tdc.edu.vn',
        'tagline' => 'Partner of Nhom C Platform',
        'rating'  => '4.5',
        'city'    => $location
    );

    // Xây dựng nội dung HTML chuẩn Figma
    $overview_text = $job_data['overview'];
    $skills_html   = '';
    foreach ( $job_data['skills'] as $skill ) {
        $skills_html .= "• " . esc_html( $skill ) . "<br>\n";
    }

    $content_html = "<h3>Overview about Company</h3>\n" .
        "<p>" . esc_html( $overview_text ) . "</p>\n" .
        "<p>Plan Do See Global and its partner affiliates operate world-class lifestyle properties rooted in 'Omotenashi'—the Japanese philosophy of heartfelt hospitality. Our team members enjoy industry-leading compensation, cross-property rotation privileges, and an inspiring multicultural career trajectory.</p>\n\n" .
        "<h3>Our Key Skills</h3>\n" .
        "<p>\n" . $skills_html . "</p>\n\n" .
        "<h3>Why You'll Love Working Here</h3>\n" .
        "<p>• Be responsible for the effective operational management of the business unit.<br>\n" .
        "• Excellent salary bonuses, periodic performance incentives & executive recognition programs.<br>\n" .
        "• Foreign language allowance (up to 500USD/month) and comprehensive premium healthcare insurance.<br>\n" .
        "• Opportunities for international work exchange across Japan, Southeast Asia, and the Americas.</p>\n\n" .
        "<h3>Location</h3>\n" .
        "<p>" . esc_html( $location ) . "</p>\n";

    // Kiểm tra xem job đã tồn tại chưa (dựa theo tiêu đề và tên công ty)
    $existing = get_posts( array(
        'post_type'      => 'job_listing',
        'post_status'    => 'any',
        'title'          => $title,
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => '_company_name',
                'value'   => $comp_name,
                'compare' => '='
            )
        )
    ) );

    $post_args = array(
        'post_title'   => $title,
        'post_content' => $content_html,
        'post_status'  => 'publish',
        'post_type'    => 'job_listing',
        'post_date'    => $post_date,
    );

    if ( ! empty( $existing ) ) {
        $post_id = $existing[0]->ID;
        $post_args['ID'] = $post_id;
        wp_update_post( $post_args );
        $updated_count++;
        $action_label = "[+] Đã cập nhật";
    } else {
        $post_id = wp_insert_post( $post_args );
        $created_count++;
        $action_label = "[*] Tạo mới";
    }

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        // Cập nhật post meta chuẩn WPJM
        update_post_meta( $post_id, '_company_name', $comp_name );
        update_post_meta( $post_id, '_company_website', $comp_meta['website'] );
        update_post_meta( $post_id, '_company_tagline', $comp_meta['tagline'] );
        update_post_meta( $post_id, '_job_location', $location );
        update_post_meta( $post_id, '_staff_rating', $rating );
        update_post_meta( $post_id, '_filled', 0 );
        update_post_meta( $post_id, '_featured', ( rand( 1, 4 ) === 1 ? 1 : 0 ) );
        update_post_meta( $post_id, '_job_expires', '2028-12-31' );

        // Gán taxonomy types
        if ( isset( $type_term_ids[$type_name] ) ) {
            wp_set_object_terms( $post_id, (int)$type_term_ids[$type_name], 'job_listing_type', false );
        }

        // Gán taxonomy category
        if ( isset( $cat_term_ids[$cat_name] ) ) {
            wp_set_object_terms( $post_id, (int)$cat_term_ids[$cat_name], 'job_listing_category', false );
        }

        // Gán companies term
        $comp_term = get_term_by( 'name', $comp_name, 'companies' );
        if ( $comp_term ) {
            wp_set_object_terms( $post_id, (int)$comp_term->term_id, 'companies', false );
        }

        echo "{$action_label}: Job #{$post_id} - '{$title}' ({$comp_name}) | Địa điểm: {$location}\n";
    }
}

echo "\n--------------------------------------------------------------------------------\n";
echo "KẾT QUẢ SEEDER:\n";
echo "- Việc làm tạo mới: {$created_count}\n";
echo "- Việc làm cập nhật: {$updated_count}\n";
$count_obj = wp_count_posts( 'job_listing' );
$total_published = isset( $count_obj->publish ) ? $count_obj->publish : 0;
echo "- Tổng số việc làm hiện có trên hệ thống: {$total_published}\n";
echo "--------------------------------------------------------------------------------\n";
echo "Hoàn tất tạo seeder thành công 100%!\n";
