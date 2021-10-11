/*jshint esversion: 6 */
document.addEventListener('DOMContentLoaded', function() {
  if (!document.getElementsByClassName('splide').length) {
    return false;
  }

  new Splide('.splide', {
    type: 'loop',
    autoplay: true,
    interval: 3000,
    width: '100%',
    perPage: 5,
    cover: true,
    height: '300px',
    trimSpace: true,
    autoWidth: false,
    focus: 'center',
    gap: '4rem',
    breakpoints: {
      1400: {
        perPage: 4,
      },
      991: {
        perPage: 3,
      },
      768: {
        perPage: 2,
      },
      450: {
        perPage: 1,
      },
    }
  }).mount();
});
