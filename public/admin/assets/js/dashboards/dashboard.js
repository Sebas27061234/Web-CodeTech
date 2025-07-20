document.addEventListener("DOMContentLoaded", function () {
  $(".counter-carousel").owlCarousel({
    loop: true,
    rtl: false,
    margin: 30,
    mouseDrag: false,
    dots: false,
    nav: true,
    navText: ['<i class="ti ti-chevron-left"></i>','<i class="ti ti-chevron-right"></i>'],
    responsive: {
      0: {
        items: 2,
        loop: true,
      },
      576: {
        items: 2,
        loop: true,
      },
      768: {
        items: 2,
        loop: true,
      },
      1200: {
        items: 2,
        loop: true,
      },
      1400: {
        items: 2,
        loop: true,
      },
    },
  });
});