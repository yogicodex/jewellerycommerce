document.addEventListener('DOMContentLoaded', () => {
    // --- READ MORE BUTTONS ---
    document.querySelectorAll('.read-more-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const desc = btn.closest('.person-info').querySelector('.desc');
            desc.classList.toggle('expanded');
            btn.textContent = desc.classList.contains('expanded') ? "Read Less" : "Read More";
        });
    });

    // --- CAROUSEL ---
    const container = document.querySelector('.carousel-container');
    if (!container) return;

    const slides = container.querySelectorAll('.carousel-slide');
    const nextBtn = container.querySelector('.next');
    const prevBtn = container.querySelector('.prev');
    let currentIndex = 0;
    const totalSlides = slides.length;
    let interval;

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

    function nextSlide() { showSlide(currentIndex + 1); }
    function prevSlide() { showSlide(currentIndex - 1); }

    function startCarousel() { interval = setInterval(nextSlide, 3500); }
    function stopCarousel() { clearInterval(interval); }

    nextBtn.addEventListener('click', () => { stopCarousel(); nextSlide(); startCarousel(); });
    prevBtn.addEventListener('click', () => { stopCarousel(); prevSlide(); startCarousel(); });

    showSlide(0);
    startCarousel();
});
