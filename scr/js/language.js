// Language Configuration
const languages = {
    vi: {
        // Page Titles
        pageTitle: "Trang chủ",
        signupPageTitle: "Đăng ký - VieGrand",
        
        // Header
        home: "Trang Chủ",
        about: "Về chúng tôi", 
        features: "Chức năng",
        pricing: "Giá cả",
        contact: "Liên hệ",
        login: "Đăng nhập",
        signup: "Đăng ký",
        
        // Hero Section
        heroTitle: "VIEGRAND",
        heroSubtitle: "CHĂM SÓC NGƯỜI THÂN THEO CÁCH HIỆN ĐẠI",
        heroDescription: "Ứng dụng phát hiện sớm đột quỵ dành riêng cho người cao tuổi <br> Nơi công nghệ kết hợp cùng y học, mang đến sự an tâm cho bạn.",
        exploreBtnText: "Khám phá ngay",
        demoBtnText: "Xem Demo",
        scrollText: "Cuộn xuống để khám phá",
        
        // Main Content
        homePageTitle: "Trang chủ",
        welcomeTitle: "Chào mừng bạn đến với trang chủ",
        welcomeDescription: "Đây là trang chủ của website - bạn có thể thêm nội dung chính tại đây.",
        
        // About Us Section
        aboutTitle: "VIEGRAND",
        aboutSubtitle: "Câu chuyện về những học sinh trẻ với ước mơ tạo nên sự khác biệt",
        aboutIntro: "VieGrand là một giải pháp công nghệ y tế được phát triển bởi nhóm học sinh trường THPT Nguyễn Hữu Huân, với mong muốn góp phần xây dựng một xã hội nhân văn và bền vững, nơi người cao tuổi được chăm sóc toàn diện cả về thể chất lẫn tinh thần.",
        
        // About Us Story Section
        aboutStoryTitle: "Khởi Đầu Từ Trái Tim",
        aboutStoryText1: "VieGrand ra đời từ những trải nghiệm thực tế của chúng tôi - một nhóm học sinh THPT Nguyễn Hữu Huân. Xuất phát từ sự thấu hiểu những khó khăn mà ông bà, cha mẹ gặp phải trong quá trình chăm sóc sức khỏe, tập thể nhóm đã nhận thấy tiềm năng của công nghệ như một cầu nối hiệu quả nhằm hỗ trợ và cải thiện chất lượng cuộc sống cho người thân yêu.",
        aboutStoryText2: "Chúng tôi không chỉ muốn tạo ra một sản phẩm công nghệ, mà mong muốn xây dựng một giải pháp mang tính nhân văn, giúp các gia đình Việt Nam duy trì và phát huy truyền thống hiếu thảo trong thời đại số.",
        aboutStoryQuote: "Từ những đêm thức trắng nghiên cứu công nghệ AI, đến những lần thử nghiệm không thành công, chúng tôi luôn được thúc đẩy bởi một niềm tin: công nghệ phải phục vụ tình người.",
        
        // Mission & Vision
        aboutMissionTitle: "Sứ Mệnh",
        aboutMissionText: "Ứng dụng công nghệ AI và IoT để tạo ra giải pháp chăm sóc sức khỏe toàn diện, giúp người cao tuổi sống khỏe mạnh, hạnh phúc và giúp các gia đình Việt duy trì truyền thống hiếu thảo trong thời đại số.",
        aboutVisionTitle: "Tầm Nhìn",
        aboutVisionText: "Trở thành nền tảng chăm sóc người cao tuổi thông minh, nhân ái và đáng tin cậy hàng đầu tại Việt Nam, góp phần xây dựng một xã hội có trái tim, nơi mỗi gia đình đều được hỗ trợ trong việc chăm sóc những người thân yêu.",
        
        // Values Section
        valuesTitle: "Giá Trị Cốt Lõi",
        valuesSubtitle: "Những nguyên tắc định hướng mọi hoạt động của chúng tôi",
        value1Title: "Yêu Thương & Quan Tâm",
        value1Desc: "Yêu thương và quan tâm chính là nền tảng vững chắc tạo nên mọi sản phẩm chăm sóc sức khỏe chất lượng",
        value2Title: "Đổi Mới Sáng Tạo",
        value2Desc: "Áp dụng công nghệ tiên tiến nhất để giải quyết vấn đề thực tế trong chăm sóc người cao tuổi.",
        value3Title: "An Toàn & Tin Cậy",
        value3Desc: "Đảm bảo độ tin cậy và bảo mật cao nhất trong mọi tính năng và dữ liệu người dùng.",
        value4Title: "Hỗ Trợ Gia Đình",
        value4Desc: "Không chỉ chăm sóc người cao tuổi mà còn hỗ trợ con cháu thực hiện trách nhiệm hiếu thảo.",
        value5Title: "Dễ Sử Dụng",
        value5Desc: "Thiết kế giao diện đơn giản, phù hợp với người cao tuổi và dễ dàng cho cả gia đình.",
        value6Title: "Phù Hợp Văn Hóa Việt",
        value6Desc: "Thiết kế dành riêng cho gia đình Việt, tôn trọng và phát huy giá trị truyền thống hiếu thảo.",
        
        // Team Section
        teamTitle: "Đội Ngũ VieGrand",
        teamDescription: "Chúng tôi là những học sinh trẻ đầy nhiệt huyết từ trường THPT Nguyễn Hữu Huân, với ước mơ ứng dụng công nghệ để tạo nên những giá trị tích cực cho xã hội.",
        teamTagline: "VieGrand – CHĂM SÓC NGƯỜI THÂN THEO CÁCH HIỆN ĐẠI",
        
        // About Us Features
        aboutFeature1Title: "Trí tuệ nhân tạo tiên tiến",
        aboutFeature1Desc: "Kết hợp AI và hệ thống camera thông minh để phát hiện sớm các tình huống nguy hiểm như đột quỵ, té ngã trong thời gian thực.",
        aboutFeature2Title: "Bảo vệ toàn diện", 
        aboutFeature2Desc: "Gửi cảnh báo khẩn cấp đến người thân ngay lập tức khi phát hiện tình huống bất thường, đảm bảo an toàn tuyệt đối.",
        aboutFeature3Title: "Theo dõi sức khỏe thông minh",
        aboutFeature3Desc: "Không chỉ là ứng dụng theo dõi sức khỏe, VieGrand còn là cầu nối giữa các thế hệ trong gia đình.",
        aboutFeature4Title: "Kết nối gia đình",
        aboutFeature4Desc: "Giúp con cháu chủ động chăm sóc người thân, ông bà từ xa, dù không thể ở bên, tiếp nối sự hiếu thảo truyền thống.",
        aboutFeature5Title: "Phân tích dữ liệu chuyên sâu",
        aboutFeature5Desc: "Sử dụng công nghệ phân tích dữ liệu và theo dõi, giúp người dùng phát hiện những nguy cơ sức khỏe tiềm ẩn.",
        aboutFeature6Title: "Tầm nhìn & sứ mệnh",
        aboutFeature6Desc: "VieGrand hướng đến trở thành nền tảng hỗ trợ chăm sóc người cao tuổi thông minh và nhân ái hàng đầu tại Việt Nam.",
        
        // Quote and Tagline
        aboutQuote: "Chúng tôi tin rằng: công nghệ không chỉ là công cụ, mà còn có thể trở thành người bạn đồng hành thầm lặng, tiếp nối sự hiếu thảo và lan tỏa yêu thương trong mỗi gia đình Việt.",
        aboutTagline: "VieGrand – CHĂM SÓC NGƯỜI THÂN THEO CÁCH HIỆN ĐẠI",
        
        // Features Section
        featuresTitle: "Tính Năng Nổi Bật",
        featuresSubtitle: "VieGrand tích hợp những công nghệ tiên tiến nhất để mang đến trải nghiệm chăm sóc sức khỏe toàn diện và thông minh",
        
        // Features List
        feature1Title: "Phát Hiện AI Thông Minh",
        feature1Desc: "Hệ thống AI tiên tiến với camera thông minh phát hiện tức thì các tình huống khẩn cấp như đột quỵ, té ngã, bất tỉnh với độ chính xác cao.",
        feature2Title: "Cảnh Báo Khẩn Cấp",
        feature2Desc: "Gửi thông báo tức thì đến người thân qua SMS, call, email khi phát hiện tình huống nguy hiểm. Kết nối với trung tâm y tế gần nhất.",
        feature3Title: "Cập Nhật Thông Tin Sức Khỏe Chỉ Bằng Camera",
        feature3Desc: "Monitor nhịp tim, huyết áp, nhiệt độ cơ thể, giấc ngủ 24/7 chỉ bằng camera thông minh. Phân tích xu hướng sức khỏe và đưa ra khuyến nghị cá nhân hóa.",
        feature4Title: "Kết Nối Gia Đình",
        feature4Desc: "Ứng dụng di động cho con cháu theo dõi tình hình sức khỏe cha mẹ từ xa. Video call, nhắn tin, chia sẻ khoảnh khắc hàng ngày.",
        feature5Title: "Phát Hiện Sớm Và Cảnh Báo Đột Quỵ",
        feature5Desc: "Sử dụng công nghệ AI tiên tiến để phát hiện các dấu hiệu bất thường, cảnh báo sớm nguy cơ đột quỵ và các tình huống khẩn cấp với độ chính xác cao.",
        feature6Title: "Điều Khiển Giọng Nói Tiếng Việt",
        feature6Desc: "Công nghệ nhận diện giọng nói tiếng Việt giúp người cao tuổi dễ dàng điều khiển toàn bộ ứng dụng mà không cần thao tác phức tạp trên màn hình.",
        
        // CTA Section
        ctaTitle: "Sẵn Sàng Trải Nghiệm?",
        ctaDesc: "Tham gia cùng hàng nghìn gia đình Việt đã tin tưởng VieGrand để chăm sóc người thân yêu",
        ctaButton: "Đăng Ký Ngay",
        ctaButtonPrimary: "Đăng Ký Ngay",
        ctaButtonSecondary: "Xem Bảng Giá",
        
        // Technology Section
        techTitle: "Công Nghệ Tiên Tiến",
        techSubtitle: "Được xây dựng trên nền tảng công nghệ hàng đầu thế giới",
        deepLearning: "Deep Learning",
        computerVision: "Computer Vision", 
        cloudComputing: "Cloud Computing",
        edgeSecurity: "Edge Security",
        
        // Statistics Section
        aiAccuracy: "Độ Chính Xác AI",
        responseTime: "Thời Gian Phản Ứng",
        continuousMonitoring: "Giám Sát Liên Tục",
        encryptionSecurity: "Mã Hóa Bảo Mật",
        
        // Pricing Section
        pricingTitle: "Bảng Giá Dịch Vụ",
        pricingSubtitle: "Chọn gói dịch vụ phù hợp với nhu cầu của gia đình bạn. Tất cả gói đều bao gồm hỗ trợ 24/7 và cập nhật miễn phí.",
        
        // Basic Plan
        basicPlanName: "Gói Cơ Bản",
        basicPlanDesc: "Phù hợp cho gia đình nhỏ với nhu cầu giám sát cơ bản",
        basicPrice: "299,000",
        perMonth: "/tháng",
        basicFeature1: "Giám sát 1 người cao tuổi",
        basicFeature2: "Phát hiện té ngã cơ bản", 
        basicFeature3: "Cảnh báo qua SMS",
        basicFeature4: "Hỗ trợ email 24/7",
        basicFeature5: "Báo cáo hàng tuần",
        
        // Premium Plan
        premiumPlanName: "Gói Cao Cấp",
        premiumPlanDesc: "Giải pháp toàn diện với AI tiên tiến và tính năng thông minh",
        premiumPrice: "599,000",
        premiumFeature1: "Giám sát đến 3 người cao tuổi",
        premiumFeature2: "AI phát hiện đột quỵ tiên tiến",
        premiumFeature3: "Cảnh báo đa kênh (SMS, Call, Email)",
        premiumFeature4: "Giám sát sức khỏe qua camera",
        premiumFeature5: "Điều khiển bằng giọng nói",
        premiumFeature6: "Ứng dụng mobile cho gia đình",
        premiumFeature7: "Báo cáo chi tiết hàng ngày",
        premiumFeature8: "Hỗ trợ hotline ưu tiên",
        
        // Enterprise Plan
        enterprisePlanName: "Gói Doanh Nghiệp",
        enterprisePlanDesc: "Dành cho viện dưỡng lão và cơ sở chăm sóc chuyên nghiệp",
        contactPrice: "Liên hệ",
        customPrice: "Giá tùy chỉnh",
        enterpriseFeature1: "Giám sát không giới hạn",
        enterpriseFeature2: "Tích hợp hệ thống y tế",
        enterpriseFeature3: "Dashboard quản lý tập trung",
        enterpriseFeature4: "API và tích hợp tùy chỉnh",
        enterpriseFeature5: "Đào tạo nhân viên chuyên sâu",
        enterpriseFeature6: "Hỗ trợ kỹ thuật 24/7",
        enterpriseFeature7: "Báo cáo và phân tích nâng cao",
        
        // Modal Content
        modalBasicTitle: "Gói Cơ Bản",
        modalBasicSubtitle: "Phù hợp cho gia đình nhỏ với nhu cầu giám sát cơ bản",
        modalPremiumTitle: "Gói Cao Cấp",
        modalPremiumSubtitle: "Giải pháp toàn diện với AI tiên tiến và tính năng thông minh",
        modalEnterpriseTitle: "Gói Doanh Nghiệp",
        modalEnterpriseSubtitle: "Dành cho viện dưỡng lão và cơ sở chăm sóc chuyên nghiệp",
        modalRegisterBtn: "Đăng Ký Ngay",
        modalContactBtn: "Liên Hệ Tư Vấn",
        modalCloseBtn: "Đóng",
        
        // Modal Features
        modalBasicFeature1: "Phát hiện té ngã cơ bản",
        modalBasicFeature2: "Cảnh báo qua SMS",
        modalBasicFeature3: "Hỗ trợ email 24/7",
        modalBasicFeature4: "Báo cáo hàng tuần",
        modalBasicFeature5: "Camera HD 1080p",
        modalBasicFeature6: "Lưu trữ 7 ngày",
        
        modalPremiumFeature1: "AI phát hiện đột quỵ tiên tiến",
        modalPremiumFeature2: "Cảnh báo đa kênh (SMS, Call, Email)",
        modalPremiumFeature3: "Giám sát sức khỏe qua camera",
        modalPremiumFeature4: "Điều khiển bằng giọng nói",
        modalPremiumFeature5: "Ứng dụng mobile cho gia đình",
        modalPremiumFeature6: "Báo cáo chi tiết hàng ngày",
        modalPremiumFeature7: "Hỗ trợ hotline ưu tiên",
        modalPremiumFeature8: "Camera 4K Ultra HD",
        modalPremiumFeature9: "Lưu trữ 30 ngày",
        
        modalEnterpriseFeature1: "Tích hợp hệ thống y tế",
        modalEnterpriseFeature2: "Dashboard quản lý tập trung",
        modalEnterpriseFeature3: "API và tích hợp tùy chỉnh",
        modalEnterpriseFeature4: "Đào tạo nhân viên chuyên sâu",
        modalEnterpriseFeature5: "Hỗ trợ kỹ thuật 24/7",
        modalEnterpriseFeature6: "Báo cáo và phân tích nâng cao",
        modalEnterpriseFeature7: "Camera không giới hạn",
        modalEnterpriseFeature8: "Lưu trữ vĩnh viễn",
        
        // Common
        choosePlan: "Chọn Gói",
        contactUs: "Liên Hệ",
        freeTrial: "Dùng thử 7 ngày miễn phí",
        customDemo: "Demo tùy chỉnh miễn phí",
        
        // Contact Support
        needHelpTitle: "Cần Tư Vấn Thêm?",
        needHelpDesc: "Đội ngũ chuyên gia của chúng tôi sẵn sàng hỗ trợ bạn chọn gói dịch vụ phù hợp nhất cho nhu cầu của gia đình.",
        contactSupport: "Liên Hệ Tư Vấn",
        
        // Contact section
        contactSubtitle: "Hãy liên hệ với chúng tôi để được tư vấn và hỗ trợ về VieGrand - giải pháp chăm sóc sức khỏe thông minh",
        contactInfoTitle: "Thông tin liên hệ",
        schoolLabel: "Trường học",
        schoolName: "THPT Nguyễn Hữu Huân",
        addressLabel: "Địa chỉ",
        schoolAddress: "THPT Nguyễn Hữu Huân, 11 Đoàn Kết, Bình Thọ, Thủ Đức, TP.HCM",
        phoneLabel: "Điện thoại",
        emailLabel: "Email",
        workingHoursLabel: "Giờ làm việc",
        workingHours: "Thứ 2 - Thứ 6: 8:00 - 17:00",
        contactFormTitle: "Gửi tin nhắn cho chúng tôi",
        nameLabel: "Họ và tên",
        subjectLabel: "Chủ đề",
        messageLabel: "Nội dung tin nhắn",
        messagePlaceholder: "Nhập nội dung tin nhắn của bạn...",
        sendMessage: "Gửi tin nhắn",
        aboutSchoolTitle: "Về trường THPT Nguyễn Hữu Huân",
        aboutSchoolDesc: "VieGrand được phát triển bởi đội ngũ học sinh tài năng tại trường THPT Nguyễn Hữu Huân",
        projectTeamTitle: "Đội ngũ phát triển dự án",
        teamDescription: "Chúng tôi là nhóm học sinh đam mê công nghệ và y học, mong muốn đóng góp vào việc chăm sóc sức khỏe người cao tuổi thông qua các giải pháp thông minh.",
        projectGoal: "Mục tiêu dự án: Ứng dụng công nghệ AI để phát hiện sớm đột quỵ và các tình huống khẩn cấp, góp phần bảo vệ sức khỏe người cao tuổi.",
        
        missionTitle: "Sứ mệnh của chúng tôi",
        missionText: "Cung cấp giải pháp phát hiện sớm đột quỵ thông minh, chính xác và dễ sử dụng, giúp giảm thiểu rủi ro và nâng cao chất lượng cuộc sống cho người cao tuổi.",
        visionTitle: "Tầm nhìn",
        visionText: "Trở thành người bạn đồng hành công nghệ đáng tin cậy nhất trong mỗi gia đình Việt, góp phần xây dựng một cộng đồng người cao tuổi khỏe mạnh và hạnh phúc.",
        
        // Signup Page
        backHome: "← Về trang chủ",
        signupTitle: "Đăng ký nhận tư vấn",
        signupSubtitle: "Để lại thông tin để nhận tư vấn miễn phí về dịch vụ chăm sóc sức khỏe người cao tuổi từ VieGrand",
        firstNameLabel: "Họ và tên đệm",
        lastNameLabel: "Tên",
        emailLabel: "Email",
        phoneLabel: "Số điện thoại",
        ageLabel: "Tuổi của bạn",
        selectAge: "Chọn độ tuổi",
        relationshipLabel: "Bạn là",
        selectRelationship: "Chọn mối quan hệ",
        self: "Tôi tự sử dụng",
        child: "Con/cháu người cao tuổi",
        spouse: "Vợ/chồng người cao tuổi",
        caregiver: "Người chăm sóc",
        other: "Khác",
        addressLabel: "Địa chỉ",
        needsLabel: "Nhu cầu chăm sóc sức khỏe",
        needsPlaceholder: "Ví dụ: Theo dõi huyết áp, phát hiện sớm đột quỵ, tư vấn dinh dưỡng...",
        termsText: "Tôi đồng ý với ",
        termsLink: "Điều khoản sử dụng",
        andText: " và ",
        privacyLink: "Chính sách bảo mật",
        ofViegrand: " của VieGrand",
        newsletterText: "Tôi muốn nhận thông tin về các tính năng mới và khuyến mãi từ VieGrand",
        signupBtn: "Gửi thông tin nhận tư vấn",
        successTitle: "Đăng ký thành công!",
        successMessage: "Cảm ơn bạn đã để lại thông tin với VieGrand. <strong>Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ tới</strong> để tư vấn chi tiết về dịch vụ chăm sóc sức khỏe người cao tuổi.",
        backToHome: "Về trang chủ",
        continueSignup: "Đăng ký thêm",
        
        // Processing and Status Messages
        processingText: "Đang xử lý...",
        successMessageText: "Cảm ơn bạn đã để lại thông tin với VieGrand. Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ tới để tư vấn chi tiết về dịch vụ chăm sóc sức khỏe người cao tuổi.",
        
        // Language
        languageCode: "VI",
        languageDisplay: "VI"
    },
    
    en: {
        // Page Titles
        pageTitle: "Home",
        signupPageTitle: "Sign Up - VieGrand",
        
        // Header
        home: "Home",
        about: "About Us",
        features: "Features",
        pricing: "Pricing",
        contact: "Contact",
        login: "Login",
        signup: "Sign Up",
        
        // Hero Section
        heroTitle: "VIEGRAND",
        heroSubtitle: "CARING FOR PARENTS THE MODERN WAY",
        heroDescription: "Early stroke detection app designed for the elderly <br> Where technology combines with medicine to bring you peace of mind.",
        exploreBtnText: "Explore Now",
        demoBtnText: "Watch Demo",
        scrollText: "Scroll down to explore",
        
        // Main Content
        homePageTitle: "Homepage",
        welcomeTitle: "Welcome to our homepage",
        welcomeDescription: "This is the homepage of our website - you can add main content here.",
        
        // About Us Section
        aboutTitle: "VIEGRAND",
        aboutSubtitle: "The story of young students with dreams to make a difference",
        aboutIntro: "VieGrand is a healthcare technology solution developed by students from Nguyen Huu Huan High School, aiming to contribute to building a humane and sustainable society where the elderly are comprehensively cared for both physically and mentally.",
        
        // About Us Story Section
        aboutStoryTitle: "Starting from the Heart",
        aboutStoryText1: "VieGrand was born from our real experiences - a group of students from Nguyen Huu Huan High School. Stemming from understanding the difficulties that grandparents and parents face in healthcare, our team recognized the potential of technology as an effective bridge to support and improve the quality of life for loved ones.",
        aboutStoryText2: "We don't just want to create a technology product, but aspire to build a humane solution, helping Vietnamese families maintain and promote traditional filial piety in the digital age.",
        aboutStoryQuote: "From sleepless nights researching AI technology, to unsuccessful trials, we are always driven by one belief: technology must serve human compassion.",
        
        // Mission & Vision
        aboutMissionTitle: "Our Mission",
        aboutMissionText: "Apply AI and IoT technology to create comprehensive healthcare solutions, helping the elderly live healthy and happy lives, and helping Vietnamese families maintain traditional filial piety in the digital age.",
        aboutVisionTitle: "Our Vision",
        aboutVisionText: "To become the leading smart, compassionate and reliable elderly care platform in Vietnam, contributing to building a society with heart, where every family is supported in caring for their loved ones.",
        
        // Values Section
        valuesTitle: "Core Values",
        valuesSubtitle: "The principles that guide all our activities",
        value1Title: "Love & Care",
        value1Desc: "Love and care are the solid foundation that creates every quality healthcare product",
        value2Title: "Innovation & Creativity",
        value2Desc: "Apply the most advanced technology to solve real problems in elderly care.",
        value3Title: "Safety & Reliability",
        value3Desc: "Ensure the highest reliability and security in all features and user data.",
        value4Title: "Family Support",
        value4Desc: "Not only caring for the elderly but also supporting children and grandchildren in fulfilling their filial responsibilities.",
        value5Title: "Easy to Use",
        value5Desc: "Simple interface design, suitable for the elderly and easy for the whole family.",
        value6Title: "Vietnamese Culture Fit",
        value6Desc: "Design specifically for Vietnamese families, respecting and promoting traditional filial piety values.",
        
        // Team Section
        teamTitle: "VieGrand Team",
        teamDescription: "We are young, enthusiastic students from Nguyen Huu Huan High School, with dreams of applying technology to create positive values for society.",
        teamTagline: "VieGrand – CARING FOR LOVED ONES THE MODERN WAY",
        
        // About Us Features
        aboutFeature1Title: "Advanced Artificial Intelligence",
        aboutFeature1Desc: "Combines AI and smart camera systems to detect dangerous situations like stroke, falls in real-time.",
        aboutFeature2Title: "Comprehensive Protection",
        aboutFeature2Desc: "Sends emergency alerts to relatives immediately when abnormal situations are detected, ensuring absolute safety.",
        aboutFeature3Title: "Smart Health Monitoring",
        aboutFeature3Desc: "Not just a health monitoring app, VieGrand is also a bridge between generations in the family.",
        aboutFeature4Title: "Family Connection",
        aboutFeature4Desc: "Helps children and grandchildren proactively care for parents and grandparents from afar, continuing traditional filial piety.",
        aboutFeature5Title: "In-depth Data Analysis",
        aboutFeature5Desc: "Uses data analysis and monitoring technology to help users detect potential health risks.",
        aboutFeature6Title: "Vision & Mission",
        aboutFeature6Desc: "VieGrand aims to become the leading smart and compassionate elderly care support platform in Vietnam.",
        
        // Quote and Tagline
        aboutQuote: "We believe that: technology is not just a tool, but can become a silent companion, continuing filial piety and spreading love in every Vietnamese family.",
        aboutTagline: "VieGrand – Caring for parents in a modern way",
        
        // Features Section
        featuresTitle: "Outstanding Features",
        featuresSubtitle: "VieGrand integrates the most advanced technologies to provide a comprehensive and intelligent healthcare experience",
        
        // Features List
        feature1Title: "Smart AI Detection",
        feature1Desc: "Advanced AI system with smart cameras instantly detects emergency situations like stroke, falls, unconsciousness with high accuracy.",
        feature2Title: "Emergency Alert",
        feature2Desc: "Sends instant notifications to relatives via SMS, call, email when dangerous situations are detected. Connects with the nearest medical center.",
        feature3Title: "Health Information Updates Using Camera Only",
        feature3Desc: "Monitor heart rate, blood pressure, body temperature, sleep 24/7 using only smart cameras. Analyze health trends and provide personalized recommendations.",
        feature4Title: "Family Connection",
        feature4Desc: "Mobile app for children to monitor parents' health remotely. Video calls, messaging, sharing daily moments.",
        feature5Title: "Early Detection And Stroke Warning",
        feature5Desc: "Uses advanced AI technology to detect abnormal signs, early warning of stroke risk and emergency situations with high accuracy.",
        feature6Title: "Vietnamese Voice Control",
        feature6Desc: "Vietnamese voice recognition technology helps elderly people easily control the entire application without complex screen operations.",
        
        // CTA Section
        ctaTitle: "Ready To Experience?",
        ctaDesc: "Join thousands of Vietnamese families who trust VieGrand to care for their loved ones",
        ctaButton: "Sign Up Now",
        ctaButtonPrimary: "Sign Up Now", 
        ctaButtonSecondary: "View Pricing",
        
        // Technology Section
        techTitle: "Advanced Technology",
        techSubtitle: "Built on world-leading technology platforms",
        deepLearning: "Deep Learning",
        computerVision: "Computer Vision", 
        cloudComputing: "Cloud Computing",
        edgeSecurity: "Edge Security",
        
        // Statistics Section
        aiAccuracy: "AI Accuracy",
        responseTime: "Response Time",
        continuousMonitoring: "Continuous Monitoring",
        encryptionSecurity: "Encryption Security",
        
        // Pricing Section
        pricingTitle: "Service Pricing",
        pricingSubtitle: "Choose a service package that suits your family's needs. All packages include 24/7 support and free updates.",
        
        // Basic Plan
        basicPlanName: "Basic Plan",
        basicPlanDesc: "Suitable for small families with basic monitoring needs",
        basicPrice: "299,000",
        perMonth: "/month",
        basicFeature1: "Monitor 1 elderly person",
        basicFeature2: "Basic fall detection",
        basicFeature3: "SMS alerts",
        basicFeature4: "24/7 email support",
        basicFeature5: "Weekly reports",
        
        // Premium Plan
        premiumPlanName: "Premium Plan",
        premiumPlanDesc: "Comprehensive solution with advanced AI and smart features",
        premiumPrice: "599,000",
        premiumFeature1: "Monitor up to 3 elderly people",
        premiumFeature2: "Advanced AI stroke detection",
        premiumFeature3: "Multi-channel alerts (SMS, Call, Email)",
        premiumFeature4: "Camera health monitoring",
        premiumFeature5: "Voice control",
        premiumFeature6: "Family mobile app",
        premiumFeature7: "Detailed daily reports",
        premiumFeature8: "Priority hotline support",
        
        // Enterprise Plan
        enterprisePlanName: "Enterprise Plan",
        enterprisePlanDesc: "For nursing homes and professional care facilities",
        contactPrice: "Contact",
        customPrice: "Custom pricing",
        enterpriseFeature1: "Unlimited monitoring",
        enterpriseFeature2: "Healthcare system integration",
        enterpriseFeature3: "Centralized management dashboard",
        enterpriseFeature4: "API and custom integrations",
        enterpriseFeature5: "In-depth staff training",
        enterpriseFeature6: "24/7 technical support",
        enterpriseFeature7: "Advanced reporting and analytics",
        
        // Modal Content
        modalBasicTitle: "Basic Plan",
        modalBasicSubtitle: "Suitable for small families with basic monitoring needs",
        modalPremiumTitle: "Premium Plan",
        modalPremiumSubtitle: "Comprehensive solution with advanced AI and smart features",
        modalEnterpriseTitle: "Enterprise Plan",
        modalEnterpriseSubtitle: "For nursing homes and professional care facilities",
        modalRegisterBtn: "Register Now",
        modalContactBtn: "Contact for Consultation",
        modalCloseBtn: "Close",
        
        // Modal Features
        modalBasicFeature1: "Basic fall detection",
        modalBasicFeature2: "SMS alerts",
        modalBasicFeature3: "24/7 email support",
        modalBasicFeature4: "Weekly reports",
        modalBasicFeature5: "HD 1080p Camera",
        modalBasicFeature6: "7-day storage",
        
        modalPremiumFeature1: "Advanced AI stroke detection",
        modalPremiumFeature2: "Multi-channel alerts (SMS, Call, Email)",
        modalPremiumFeature3: "Camera health monitoring",
        modalPremiumFeature4: "Voice control",
        modalPremiumFeature5: "Family mobile app",
        modalPremiumFeature6: "Detailed daily reports",
        modalPremiumFeature7: "Priority hotline support",
        modalPremiumFeature8: "4K Ultra HD Camera",
        modalPremiumFeature9: "30-day storage",
        
        modalEnterpriseFeature1: "Healthcare system integration",
        modalEnterpriseFeature2: "Centralized management dashboard",
        modalEnterpriseFeature3: "API and custom integrations",
        modalEnterpriseFeature4: "In-depth staff training",
        modalEnterpriseFeature5: "24/7 technical support",
        modalEnterpriseFeature6: "Advanced reporting and analytics",
        modalEnterpriseFeature7: "Unlimited cameras",
        modalEnterpriseFeature8: "Permanent storage",
        
        // Common Elements
        choosePlan: "Choose Plan",
        contactUs: "Contact Us",
        freeTrial: "7-day free trial",
        customDemo: "Free custom demo",
        
        // Contact Support
        needHelpTitle: "Need More Consultation?",
        needHelpDesc: "Our team of experts is ready to help you choose the most suitable service package for your family's needs.",
        contactSupport: "📞 Contact for Consultation",
        
        // Contact section
        contactSubtitle: "Contact us for consultation and support about VieGrand - intelligent healthcare solution",
        contactInfoTitle: "Contact Information",
        schoolLabel: "School",
        schoolName: "Nguyen Huu Huan High School",
        addressLabel: "Address",
        schoolAddress: "Nguyen Huu Huan High School, 11 Doan Ket, Binh Tho, Thu Duc, Ho Chi Minh City",
        phoneLabel: "Phone",
        emailLabel: "Email",
        workingHoursLabel: "Working Hours",
        workingHours: "Monday - Friday: 8:00 - 17:00",
        contactFormTitle: "Send us a message",
        nameLabel: "Full Name",
        subjectLabel: "Subject",
        messageLabel: "Message Content",
        messagePlaceholder: "Enter your message content...",
        sendMessage: "Send Message",
        aboutSchoolTitle: "About Nguyen Huu Huan High School",
        aboutSchoolDesc: "VieGrand is developed by talented students at Nguyen Huu Huan High School",
        projectTeamTitle: "Project Development Team",
        teamDescription: "We are a group of students passionate about technology and medicine, wishing to contribute to elderly healthcare through smart solutions.",
        projectGoal: "Project Goal: Apply AI technology for early stroke detection and emergency situations, contributing to protecting elderly health.",
        
        missionTitle: "Our Mission",
        missionText: "To provide a smart, accurate, and easy-to-use early stroke detection solution, helping to minimize risks and improve the quality of life for the elderly.",
        visionTitle: "Our Vision",
        visionText: "To become the most trusted technology companion in every Vietnamese family, contributing to building a healthy and happy community of elderly people.",
        
        // Signup Page
        backHome: "← Back to Home",
        signupTitle: "Register for Consultation",
        signupSubtitle: "Leave your information to receive free consultation about elderly healthcare services from VieGrand",
        firstNameLabel: "First Name",
        lastNameLabel: "Last Name",
        emailLabel: "Email",
        phoneLabel: "Phone Number",
        ageLabel: "Your Age",
        selectAge: "Select age range",
        relationshipLabel: "You are",
        selectRelationship: "Select relationship",
        self: "I use it myself",
        child: "Child/grandchild of elderly",
        spouse: "Spouse of elderly",
        caregiver: "Caregiver",
        other: "Other",
        addressLabel: "Address",
        needsLabel: "Healthcare needs",
        needsPlaceholder: "e.g., blood pressure monitoring, early stroke detection, nutrition consultation...",
        termsText: "I agree to the ",
        termsLink: "Terms of Service",
        andText: " and ",
        privacyLink: "Privacy Policy",
        ofViegrand: " of VieGrand",
        newsletterText: "I want to receive information about new features and promotions from VieGrand",
        signupBtn: "Submit Information for Consultation",
        successTitle: "Registration Successful!",
        successMessage: "Thank you for leaving your information with VieGrand. <strong>We will contact you within 24 hours</strong> to provide detailed consultation about elderly healthcare services.",
        backToHome: "Back to Home",
        continueSignup: "Register More",
        
        // Processing and Status Messages
        processingText: "Processing...",
        successMessageText: "Thank you for leaving your information with VieGrand. We will contact you within 24 hours to provide detailed consultation about elderly healthcare services.",
        
        // Language
        languageCode: "US",
        languageDisplay: "US"
    }
};

