import './bootstrap';
import './dashboard';

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Alpine = Alpine;

Alpine.start();

Swiper.use([Navigation, Pagination, Autoplay]);


const heroSwiper = new Swiper('.heroSwiper', {
    loop: true,
    effect: 'fade',
    speed: 800,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
    },
    pagination: {
        el: '.swiper-pagination-custom',
        clickable: true,
        renderBullet: function (index, className) {
            return `<span class="${className} w-2.5 h-2.5 rounded-full bg-white/40 hover:bg-white/70 transition cursor-pointer [&.swiper-pagination-bullet-active]:bg-lime-400 [&.swiper-pagination-bullet-active]:w-6"></span>`;
        },
    },
});
