const carousel = document.querySelector('.carousel');
const slides = document.querySelectorAll('.slide');

let currentSlide = 0;

function moveSlide(index){
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

setInterval(() => {

    currentSlide++;

    if(currentSlide >= slides.length){
        currentSlide = 0;
    }

    moveSlide(currentSlide);

}, 5000);