// Current language state
let currentLanguage = localStorage.getItem('language') || 'vi';
console.log('Initial language from localStorage:', localStorage.getItem('language'));
console.log('Current language set to:', currentLanguage);

// Language switching function
function switchLanguage() {
    currentLanguage = currentLanguage === 'vi' ? 'en' : 'vi';
    localStorage.setItem('selectedLanguage', currentLanguage); // Changed to match initializeLanguage
    console.log('Switching to language:', currentLanguage);
    console.log('Saved to localStorage:', localStorage.getItem('selectedLanguage'));
    updateContent();
    updateLanguageButton();
    
    // Update global reference
    window.currentLanguage = currentLanguage;
}

// Update content based on current language
function updateContent() {
    const lang = languages[currentLanguage];
    
    // Helper function to safely update element
    function safeUpdateElement(selector, content, isHTML = false) {
        const element = document.querySelector(selector);
        if (element) {
            if (isHTML) {
                element.innerHTML = content;
            } else {
                element.textContent = content;
            }
        } else {
            console.warn(`Element not found: ${selector}`);
        }
    }
    
    // Update header navigation
    safeUpdateElement('[data-lang="home"]', lang.home);
    safeUpdateElement('[data-lang="about"]', lang.about);
    safeUpdateElement('[data-lang="features"]', lang.features);
    safeUpdateElement('[data-lang="pricing"]', lang.pricing);
    safeUpdateElement('[data-lang="contact"]', lang.contact);
    safeUpdateElement('[data-lang="login"]', lang.login);
    safeUpdateElement('[data-lang="signup"]', lang.signup);
    
    // Update hero section
    safeUpdateElement('[data-lang="heroTitle"]', lang.heroTitle);
    safeUpdateElement('[data-lang="heroSubtitle"]', lang.heroSubtitle);
    safeUpdateElement('[data-lang="heroDescription"]', lang.heroDescription, true);
    safeUpdateElement('[data-lang="exploreBtnText"]', lang.exploreBtnText);
    safeUpdateElement('[data-lang="demoBtnText"]', lang.demoBtnText);
    safeUpdateElement('[data-lang="scrollText"]', lang.scrollText);
    
    // Update main content
    safeUpdateElement('[data-lang="homePageTitle"]', lang.homePageTitle);
    safeUpdateElement('[data-lang="welcomeTitle"]', lang.welcomeTitle);
    safeUpdateElement('[data-lang="welcomeDescription"]', lang.welcomeDescription);

    // Update About Us Section
    safeUpdateElement('[data-lang="aboutTitle"]', lang.aboutTitle);
    safeUpdateElement('[data-lang="aboutSubtitle"]', lang.aboutSubtitle);
    safeUpdateElement('[data-lang="aboutIntro"]', lang.aboutIntro);
    
    // Update About Us Story Section
    safeUpdateElement('[data-lang="aboutStoryTitle"]', lang.aboutStoryTitle);
    safeUpdateElement('[data-lang="aboutStoryText1"]', lang.aboutStoryText1, true);
    safeUpdateElement('[data-lang="aboutStoryText2"]', lang.aboutStoryText2, true);
    safeUpdateElement('[data-lang="aboutStoryQuote"]', lang.aboutStoryQuote);

    // Update Mission & Vision
    safeUpdateElement('[data-lang="aboutMissionTitle"]', lang.aboutMissionTitle);
    safeUpdateElement('[data-lang="aboutMissionText"]', lang.aboutMissionText, true);
    safeUpdateElement('[data-lang="aboutVisionTitle"]', lang.aboutVisionTitle);
    safeUpdateElement('[data-lang="aboutVisionText"]', lang.aboutVisionText, true);

    // Update Values Section
    safeUpdateElement('[data-lang="valuesTitle"]', lang.valuesTitle);
    safeUpdateElement('[data-lang="valuesSubtitle"]', lang.valuesSubtitle);
    safeUpdateElement('[data-lang="value1Title"]', lang.value1Title);
    safeUpdateElement('[data-lang="value1Desc"]', lang.value1Desc, true);
    safeUpdateElement('[data-lang="value2Title"]', lang.value2Title);
    safeUpdateElement('[data-lang="value2Desc"]', lang.value2Desc, true);
    safeUpdateElement('[data-lang="value3Title"]', lang.value3Title);
    safeUpdateElement('[data-lang="value3Desc"]', lang.value3Desc, true);
    safeUpdateElement('[data-lang="value4Title"]', lang.value4Title);
    safeUpdateElement('[data-lang="value4Desc"]', lang.value4Desc, true);
    safeUpdateElement('[data-lang="value5Title"]', lang.value5Title);
    safeUpdateElement('[data-lang="value5Desc"]', lang.value5Desc, true);
    safeUpdateElement('[data-lang="value6Title"]', lang.value6Title);
    safeUpdateElement('[data-lang="value6Desc"]', lang.value6Desc, true);

    // Update Team Section
    safeUpdateElement('[data-lang="teamTitle"]', lang.teamTitle);
    safeUpdateElement('[data-lang="teamDescription"]', lang.teamDescription, true);
    safeUpdateElement('[data-lang="teamTagline"]', lang.teamTagline);
    
    // Update About Us Features
    safeUpdateElement('[data-lang="aboutFeature1Title"]', lang.aboutFeature1Title);
    safeUpdateElement('[data-lang="aboutFeature1Desc"]', lang.aboutFeature1Desc);
    safeUpdateElement('[data-lang="aboutFeature2Title"]', lang.aboutFeature2Title);
    safeUpdateElement('[data-lang="aboutFeature2Desc"]', lang.aboutFeature2Desc);
    safeUpdateElement('[data-lang="aboutFeature3Title"]', lang.aboutFeature3Title);
    safeUpdateElement('[data-lang="aboutFeature3Desc"]', lang.aboutFeature3Desc);
    safeUpdateElement('[data-lang="aboutFeature4Title"]', lang.aboutFeature4Title);
    safeUpdateElement('[data-lang="aboutFeature4Desc"]', lang.aboutFeature4Desc);
    safeUpdateElement('[data-lang="aboutFeature5Title"]', lang.aboutFeature5Title);
    safeUpdateElement('[data-lang="aboutFeature5Desc"]', lang.aboutFeature5Desc);
    safeUpdateElement('[data-lang="aboutFeature6Title"]', lang.aboutFeature6Title);
    safeUpdateElement('[data-lang="aboutFeature6Desc"]', lang.aboutFeature6Desc);
    
    // Update Quote and Tagline
    safeUpdateElement('[data-lang="aboutQuote"]', lang.aboutQuote);
    safeUpdateElement('[data-lang="aboutTagline"]', lang.aboutTagline);
    
    // Update Features Section
    safeUpdateElement('[data-lang="featuresTitle"]', lang.featuresTitle);
    safeUpdateElement('[data-lang="featuresSubtitle"]', lang.featuresSubtitle);
    
    // Update Features List
    safeUpdateElement('[data-lang="feature1Title"]', lang.feature1Title);
    safeUpdateElement('[data-lang="feature1Desc"]', lang.feature1Desc);
    safeUpdateElement('[data-lang="feature2Title"]', lang.feature2Title);
    safeUpdateElement('[data-lang="feature2Desc"]', lang.feature2Desc);
    safeUpdateElement('[data-lang="feature3Title"]', lang.feature3Title);
    safeUpdateElement('[data-lang="feature3Desc"]', lang.feature3Desc);
    safeUpdateElement('[data-lang="feature4Title"]', lang.feature4Title);
    safeUpdateElement('[data-lang="feature4Desc"]', lang.feature4Desc);
    safeUpdateElement('[data-lang="feature5Title"]', lang.feature5Title);
    safeUpdateElement('[data-lang="feature5Desc"]', lang.feature5Desc);
    safeUpdateElement('[data-lang="feature6Title"]', lang.feature6Title);
    safeUpdateElement('[data-lang="feature6Desc"]', lang.feature6Desc);
    
    // Update CTA Section
    safeUpdateElement('[data-lang="ctaTitle"]', lang.ctaTitle);
    safeUpdateElement('[data-lang="ctaDesc"]', lang.ctaDesc);
    safeUpdateElement('[data-lang="ctaButton"]', lang.ctaButton);
    safeUpdateElement('[data-lang="ctaButtonPrimary"]', lang.ctaButtonPrimary);
    safeUpdateElement('[data-lang="ctaButtonSecondary"]', lang.ctaButtonSecondary);
    
    // Update Pricing Section
    safeUpdateElement('[data-lang="pricingTitle"]', lang.pricingTitle);
    safeUpdateElement('[data-lang="pricingSubtitle"]', lang.pricingSubtitle);
    
    // Basic Plan
    safeUpdateElement('[data-lang="basicPlanName"]', lang.basicPlanName);
    safeUpdateElement('[data-lang="basicPlanDesc"]', lang.basicPlanDesc);
    safeUpdateElement('[data-lang="basicPrice"]', lang.basicPrice);
    safeUpdateElement('[data-lang="perMonth"]', lang.perMonth);
    safeUpdateElement('[data-lang="basicFeature1"]', lang.basicFeature1);
    safeUpdateElement('[data-lang="basicFeature2"]', lang.basicFeature2);
    safeUpdateElement('[data-lang="basicFeature3"]', lang.basicFeature3);
    safeUpdateElement('[data-lang="basicFeature4"]', lang.basicFeature4);
    safeUpdateElement('[data-lang="basicFeature5"]', lang.basicFeature5);
    
    // Premium Plan
    safeUpdateElement('[data-lang="premiumPlanName"]', lang.premiumPlanName);
    safeUpdateElement('[data-lang="premiumPlanDesc"]', lang.premiumPlanDesc);
    safeUpdateElement('[data-lang="premiumPrice"]', lang.premiumPrice);
    safeUpdateElement('[data-lang="premiumFeature1"]', lang.premiumFeature1);
    safeUpdateElement('[data-lang="premiumFeature2"]', lang.premiumFeature2);
    safeUpdateElement('[data-lang="premiumFeature3"]', lang.premiumFeature3);
    safeUpdateElement('[data-lang="premiumFeature4"]', lang.premiumFeature4);
    safeUpdateElement('[data-lang="premiumFeature5"]', lang.premiumFeature5);
    safeUpdateElement('[data-lang="premiumFeature6"]', lang.premiumFeature6);
    safeUpdateElement('[data-lang="premiumFeature7"]', lang.premiumFeature7);
    safeUpdateElement('[data-lang="premiumFeature8"]', lang.premiumFeature8);
    
    // Enterprise Plan
    safeUpdateElement('[data-lang="enterprisePlanName"]', lang.enterprisePlanName);
    safeUpdateElement('[data-lang="enterprisePlanDesc"]', lang.enterprisePlanDesc);
    safeUpdateElement('[data-lang="contactPrice"]', lang.contactPrice);
    safeUpdateElement('[data-lang="customPrice"]', lang.customPrice);
    safeUpdateElement('[data-lang="enterpriseFeature1"]', lang.enterpriseFeature1);
    safeUpdateElement('[data-lang="enterpriseFeature2"]', lang.enterpriseFeature2);
    safeUpdateElement('[data-lang="enterpriseFeature3"]', lang.enterpriseFeature3);
    safeUpdateElement('[data-lang="enterpriseFeature4"]', lang.enterpriseFeature4);
    safeUpdateElement('[data-lang="enterpriseFeature5"]', lang.enterpriseFeature5);
    safeUpdateElement('[data-lang="enterpriseFeature6"]', lang.enterpriseFeature6);
    safeUpdateElement('[data-lang="enterpriseFeature7"]', lang.enterpriseFeature7);
    
    // Modal Content
    safeUpdateElement('[data-lang="modalBasicTitle"]', lang.modalBasicTitle);
    safeUpdateElement('[data-lang="modalBasicSubtitle"]', lang.modalBasicSubtitle);
    safeUpdateElement('[data-lang="modalPremiumTitle"]', lang.modalPremiumTitle);
    safeUpdateElement('[data-lang="modalPremiumSubtitle"]', lang.modalPremiumSubtitle);
    safeUpdateElement('[data-lang="modalEnterpriseTitle"]', lang.modalEnterpriseTitle);
    safeUpdateElement('[data-lang="modalEnterpriseSubtitle"]', lang.modalEnterpriseSubtitle);
    safeUpdateElement('[data-lang="modalRegisterBtn"]', lang.modalRegisterBtn);
    safeUpdateElement('[data-lang="modalContactBtn"]', lang.modalContactBtn);
    safeUpdateElement('[data-lang="modalCloseBtn"]', lang.modalCloseBtn);

    // Modal Features
    safeUpdateElement('[data-lang="modalBasicFeature1"]', lang.modalBasicFeature1);
    safeUpdateElement('[data-lang="modalBasicFeature2"]', lang.modalBasicFeature2);
    safeUpdateElement('[data-lang="modalBasicFeature3"]', lang.modalBasicFeature3);
    safeUpdateElement('[data-lang="modalBasicFeature4"]', lang.modalBasicFeature4);
    safeUpdateElement('[data-lang="modalBasicFeature5"]', lang.modalBasicFeature5);
    safeUpdateElement('[data-lang="modalBasicFeature6"]', lang.modalBasicFeature6);
    safeUpdateElement('[data-lang="modalPremiumFeature1"]', lang.modalPremiumFeature1);
    safeUpdateElement('[data-lang="modalPremiumFeature2"]', lang.modalPremiumFeature2);
    safeUpdateElement('[data-lang="modalPremiumFeature3"]', lang.modalPremiumFeature3);
    safeUpdateElement('[data-lang="modalPremiumFeature4"]', lang.modalPremiumFeature4);
    safeUpdateElement('[data-lang="modalPremiumFeature5"]', lang.modalPremiumFeature5);
    safeUpdateElement('[data-lang="modalPremiumFeature6"]', lang.modalPremiumFeature6);
    safeUpdateElement('[data-lang="modalPremiumFeature7"]', lang.modalPremiumFeature7);
    safeUpdateElement('[data-lang="modalPremiumFeature8"]', lang.modalPremiumFeature8);
    safeUpdateElement('[data-lang="modalPremiumFeature9"]', lang.modalPremiumFeature9);
    safeUpdateElement('[data-lang="modalEnterpriseFeature1"]', lang.modalEnterpriseFeature1);
    safeUpdateElement('[data-lang="modalEnterpriseFeature2"]', lang.modalEnterpriseFeature2);
    safeUpdateElement('[data-lang="modalEnterpriseFeature3"]', lang.modalEnterpriseFeature3);
    safeUpdateElement('[data-lang="modalEnterpriseFeature4"]', lang.modalEnterpriseFeature4);
    safeUpdateElement('[data-lang="modalEnterpriseFeature5"]', lang.modalEnterpriseFeature5);
    safeUpdateElement('[data-lang="modalEnterpriseFeature6"]', lang.modalEnterpriseFeature6);
    safeUpdateElement('[data-lang="modalEnterpriseFeature7"]', lang.modalEnterpriseFeature7);
    safeUpdateElement('[data-lang="modalEnterpriseFeature8"]', lang.modalEnterpriseFeature8);
    
    // Common
    safeUpdateElement('[data-lang="choosePlan"]', lang.choosePlan);
    safeUpdateElement('[data-lang="contactUs"]', lang.contactUs);
    safeUpdateElement('[data-lang="freeTrial"]', lang.freeTrial);
    safeUpdateElement('[data-lang="customDemo"]', lang.customDemo);
    
    // Contact Support
    safeUpdateElement('[data-lang="needHelpTitle"]', lang.needHelpTitle);
    safeUpdateElement('[data-lang="needHelpDesc"]', lang.needHelpDesc);
    safeUpdateElement('[data-lang="contactSupport"]', lang.contactSupport);
    
    // Contact section
    safeUpdateElement('[data-lang="contactSubtitle"]', lang.contactSubtitle);
    safeUpdateElement('[data-lang="contactInfoTitle"]', lang.contactInfoTitle);
    safeUpdateElement('[data-lang="schoolLabel"]', lang.schoolLabel);
    safeUpdateElement('[data-lang="schoolName"]', lang.schoolName);
    safeUpdateElement('[data-lang="addressLabel"]', lang.addressLabel);
    safeUpdateElement('[data-lang="schoolAddress"]', lang.schoolAddress);
    safeUpdateElement('[data-lang="phoneLabel"]', lang.phoneLabel);
    safeUpdateElement('[data-lang="emailLabel"]', lang.emailLabel);
    safeUpdateElement('[data-lang="workingHoursLabel"]', lang.workingHoursLabel);
    safeUpdateElement('[data-lang="workingHours"]', lang.workingHours);
    safeUpdateElement('[data-lang="contactFormTitle"]', lang.contactFormTitle);
    safeUpdateElement('[data-lang="nameLabel"]', lang.nameLabel);
    safeUpdateElement('[data-lang="subjectLabel"]', lang.subjectLabel);
    safeUpdateElement('[data-lang="messageLabel"]', lang.messageLabel);
    safeUpdateElement('[data-lang="messagePlaceholder"]', lang.messagePlaceholder);
    safeUpdateElement('[data-lang="sendMessage"]', lang.sendMessage);
    safeUpdateElement('[data-lang="aboutSchoolTitle"]', lang.aboutSchoolTitle);
    safeUpdateElement('[data-lang="aboutSchoolDesc"]', lang.aboutSchoolDesc);
    safeUpdateElement('[data-lang="projectTeamTitle"]', lang.projectTeamTitle);
    safeUpdateElement('[data-lang="teamDescription"]', lang.teamDescription);
    safeUpdateElement('[data-lang="projectGoal"]', lang.projectGoal);
    
    // Update Signup Page
    safeUpdateElement('[data-lang="backHome"]', lang.backHome);
    safeUpdateElement('[data-lang="signupTitle"]', lang.signupTitle);
    safeUpdateElement('[data-lang="signupSubtitle"]', lang.signupSubtitle);
    safeUpdateElement('[data-lang="firstNameLabel"]', lang.firstNameLabel);
    safeUpdateElement('[data-lang="lastNameLabel"]', lang.lastNameLabel);
    safeUpdateElement('[data-lang="emailLabel"]', lang.emailLabel);
    safeUpdateElement('[data-lang="phoneLabel"]', lang.phoneLabel);
    safeUpdateElement('[data-lang="ageLabel"]', lang.ageLabel);
    safeUpdateElement('[data-lang="selectAge"]', lang.selectAge);
    safeUpdateElement('[data-lang="relationshipLabel"]', lang.relationshipLabel);
    safeUpdateElement('[data-lang="selectRelationship"]', lang.selectRelationship);
    safeUpdateElement('[data-lang="self"]', lang.self);
    safeUpdateElement('[data-lang="child"]', lang.child);
    safeUpdateElement('[data-lang="spouse"]', lang.spouse);
    safeUpdateElement('[data-lang="caregiver"]', lang.caregiver);
    safeUpdateElement('[data-lang="other"]', lang.other);
    safeUpdateElement('[data-lang="addressLabel"]', lang.addressLabel);
    safeUpdateElement('[data-lang="needsLabel"]', lang.needsLabel);
    safeUpdateElement('[data-lang="needsPlaceholder"]', lang.needsPlaceholder);
    safeUpdateElement('[data-lang="termsText"]', lang.termsText);
    safeUpdateElement('[data-lang="termsLink"]', lang.termsLink);
    safeUpdateElement('[data-lang="andText"]', lang.andText);
    safeUpdateElement('[data-lang="privacyLink"]', lang.privacyLink);
    safeUpdateElement('[data-lang="ofViegrand"]', lang.ofViegrand);
    safeUpdateElement('[data-lang="newsletterText"]', lang.newsletterText);
    safeUpdateElement('[data-lang="signupBtn"]', lang.signupBtn);
    safeUpdateElement('[data-lang="successTitle"]', lang.successTitle);
    safeUpdateElement('[data-lang="successMessage"]', lang.successMessage, true); // Allow HTML for <strong> tag
    safeUpdateElement('[data-lang="backToHome"]', lang.backToHome);
    safeUpdateElement('[data-lang="continueSignup"]', lang.continueSignup);
    
    // Processing and Status Messages
    safeUpdateElement('[data-lang="processingText"]', lang.processingText);
    safeUpdateElement('[data-lang="successMessageText"]', lang.successMessageText, true); // Allow HTML for <strong> tag
    
    // Handle placeholders
    const messagePlaceholderElement = document.querySelector('[data-lang-placeholder="messagePlaceholder"]');
    if (messagePlaceholderElement) {
        messagePlaceholderElement.placeholder = lang.messagePlaceholder;
    }
    
    // Handle signup page placeholder
    const needsPlaceholderElement = document.querySelector('[data-lang="needsPlaceholder"]');
    if (needsPlaceholderElement) {
        needsPlaceholderElement.placeholder = lang.needsPlaceholder;
    }
    
    // Update CTA buttons
    safeUpdateElement('[data-lang="ctaButtonPrimary"]', lang.ctaButtonPrimary);
    safeUpdateElement('[data-lang="ctaButtonSecondary"]', lang.ctaButtonSecondary);
    
    // Update Technology Section
    safeUpdateElement('[data-lang="techTitle"]', lang.techTitle);
    safeUpdateElement('[data-lang="techSubtitle"]', lang.techSubtitle);
    safeUpdateElement('[data-lang="deepLearning"]', lang.deepLearning);
    safeUpdateElement('[data-lang="computerVision"]', lang.computerVision);
    safeUpdateElement('[data-lang="cloudComputing"]', lang.cloudComputing);
    safeUpdateElement('[data-lang="edgeSecurity"]', lang.edgeSecurity);
    
    // Update Statistics Section
    safeUpdateElement('[data-lang="aiAccuracy"]', lang.aiAccuracy);
    safeUpdateElement('[data-lang="responseTime"]', lang.responseTime);
    safeUpdateElement('[data-lang="continuousMonitoring"]', lang.continuousMonitoring);
    safeUpdateElement('[data-lang="encryptionSecurity"]', lang.encryptionSecurity);
    
    // Update page title
    document.title = lang.pageTitle;
    
    // Update signup page title
    const signupPageTitle = document.querySelector('title');
    if (signupPageTitle && window.location.pathname.includes('signup')) {
        signupPageTitle.textContent = lang.signupPageTitle;
    }
    
    // Update mission and vision
    safeUpdateElement('[data-lang="missionTitle"]', lang.missionTitle);
    safeUpdateElement('[data-lang="missionText"]', lang.missionText);
    safeUpdateElement('[data-lang="visionTitle"]', lang.visionTitle);
    safeUpdateElement('[data-lang="visionText"]', lang.visionText);
}

