const carousel = document.querySelector('.carousel');
const slides = document.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentSlide = 0;
let autoPlayTimer;

function moveSlide(index) {
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }
    
    carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function startAutoPlay() {
    autoPlayTimer = setInterval(() => {
        moveSlide(currentSlide + 1);
    }, 5000);
}

function resetAutoPlay() {
    clearInterval(autoPlayTimer);
    startAutoPlay();
}

if (nextBtn) {
    nextBtn.addEventListener('click', () => {
        moveSlide(currentSlide + 1);
        resetAutoPlay();
    });
}

if (prevBtn) {
    prevBtn.addEventListener('click', () => {
        moveSlide(currentSlide - 1);
        resetAutoPlay();
    });
}

startAutoPlay();