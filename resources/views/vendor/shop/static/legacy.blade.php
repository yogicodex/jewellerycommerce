<x-shop::layouts>
    {{-- Slot for the page title --}}
    <x-slot:title>
        Legacy & Design Expertise
    </x-slot:title>

    @push('styles')
        <style>
            /* Global Reset */
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: "Poppins", sans-serif;
            }

            /* ---------------- LEGACY ---------------- */
            .legacy-wrapper {
                background: #fff;
                color: #333;
                padding: 50px 8%;
                line-height: 1.7;
            }

            .legacy-wrapper h1 {
                text-align: center;
                font-size: 26px;
                letter-spacing: 2px;
                margin-bottom: 50px;
                color: #222;
            }

            .legacy-section {
                display: flex;
                flex-direction: column;
                gap: 100px;
            }

            .person {
                display: grid;
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }

            .person:nth-child(even) {
                direction: rtl;
            }

            .person:nth-child(even) .person-info {
                direction: ltr;
            }

            .person img {
                width: 440px;
                height: 566px;
                object-fit: cover;
                object-position: center;
                margin: 0 auto;
                display: block;
            }

            .person-info {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 12px;
                background: #fafafa;
                height: 100%;
                padding: 16px;
            }

            .title {
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 1px;
                color: #a37c40;
                text-transform: uppercase;
            }

            .name {
                font-size: 22px;
                font-weight: 700;
                color: #222;
            }

            .desc {
                font-size: 15px;
                color: #555;
                text-align: justify;
                overflow: hidden;
                max-height: 160px;
                transition: max-height 0.5s ease;
            }

            .desc.expanded {
                max-height: 800px;
            }

            .read-more-btn {
                position: relative;
                display: inline-flex;
                align-self: flex-start;
                padding: 6px 30px;
                border: 1px solid #333;
                color: #333;
                background: transparent;
                text-transform: uppercase;
                text-decoration: none;
                font-size: 14px;
                font-weight: 400;
                cursor: pointer;
                overflow: hidden;
                transition: color 0.35s ease;
                z-index: 0;
                /* button base */
            }

            .read-more-btn span {
                position: relative;
                z-index: 2;
                /* text above the sliding bg */
                pointer-events: none;
                /* ensure clicking text bubbles to button */
            }

            .read-more-btn::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 0;
                height: 100%;
                background: #141275;
                /* change to brand color if needed */
                transition: width 0.35s ease;
                z-index: 1;
                /* sits under text but above button base */
                pointer-events: none;
                /* overlay won't capture clicks */
            }

            .read-more-btn:hover {
                color: #fff;
            }

            .read-more-btn:hover::after {
                width: 100%;
            }




         @media (max-width: 900px) {
    .legacy-wrapper {
        padding-top: 20px;
    }

    .person {
        display: flex;
        flex-direction: column !important; /* Always image first, info after */
        text-align: center;
    }

    .person:nth-child(even) {
        direction: ltr !important; /* Reset rtl used on desktop */
    }

    .person img {
        width: 90%;
        height: auto;
        max-height: 500px;
        margin: 0 auto 20px; /* add space between image and text */
        order: 1; /* Image always comes first */
    }

    .person-info {
        order: 2; /* Info (desc + button) after image */
        text-align: left;
        background: #fafafa;
        padding: 16px;
    }

    .read-more-btn {
        width: auto;
        padding: 9px 20px;
        font-size: 15px;
        align-self: flex-start; /* Keep button aligned properly */
    }

    .read-more-btn span {
        pointer-events: none;
    }

    .desc {
        text-align: left;
    }
}


            /* ---------------- VIKAS BUILDERS ---------------- */
            .vision-section-wrapper {
                background: #fff;
                padding: 20px 0;
            }

            .vision-section {
                display: flex;
                align-items: center;
                justify-content: space-between;
                max-width: 1300px;
                margin: 80px auto;
                padding: 40px 20px;
                gap: 60px;
            }

            .carousel-container {
                position: relative;
                width: 55%;
                height: 460px;
                flex-shrink: 0;
            }

            .carousel-slide {
                position: absolute;
                width: calc(100% - 20px);
                height: calc(100% - 20px);
                opacity: 0;
                transition: opacity 0.8s ease-in-out;
                border-radius: 20px;
                overflow: hidden;
            }

            .carousel-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .carousel-slide.active {
                opacity: 1;
                z-index: 5;
                top: 20px;
                left: 20px;
            }

            .carousel-slide.background-1 {
                opacity: 1;
                z-index: 4;
                top: 10px;
                left: 10px;
            }

            .carousel-slide.background-2 {
                opacity: 1;
                z-index: 3;
                top: 0;
                left: 0;
            }

            .carousel-slide.hidden {
                opacity: 0;
                z-index: 2;
            }

            .carousel-navigation {
                position: absolute;
                bottom: -55px;
                left: 10px;
                z-index: 5;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .arrow {

                font-size: 22px;
                cursor: pointer;
                padding: 6px 14px;
                border-radius: 6px;

                transition: background 0.3s, transform 0.2s;

            }

            .arrow:hover {
                background: #f0f0f0;
                transform: scale(1.05);
            }

            .text-content {
                width: 45%;
                color: #444;
                opacity: 0;
                transform: translateY(30px);
                animation: fadeUp 1.5s ease forwards;
                animation-delay: 0.5s;
            }

            @keyframes fadeUp {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .text-content h2 {
                color: #38A2F8;
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 25px;
                line-height: 1.2;
            }

            .text-content p {
                font-size: 1rem;
                line-height: 1.7;
                margin-bottom: 18px;
                color: #555;
            }



            @media (max-width: 992px) {
                .vision-section {
                    flex-direction: column;
                    text-align: center;
                }

                .carousel-container,
                .text-content {
                    width: 100%;
                }

                .carousel-navigation {
                    position: relative;
                    bottom: 0;
                    left: 0;
                    justify-content: center;
                    margin-top: 20px;
                }
            }
        </style>
    @endpush

    {{-- ---------------- LEGACY HTML ---------------- --}}
    <div class="legacy-wrapper" v-pre x-data x-ignore>
        <h1>LEGACY</h1>
        <section class="legacy-section">
            <!-- Founder -->
            <div class="person">
                <img src="{{ asset('vendor/webkul/shop/assets/legacy1.webp') }}" alt="Sri Sardar Chand Narang">
                <div class="person-info">
                    <div class="title">FOUNDER</div>
                    <div class="name">Sri Sardar Chand Narang</div>
                    <p class="desc">
                        As the head of the family, SH. Sardar Chand Narang is at the helm of all affairs. Mr. Narang
                        single-handedly built his empire brick by brick. The family legacy dates back to 1905 in which
                        they were in the business of jewellery in Karachi and Rawalpindi. The family shifted to India in
                        1968 and started a new chapter in his life - Raj Jewellerz in Karol Bagh, New Delhi and to date
                        remains the rock of his kingdom. His versatility, diversity and dedication were few of his
                        qualities that propelled him on the path to success. With a knack for constant innovation, he
                        ceaselessly renewed and reinvented, lending vintage appeal to contemporary designs. A
                        manufacturer, a retailer, a craftsman – Shri S.C. Narang ji was a man of all seasons.

                        Fondly addressed as “Bauji” both by his staff and clients alike he would be at the Karol Bagh
                        store each day until his final innings in January 2020.
                    </p>
                    <button class="read-more-btn"><span> Read More</span></button>
                </div>
            </div>

            <!-- Director 1 -->
            <div class="person">
                <div class="person-info">
                    <div class="title">DIRECTOR</div>
                    <div class="name">Mr. Navnit Narang</div>
                    <p class="desc">
                        Mr Navniit Narrang, the elder son of late Mr S.C.Narang, is at the helm of Narang Legacy, a
                        pioneering brand in fine jewellery since 1968. Both pioneering and rooted in tradition, Navniit
                        Narrang, managing director joined the family enterprise at a young age of 18 and meticulously
                        honed his skills for years while gaining the industry wisdom of the business from his father. As
                        the person who is instrumental in steering the company towards growth and stability, Mr. Navneet
                        Narang expertly manages the operations of the firm. As the elder son of the family and with over
                        45 years of hands on experience in the trade, he has achieved success and has contributed
                        profoundly to the understanding of consumer aspirations. Driven by passion and deep love for
                        jewellery, Navniit Narrang travels extensively across the globe in his quest to be abreast with
                        latest international trends as he strategically drives Raj Jewellerz in world markets. From US
                        to Thailand to Middle East, he participates in leading international shows. As Navniit explores
                        the world through his frequent travels, he draws inspiration from his journeys to blend
                        traditional Indian style with contemporary style trends.
                    </p>
                    <button class="read-more-btn"><span> Read More</span></button>
                </div>
                <img src="{{ asset('vendor/webkul/shop/assets/legacy2.webp') }}" alt="Mr. Navnit Narang">
            </div>

            <!-- Director 2 -->
            <div class="person">
                <img src="{{ asset('vendor/webkul/shop/assets/legacy3.webp') }}" alt="Mr. Raman Narang">
                <div class="person-info">
                    <div class="title">DIRECTOR</div>
                    <div class="name">Mr. Raman Narang</div>
                    <p class="desc">
                        Mr. Raman Narang as the younger son of the family is a true reflection of his father’s inherent
                        qualities as he often spent time after school in his father’s workshop, closely observing the
                        art of jewellery making and comprehending the science behind it. With over 35 years of
                        experience he has spearheaded all financial and marketing activities and has attained extensive
                        and thorough knowledge of the trade. He reinforced his perseverance with a Gemology course from
                        GIA - Gemological Institute of America majoring in diamonds and coloured stones. Within a short
                        period of joining the business, Mr Raman Narang firmly established himself at the heart of it
                        swiftly mastering the ropes of the trade. A true visionary, he became one of the first few
                        people to introduce Certified Diamond Solitaires and gold hallmarking in the country. Today,
                        under his aegis, Raj Jewellerz is one of the most notable and respected brands with a marked
                        domestic and international presence. A keen jewellery designer himself, his flair for sculpting
                        and sketching has helped aid and evolve the standards of product and design. Under Raman’s
                        distinct leadership style, astute business acumen and an extraordinary eye for detail, RAJ
                        Legacy, has been rightly recognized and felicitated with numerous awards by the premium bodies
                        of the Jewellery Industry.
                    </p>
                    <button class="read-more-btn"><span> Read More</span></button>
                </div>
            </div>

            <!-- Associate Director -->
            <div class="person">
                <div class="person-info">
                    <div class="title">ASSOCIATE DIRECTOR</div>
                    <div class="name">Mr. Ishaan Narang</div>
                    <p class="desc">
                        Carrying forward the legacy as the third generation is the Associate Director, Mr. Ishaan
                        Narang. He is a certified gemologist from the world’s leading Gemological Institute of America
                        (GIA).

                        Ishaan has been responsible for international growth and has represented Raj Jewellerz at the
                        biggest jewellery exhibitions globally. Having acquired values, knowledge, and expertise from
                        both his grandfather and father, Ishaan has taken the legacy to new heights. Mr. Ishaan Narang
                        possesses an in-depth understanding of gemstone properties, grading methodologies, and industry
                        best practices. His comprehensive knowledge of various gems, their origins, and characteristics
                        enables him to curate captivating and unique jewellery pieces that resonate with our discerning
                        clientele. From sourcing rare and exquisite gemstones to ensuring their authenticity and optimal
                        presentation, Ishaan’s ability to integrate gemstones seamlessly into intricate designs ensures
                        that every piece we offer is a testament to both aesthetic elegance and technical excellence.

                        With an impeccable eye for detail and an unwavering passion for his craft, Ishaan Narang creates
                        fine jewellery designed to captivate the hearts of the young millennial and gen-z clientele and
                        is the creative force behind the brand.
                    </p>
                    <button class="read-more-btn"><span> Read More</span></button>
                </div>
                <img src="{{ asset('vendor/webkul/shop/assets/legacy4.webp') }}" alt="Mr. Ishaan Narang">
            </div>
        </section>
    </div>

    {{-- ---------------- VIKAS BUILDERS ---------------- --}}
    <div class="vision-section-wrapper" v-pre x-data x-ignore>
        <div class="vision-section">
            <div class="carousel-container">
                <div class="carousel-slide">
                    <img src={{ asset('vendor/webkul/shop/assets/store.webp') }} alt="Design Image 1">
                </div>
                <div class="carousel-slide">
                    <img src={{ asset('vendor/webkul/shop/assets/store2.webp') }} alt="Design Image 2">
                </div>
                <div class="carousel-slide">
                    <img src={{ asset('vendor/webkul/shop/assets/store3.webp') }} alt="Design Image 3">
                </div>
                <div class="carousel-slide">
                    <img src={{ asset('vendor/webkul/shop/assets/store4.webp') }} alt="Design Image 4">
                </div>

                <div class="carousel-navigation">
                    <button class="arrow prev">&#8592;</button>
                    <button class="arrow next">&#8594;</button>
                </div>
            </div>

            <div class="text-content">
                <h2>Your Vision, Our Design Expertise</h2>
                <p>History Lives Through a Name - A Journey through the Years
                </p>
                <p>The history of RAJ JEWELLERZ BY NARANG GROUP traces the evolution of modern jewellery as it
                    transformed from the elaborate and ornate designs in Gold, Polki & Diamond jewellery, when the firm
                    was founded, to the more modern, sinous styles that are the firm's trademark today. Narang family
                    has been in the trade of jewellery since 1905 in Karachi. Under the able guidance of Sh. S.C.
                    Narang, Narang Raj Jewellers opened its doors in 1968 in the heart of New Delhi in Karol Bagh and
                    has been serving customers for over 55 years and has emerged as a name synonymous with trust,
                    superlative quality, years of expertise and personal attention to customers has propelled the firm
                    on the path to success.</p>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function initializeLegacyPage() {
                console.log("Attempting to initialize legacy page script...");

                // --- READ MORE using Event Delegation ---
                const legacyWrapper = document.querySelector('.legacy-wrapper');
                console.log("Legacy Wrapper Element:", legacyWrapper); // Diagnostic log

                if (legacyWrapper) {
                    legacyWrapper.addEventListener('click', (event) => {
                        // Find the closest read-more button whether user clicked the span or the button
                        const btn = event.target.closest('.read-more-btn');

                        // Exit if the click wasn't inside a read-more-btn
                        if (!btn || !legacyWrapper.contains(btn)) return;

                        // Toggle the description
                        const desc = btn.closest('.person-info').querySelector('.desc');
                        if (!desc) return;

                        desc.classList.toggle('expanded');

                        // Update the text inside the span (preserves structure & animations)
                        const labelSpan = btn.querySelector('span');
                        if (labelSpan) {
                            labelSpan.textContent = desc.classList.contains('expanded') ? "Read Less" : "Read More";
                        } else {
                            // Fallback if span absent
                            btn.textContent = desc.classList.contains('expanded') ? "Read Less" : "Read More";
                        }
                    });

                } else {
                    console.error("Could not find the '.legacy-wrapper' element.");
                }

                // --- CAROUSEL ---
                const container = document.querySelector('.carousel-container');
                console.log("Carousel Container Element:", container); // Diagnostic log

                if (container) {
                    const slides = container.querySelectorAll('.carousel-slide');
                    const nextBtn = container.querySelector('.next');
                    const prevBtn = container.querySelector('.prev');
                    let currentIndex = 0;
                    const totalSlides = slides.length;
                    let interval;

                    if (totalSlides === 0) {
                        console.error("Carousel found, but no '.carousel-slide' elements inside.");
                        return;
                    }

                    function showSlide(index) {
                        currentIndex = (index + totalSlides) % totalSlides;
                        slides.forEach((slide, i) => {
                            slide.classList.remove('active', 'background-1', 'background-2', 'hidden');
                            if (i === currentIndex) slide.classList.add('active');
                            else if (i === (currentIndex + 1) % totalSlides) slide.classList.add('background-1');
                            else if (i === (currentIndex + 2) % totalSlides) slide.classList.add('background-2');
                            else slide.classList.add('hidden');
                        });
                    }

                    function nextSlide() {
                        showSlide(currentIndex + 1);
                    }

                    function prevSlide() {
                        showSlide(currentIndex - 1);
                    }

                    function startCarousel() {
                        stopCarousel(); // Ensure no multiple intervals are running
                        interval = setInterval(nextSlide, 3500);
                    }

                    function stopCarousel() {
                        clearInterval(interval);
                    }

                    if (nextBtn && prevBtn) {
                        nextBtn.addEventListener('click', () => {
                            stopCarousel();
                            nextSlide();
                            startCarousel();
                        });
                        prevBtn.addEventListener('click', () => {
                            stopCarousel();
                            prevSlide();
                            startCarousel();
                        });
                    } else {
                        console.error("Carousel navigation buttons (.next/.prev) not found.");
                    }


                    showSlide(0);
                    startCarousel();
                } else {
                    console.error("Could not find the '.carousel-container' element.");
                }
            }

            // Use setTimeout to delay execution until after Vue has finished rendering.
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(initializeLegacyPage, 0);
            });
        </script>
    @endpush
</x-shop::layouts>