// Update language button
function updateLanguageButton() {
    // Try both selectors to handle different button structures
    let langButton = document.querySelector('.language-toggle .flag');
    let isLanguageToggleButton = true;
    
    // If not found, try the header button
    if (!langButton) {
        langButton = document.getElementById('languageToggle');
        isLanguageToggleButton = false;
    }
    
    if (langButton) {
        // Hiển thị ngôn ngữ KHÁC với ngôn ngữ hiện tại (để user biết nhấn sẽ chuyển sang gì)
        if (currentLanguage === 'vi') {
            if (isLanguageToggleButton) {
                langButton.textContent = 'EN'; // Đang tiếng Việt, nhấn để chuyển sang English
            } else {
                langButton.innerHTML = '🌐 EN'; // For header button with globe icon
            }
        } else {
            if (isLanguageToggleButton) {
                langButton.textContent = 'VI'; // Đang tiếng Anh, nhấn để chuyển sang Việt
            } else {
                langButton.innerHTML = '🌐 VI'; // For header button with globe icon
            }
        }
        
        console.log('Language button updated. Current:', currentLanguage, 'Button shows:', langButton.textContent || langButton.innerHTML);
    } else {
        console.warn('Language button not found');
    }
    
    // Update button title for language-toggle style
    const langButtonContainer = document.querySelector('.language-toggle');
    if (langButtonContainer) {
        langButtonContainer.setAttribute('title', `Switch to ${currentLanguage === 'vi' ? 'English' : 'Tiếng Việt'}`);
    }
    
    // Update button title for header style
    const headerButton = document.getElementById('languageToggle');
    if (headerButton) {
        headerButton.setAttribute('title', `Switch to ${currentLanguage === 'vi' ? 'English' : 'Tiếng Việt'}`);
    }
}

// Initialize language system
function initializeLanguage() {
    // Set language from localStorage or default to 'vi'
    const savedLanguage = localStorage.getItem('selectedLanguage');
    if (savedLanguage && (savedLanguage === 'vi' || savedLanguage === 'en')) {
        currentLanguage = savedLanguage;
    }
    
    console.log('Language system initialized. Current language:', currentLanguage);
    updateContent();
    updateLanguageButton();
}

// Initialize language on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing language system');
    initializeLanguage();
});
// Make functions globally available
window.currentLanguage = currentLanguage;
window.languages = languages;
window.switchLanguageGlobal = switchLanguage;
window.updateContentGlobal = updateContent;
window.updateLanguageButtonGlobal = updateLanguageButton;
window.initializeLanguage = initializeLanguage;

// Test function - to be removed later
function testLanguageSwitch() {
    console.log('Test function called');
    switchLanguage();
}
