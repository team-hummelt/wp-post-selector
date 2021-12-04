document.addEventListener('DOMContentLoaded', function () {

    let wow = new WOW(
        {
            boxClass: 'wow',      // animated element css class (default is wow)
            animateClass: 'animate__animated', // animation css class (default is animated)
            offset: 0,          // distance to the element when triggering the animation (default is 0)
            mobile: true,       // trigger animations on mobile devices (default is true)
            live: true,       // act on asynchronously loaded content (default is true)
            callback: function (box) {
                // the callback is fired every time an animation is started
                // the argument that is passed in is the DOM node being animated
            },
            scrollContainer: null,    // optional scroll container selector, otherwise use window,
            resetAnimation: true,     // reset animation on end (default is true)
        }
    );
    wow.init();

    let siteGalerie = document.querySelector('.top-button');
    let slideGalerie = document.getElementById('blueimp-gallery-slides');
    if (!slideGalerie) {

        let html = `
   <div id="blueimp-gallery-slides"
     class="blueimp-gallery blueimp-gallery-controls"
     aria-label="image gallery"
     aria-modal="true"
     role="dialog">
    <div class="slides" aria-live="polite"></div>
    <h3 class="title text-white fs-4"></h3>
    <a class="prev"
       aria-controls="blueimp-gallery"
       aria-label="previous slide"
       aria-keyshortcuts="ArrowLeft">
    </a>
    <a class="next"
       aria-controls="blueimp-gallery"
       aria-label="next slide"
       aria-keyshortcuts="ArrowRight">
    </a>
    <a class="close"
       aria-controls="blueimp-gallery"
       aria-label="close"
       aria-keyshortcuts="Escape">
    </a>
    <a class="play-pause"
       aria-controls="blueimp-gallery"
       aria-label="play slideshow"
       aria-keyshortcuts="Space"
       aria-pressed="false"
       role="button">
    </a>
    <ol class="indicator"></ol>
    </div>`;
        if (siteGalerie) {
            siteGalerie.insertAdjacentHTML('afterend', html);
        }

    }

    let singleGalerie = document.getElementById('blueimp-gallery-single');
    if (!singleGalerie) {
        let html = `
   <div id="blueimp-gallery-single"
     class="blueimp-gallery blueimp-gallery-controls"
     aria-label="image gallery"
     aria-modal="true"
     role="dialog">
    <div class="slides" aria-live="polite"></div>
    <h3 class="title text-white fs-4"></h3>
    <a class="close"
       aria-controls="blueimp-gallery"
       aria-label="close"
       aria-keyshortcuts="Escape">
    </a>
    </div>`;
        if (siteGalerie) {
            siteGalerie.insertAdjacentHTML('afterend', html);
        }
    }

    let splideImgContainer = document.querySelectorAll('.splide');
    if (splideImgContainer) {
        let splideNode = Array.prototype.slice.call(splideImgContainer, 0);
        splideNode.forEach(function (splideNode) {
            // console.log(splideNode.clientWidth)
            let splideRand = splideNode.getAttribute('data-rand');
            let splideId = splideNode.getAttribute('data-id');
            set_new_splide_instance_settings(splideRand, splideId);
        });

        /**============================================
         ========== SLIDER AJAX DATEN SENDEN ==========
         ==============================================
         */
        function set_new_splide_instance_settings(rand, slideId) {
            let xhr = new XMLHttpRequest();
            let formData = new FormData();
            xhr.open('POST', ps_ajax_obj.ajax_url, true);
            formData.append('_ajax_nonce', ps_ajax_obj.nonce);
            formData.append('action', 'PostSelHandlePublic');
            formData.append('method', 'get_slider_settings');
            formData.append('id', slideId);
            formData.append('rand', rand);
            xhr.send(formData);
            //Response
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    let data = JSON.parse(this.responseText);
                    if (data.status) {
                        let settings = data.sendSettings;
                        new Splide('.splide.splide' + rand, {
                            arrows: settings.arrows,
                            autoHeight: settings.autoHeight,
                            autoWidth: settings.autoWidth,
                            autoplay: settings.autoplay,
                            cover: settings.cover,
                            drag: settings.drag,
                            flickPower: settings.flickPower,
                            focus: settings.focus,
                            gap: settings.gap,
                            height: settings.height,
                            heightRatio: settings.heightRatio,
                            interval: settings.interval,
                            keyboard: settings.keyboard,
                            lazyLoad: settings.lazyLoad,
                            pagination: settings.pagination,
                            pauseOnFocus: settings.pauseOnFocus,
                            pauseOnHover: settings.pauseOnHover,
                            perMove: settings.perMove,
                            perPage: settings.perPage,
                            preloadPages: settings.preloadPages,
                            rewind: settings.rewind,
                            rewindSpeed: settings.rewindSpeed,
                            slideFocus: settings.slideFocus,
                            speed: settings.speed,
                            start: settings.start,
                            type: settings.type,
                            width: settings.width,
                            trimSpace: settings.trimSpace,
                            breakpoints: {
                                1400: {
                                    perPage: settings.perPageXxl,
                                    gap: settings.gapXxl,
                                    height: settings.heightXxl,
                                    width: settings.widthXxl
                                },
                                1200: {
                                    perPage: settings.perPageXl,
                                    gap: settings.gapXl,
                                    height: settings.heightXl,
                                    width: settings.widthXl
                                },
                                992: {
                                    perPage: settings.perPageLg,
                                    gap: settings.gapLg,
                                    height: settings.heightLg,
                                    width: settings.widthLg
                                },
                                768: {
                                    perPage: settings.perPageMd,
                                    gap: settings.gapMd,
                                    height: settings.heightMd,
                                    width: settings.widthMd
                                },
                                576: {
                                    perPage: settings.perPageSm,
                                    gap: settings.gapSm,
                                    height: settings.heightSm,
                                    width: settings.widthSm
                                },
                                450: {
                                    perPage: settings.perPageXs,
                                    gap: settings.gapXs,
                                    height: settings.heightXs,
                                    width: settings.widthXs
                                },
                            }
                        }).mount();
                    }
                }
            }
        }
    }

    let postSelectorGrid = document.querySelectorAll(".post-selector-grid");
    if (postSelectorGrid) {
        let msnry;
        let gridNodes = Array.prototype.slice.call(postSelectorGrid, 0);
        gridNodes.forEach(function (gridNodes) {
            imagesLoaded(gridNodes, function () {
                msnry = new Masonry(gridNodes, {
                    itemSelector: '.grid-item',
                    percentPosition: true
                });
            });
        });
    }

    let blueImpLightbox = document.querySelectorAll(".light-box-controls");
    if (blueImpLightbox) {
        let lightBoxNodes = Array.prototype.slice.call(blueImpLightbox, 0);
        lightBoxNodes.forEach(function (lightBoxNodes) {
            lightBoxNodes.addEventListener("click", function (e) {
                let target = e.target
                let link = target.src ? target.parentNode : target;
                let control = link.getAttribute('data-control');
                if (!control) {
                    return false;
                }
                let options;
                switch (control) {
                    case 'control':
                        options = {
                            container: '#blueimp-gallery-slides',
                            index: link,
                            event: e,
                            toggleControlsOnSlideClick: false,
                        }
                        break;
                    case 'single':
                        options = {
                            container: '#blueimp-gallery-single',
                            index: link,
                            event: e,
                            enableKeyboardNavigation: false,
                            emulateTouchEvents: false,
                            fullscreen: false,
                            displayTransition: false,
                            toggleControlsOnSlideClick: false,
                        }
                        break;
                }
                let links = this.querySelectorAll('a.img-link')
                blueimp.Gallery(links, options)
            });
        });
    }


    const imageObserver = new IntersectionObserver((entries, imgObserver) => {
        entries.forEach((entry) => {

            if (entry.isIntersecting) {
                const lazyImage = entry.target
                lazyImage.src = lazyImage.dataset.src
                lazyImage.classList.remove("lazy-image");
                imgObserver.unobserve(lazyImage);
            }
        })
    });

    const postImgArr = document.querySelectorAll('img.lazy-image');
    if (postImgArr) {
        postImgArr.forEach((postImg) => {
            imageObserver.observe(postImg);
        });
    }
});
