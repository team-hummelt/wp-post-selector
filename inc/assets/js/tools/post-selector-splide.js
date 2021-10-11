document.addEventListener('DOMContentLoaded', function () {

    if (!document.getElementsByClassName('splide').length) {
        return false;
    }

    let splideImgContainer = document.querySelectorAll('.splide');
    let splideNode = Array.prototype.slice.call(splideImgContainer, 0);

    splideNode.forEach(function (splideNode) {
        console.log(splideNode.clientWidth)
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
        xhr.open('POST', public_ajax_obj.ajax_url, true);
        formData.append('_ajax_nonce', public_ajax_obj.nonce);
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
});
