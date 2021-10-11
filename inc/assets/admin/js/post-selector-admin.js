


jQuery(document).ready(function ($) {
    let ajaxFormSpinner = document.querySelectorAll(".ajax-status-spinner");

    /**================================================
     ========== TOGGLE FORMULAR COLLAPSE BTN  ==========
     ===================================================
     */
    let pstSelectorColBtn = document.querySelectorAll("button.btn-post-collapse");
    if (pstSelectorColBtn) {
        let postCollapseEvent = Array.prototype.slice.call(pstSelectorColBtn, 0);
        postCollapseEvent.forEach(function (postCollapseEvent) {
            postCollapseEvent.addEventListener("click", function () {
                if (ajaxFormSpinner) {
                    let spinnerNodes = Array.prototype.slice.call(ajaxFormSpinner, 0);
                    spinnerNodes.forEach(function (spinnerNodes) {
                        spinnerNodes.innerHTML = '';
                    });
                }
                this.blur();
                if (this.classList.contains("active")) return false;
                let siteTitle = document.getElementById("currentSideTitle");
                siteTitle.innerText = this.getAttribute('data-site');

                remove_active_btn();
                this.classList.add('active');
                this.setAttribute('disabled', true);
            });
        });

        function remove_active_btn() {
            for (let i = 0; i < postCollapseEvent.length; i++) {
                postCollapseEvent[i].classList.remove('active');
                postCollapseEvent[i].removeAttribute('disabled');
            }
        }
    }
    $(document).on('submit', '.send-jquery-ajax-modal-formular', function (event) {
        let form_data = $(this).serializeObject();
        send_jquery_post_form_data(form_data);
        return false;
    });


    /**=======================================================
     ================ BTN SEND SUBMIT FORMULAR ================
     ==========================================================
     */
    $(document).on('submit', '.send-bs-form-jquery-ajax-formular', function (event) {

        $('#modalAction').val('PostSelHandle');
        $('#modalNonce').val(ps_ajax_obj.nonce);
        let form_data = $(this).serializeObject();
        send_jquery_post_form_data(form_data);
        return false;
    });

    function send_jquery_post_form_data(form_data) {
        $.ajax({
            url: ps_ajax_obj.ajax_url,
            type: "POST",
            data: form_data,
            success: function (data) {
                if(data.reset){
                    $(".send-bs-form-jquery-ajax-formular").trigger("reset");
                }
                if (data.status && data.msg) {
                    if(data.load_toast){
                        slider_toasts_template(data.load_toast);
                        $('.load-slider-temp').prop('disabled', false);
                    }
                    success_message(data.msg);
                } else {
                    warning_message(data.msg);
                }
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        return false;
    }


    /**=================================================
     ================ DELETE POST ITEMS ================
     ===================================================
     */
    $(document).on('click', ".btn-delete-items", function () {
        $.post(ps_ajax_obj.ajax_url, {
            '_ajax_nonce': ps_ajax_obj.nonce,
            'action': 'PostSelHandle',
            method: $(this).attr('data-method'),
            id:$(this).attr('data-id'),
            type:$(this).attr('data-type'),
        }, function (data) {
            if (data.status) {
              $('#slider'+data.id).remove();
            } else {
                if(data.msg){
                    warning_message(data.msg);
                }
            }
        })
    });

    /**===================================================
     ================ TOGGLE SWITCH LABEL ================
     =====================================================
     */
    $(document).on('click', "#checkHover", function () {
        let label = $('#labelCheck');
        if($(this).prop('checked')){
            label.attr('disabled', 'disabled');
        } else {
            label.prop('disabled',false);
        }
    });

    /**================================================
     ================ BTN TOGGLE AKTIV ================
     ==================================================
     */
    $(document).on('click', ".btn-toggle-active", function () {
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            $('.btn-txt', this).text('Breakpoints ausblenden')
        } else {
            $('.btn-txt', this).text('Breakpoints einblenden')
        }
    });


    /**==========================================
     ================ CHECK BLUR ================
     ============================================
     */
    $(document).on('click', ".form-check-input", function () {
        $(this).blur();
    });

    /**=========================================================
     ================ LOAD SLIDER EDIT TEMPLATE ================
     ===========================================================
     */
    $(document).on('click', ".load-slider-temp-edit", function () {
        load_slider_data($(this).attr('data-id'), $(this).attr('data-type'));
    });
    /**==============================================
     ================ BTN LOAD TOASTS ================
     ================================================
     */
    $(document).on('click', ".load-slider-data", function () {
        load_slider_data();
    });

    load_slider_data();
    function load_slider_data(id= false, type = false){
        $.post(ps_ajax_obj.ajax_url, {
            '_ajax_nonce': ps_ajax_obj.nonce,
            'action': 'PostSelHandle',
            method: 'get_slider_data',
            id:id,
            type:type
        }, function (data) {
            let addSliderBtn = $('.load-slider-temp');
            if (data.status) {
                if (data.load_toast){
                    slider_toasts_template(data.record);
                    addSliderBtn.prop('disabled', false);
                }
                if(data.load_template){
                    slider_form_template(data.record, data.type, data.id);
                    addSliderBtn.prop('disabled', true);
                }
            } else {
                if(data.msg){
                    warning_message(data.msg);
                }
            }
        });
    }

    /**==============================================
     ================ BTN ADD SLIDER ================
     ================================================
     */
    $(document).on('click', ".load-slider-temp", function () {
        slider_form_template('', $(this).attr('data-type'));
    });

    function slider_form_template(data = false, type=false, id = ''){

        let sld;
        data ? sld = data.data : sld = '';
       let html = `
        <div class="d-flex flex-wrap">
        <div>
        <h5 class="mb-0">${data ? 'Slider bearbeiten' : 'neuen Slider erstellen'}</h5>
        <div class="form-text">Die Bedeutung der einzelnen Optionen können <a target="_blank" class="text-decoration-none" href="https://splidejs.com/guides/options/"> hier</a> nachgelesen werden.</div>
       </div>
        <div class="ms-auto">
         <i class="load-slider-data rounded-close cursor-pointer p-2 fa fa-times"></i>   
        </div>
        </div>
        <hr>
       
        <div id="slideWrapper" class="slide-wrapper">
        <form class="send-bs-form-jquery-ajax-formular" action="#" method="post">
        <input type="hidden" name="type" value="${type}">
        <input type="hidden" name="method" value="slider-form-handle">
        <input type="hidden" name="id" value="${id}">
        <input type="hidden" name="action" value="PostSelHandle">
        <input type="hidden" name="_ajax_nonce" value="${ps_ajax_obj.nonce}">
        <div class="slide-item">
        <div class="row">
        <div class="col-md-6  col-xl-6 mb-3">
        <label for="InputBezeichnung" class="form-label">Bezeichnung <span class="text-danger">*</span> </label>
        <input type="text" name="bezeichnung" value="${data ? data.bezeichnung : ''}" class="form-control" id="InputBezeichnung" required>
        </div> 
        </div>
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Der Typ des Schiebereglers."
        for="selectTypeLabel" class="form-label">Type <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <select class="form-select flex-fill" name="slide_type" id="selectTypeLabel" >
        <option value="">auswählen...</option>
        <option value="loop"${sld ? sld.slide_type == 'loop' ? 'selected' : '' : 'selected'}>loop</option>
        <option value="slide" ${sld && sld.slide_type == 'slide' ? 'selected' :''}>slide</option>
        <option value="fade" ${sld && sld.slide_type == 'fade' ? 'selected' :''}>fade</option>
        </select>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
                title="Bestimmt die Anzahl der Folien, die gleichzeitig verschoben werden sollen."
        for="InputMove" class="form-label">Pro Move 
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" placeholder="z.B. 3" value="${sld ? sld.pro_move  ? sld.pro_move : '' : '1'}" name="pro_move" class="form-control"
        id="InputMove">
        </div>
        </div>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
                title="Bestimmt die Anzahl der auf einer Seite anzuzeigenden Folien."
        for="InputPage" class="form-label">per Page
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" value="${sld ? sld.pro_page  ? sld.pro_page : '' : '4'}" name="pro_page" placeholder="z.B. 5"
        class="form-control"
        id="InputPage">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
                title="Die Lücke zwischen den Folien. Das CSS-Format ist akzeptabel, z. B. 1em."
        for="InputGap" class="form-label">Gap
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="gap" value="${sld ? sld.gap  ? sld.gap : '' : '0.3rem'}" placeholder="z.B. 4rem" class="form-control" id="InputGap">
        </div>
        </div>
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
       <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Definiert die maximale Breite des Schiebereglers und akzeptiert das CSS-Format wie 10em, 80vw."
        for="InputBreite" class="form-label">Breite
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="width" value="${sld ? sld.width  ? sld.width : '' : '100%'}" placeholder="z.B. 100%" class="form-control" id="InputBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Definiert die Folienhöhe und akzeptiert das CSS-Format mit Ausnahme von %."
        for="InputHeight" class="form-label">Höhe
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="height" value="${sld ? sld.height  ? sld.height : '' : '250px'}" placeholder="z.B. 300px" class="form-control" id="InputHeight">
        </div>
        </div>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-3 mb-3">

       <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Die Dauer des Autoplay-Intervalls in Millisekunden."
        for="InputInterval" class="form-label">Intervall
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="intervall" value="${sld ? sld.intervall  ? sld.intervall : '' : '3000'}" placeholder="z.B. 3000" class="form-control" id="InputInterval">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, welche Folie aktiv sein soll, wenn der Schieberegler mehrere Folien auf einer Seite enthält."
        for="InputFocus" class="form-label">Focus
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="focus" value="${sld ? sld.focus  ? sld.focus : '' : 'center'}" placeholder="z.B. center" class="form-control" id="InputFocus">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob Leerzeichen vor/nach dem Schieberegler gekürzt werden sollen, wenn die focus Option verfügbar ist."
        for="selectTrimSpace" class="form-label">Trim Space 
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <select class="form-select flex-fill" name="trim_space" id="selectTrimSpace" >
        <option value="move"${sld ? sld.trim_space == 'move' ? 'selected' : '' : ''}>move</option>
        <option value="true" ${sld && sld.trim_space == 'true' ? 'selected' : 'selected'}>true</option>
        <option value="false" ${sld && sld.trim_space == 'false' ? 'selected' :''}>false</option>
        </select>
        </div>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="sequential: Lädt Bilder nacheinander | nearby: Startet das Laden nur von Bildern um die aktive Folie (Seite) | false: Deaktiviert Lazy Loading."
        for="selectLacyLoad" class="form-label">lazy Load
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <select class="form-select flex-fill" name="lazy_load" id="selectLacyLoad" >
        <option value="sequential"${sld ? sld.lazy_load == 'sequential' ? 'selected' : '' : 'selected'}>sequential</option>
        <option value="nearby" ${sld && sld.lazy_load == 'nearby' ? 'selected' :''}>nearby</option>
        <option value="false" ${sld && sld.lazy_load == 'false' ? 'selected' :''}>false</option>
        </select>
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Korrigiert die Breite der Folien und akzeptiert das CSS-Format. Der Schieberegler ignoriert die perPage Option, wenn Sie diesen Wert angeben."
        for="InputFixedWidth " class="form-label">fixed Width
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="fixed_width" value="${sld ? sld.fixed_width  ? sld.fixed_width : '' : ''}" placeholder="z.B. 10rem" class="form-control" id="InputFixedWidth">
        </div>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Korrigiert die Höhe von Folien und akzeptiert das CSS-Format außer %. Der Schieberegler ignoriert height und heightRatio Optionen, wenn Sie diesen Wert angeben."
        for="InputFixedHeight" class="form-label">fixed Height
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="fixed_height" value="${sld ? sld.fixed_height  ? sld.fixed_height : '' : ''}" placeholder="z.B. 6rem" class="form-control" id="InputFixedHeight">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Die Übergangsgeschwindigkeit in Millisekunden. Wenn 0, springt der Slider sofort zur Zielfolie."
        for="InputSpeed" class="form-label">Speed
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="speed" value="${sld ? sld.speed  ? sld.speed : '' : '500'}" 
        placeholder="z.B. 400" class="form-control" id="InputSpeed">
        </div>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Die Übergangsgeschwindigkeit beim Zurückspulen in Millisekunden. Der speed Wert wird als Standard verwendet."
        for="InputrewindSpeed" class="form-label">Rewind Speed
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="rewind_speed" value="${sld ? sld.rewind_speed  ? sld.rewind_speed : '' : '1000'}" 
        placeholder="z.B. 1000" class="form-control" id="InputrewindSpeed">
        </div>
        </div>
        
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Bestimmt die Höhe der Folien durch das Verhältnis zur Breite des Schiebereglers. Wenn beispielsweise die Breite des Schiebereglers 1000 und das Verhältnis gleich 0.3 ist, ist die Höhe 300.
               der Slider ignoriert diese Option, wenn height oder fixedHeight bereitgestellt werden."
        for="InputHeightRatio" class="form-label">Height Ratio
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="text" name="height_ratio" value="${sld ? sld.height_ratio  ? sld.height_ratio : '' : ''}" 
        placeholder="z.B. 0.3" class="form-control" id="InputHeightRatio ">
        </div>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Definiert den Startindex."
        for="InputStartIndex" class="form-label">start Index
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="start_index" value="${sld ? sld.start_index ? sld.start_index : '' : '1'}" 
        placeholder="z.B. 1" class="form-control" id="InputStartIndex">
        </div>

        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title='Bestimmen Sie die Leistung von "Flick". Je größer die Zahl ist, desto weiter läuft der Schieberegler. Etwa 500 wird empfohlen.'
        for="InputflickPower" class="form-label">flick Power
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="flick_power" value="${sld ? sld.flick_power  ? sld.flick_power : '' : '500'}" 
        placeholder="z.B. 600" class="form-control" id="InputflickPower">
        </div>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legen Sie vorher fest, wie viele Seiten (nicht Folien) um die aktive Folie herum geladen werden sollen. Dies funktioniert nur, wenn die lazyLoad Option 'nearby' ist."
        for="InputPreloadPages" class="form-label">preload Pages
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <input type="number" name="preload_pages" value="${sld ? sld.preload_pages  ? sld.preload_pages : '' : 1}" 
        placeholder="z.B. 1" class="form-control" id="InputPreloadPages">
        </div>

        </div>
        
        <hr>
        <div class="row pt-3">
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label class="form-label">Autoplay</label>
        <div class="form-check form-switch">
        <input class="form-check-input"  name="autoplay" type="checkbox" 
        role="switch" id="checkAutoplay" ${sld ? sld.autoplay  ? 'checked' : '' : 'checked'} >
        <label class="form-check-label"
        for="checkAutoplay">aktiv</label>
        </div>
        </div>
         <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Konvertiert das Bild src in die CSS- background-image URL des übergeordneten Elements. Dies erfordert height, fixedHeight oder heightRatio Option."
        for="InputFocus" class="form-label">Cover
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="cover" type="checkbox" 
        role="switch" id="checkCover" ${sld ? sld.cover  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="checkCover">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob der Schieberegler zurückgespult wird oder nicht. Dies funktioniert nicht im Loop-Modus."
        for="InputFocus" class="form-label">Rewind
        <i class="fa fa-info-circle font-blue cursor-pointer"> 
        </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="rewind" type="checkbox" 
        role="switch" id="rewindCheck" ${sld && sld.rewind ? 'checked' : ''}>
        <label class="form-check-label"
        for="rewindCheck">aktiv</label>
        </div>
        </div>
   
        
       <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
       <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Wenn aktiv wird die Breite der Folien durch ihre Breite bestimmt. Die Optionen per Page und per Move sollten 1 sein."
        for="selectTrimSpace" class="form-label">auto Width 
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="auto_width" type="checkbox" 
        role="switch" id="checkAutoWidth" ${sld ? sld.auto_width  ? 'checked' : '' : ''}>
        <label class="form-check-label"
        for="checkAutoWidth">aktiv</label>
        </div>
        </div>
         <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Wenn aktiv, wird die Höhe der Folien durch ihre Höhe bestimmt. Die Optionen per Page und per Move sollten 1 sein."
         class="form-label">auto Height 
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="auto_height" type="checkbox" 
        role="switch" id="checkAutoHeight" ${sld ? sld.auto_height  ? 'checked' : '' : ''}>
        <label class="form-check-label"
        for="checkAutoHeight">aktiv</label>
        </div>
        </div>
         <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Bestimmt, ob Pfeile (Bedienelemente) erstellt werden oder nicht."
        class="form-label">Arrows
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="arrows" type="checkbox" 
        role="switch" id="checkArrows" ${sld ? sld.arrows  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="checkArrows">aktiv</label>
        </div>
        </div>
        </div>
        
        <div class="row pt-3">     
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob die automatische Wiedergabe bei Mouseover angehalten wird."
        class="form-label">Pause On Hover
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="pause_on_hover" type="checkbox" 
        role="switch" id="pauseOnHover" ${sld ? sld.pause_on_hover  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="pauseOnHover">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob die automatische Wiedergabe bei Mouseover angehalten wird."
        class="form-label">Pause On Focus
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="pause_on_focus" type="checkbox" 
        role="switch" id="pauseOnFocus" ${sld ? sld.pause_on_focus  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="pauseOnFocus">aktiv</label>
        </div>
        </div>
  
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob der Benutzer den Schieberegler ziehen darf oder nicht."
        class="form-label">Drag
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="drag" type="checkbox" 
        role="switch" id="checkDrag" ${sld ? sld.drag  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="checkDrag">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob Tastenkombinationen aktiviert werden sollen oder nicht. Wenn aktiviert, können Sie den Schieberegler mit den Pfeiltasten steuern. Dies muss für die Barrierefreiheit aktiviert werden."
        class="form-label">Keyboard
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="keyboard" type="checkbox" 
        role="switch" id="keyboardCheck"${sld ? sld.keyboard  ? 'checked' : '' : 'checked'} >
        <label class="form-check-label"
        for="keyboardCheck">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title="Legt fest, ob eine Seitennummerierung (Indikatorpunkte) erstellt werden soll oder nicht."
        class="form-label">Pagination
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="pagination" type="checkbox" 
        role="switch" id="paginationCheck"${sld ? sld.pagination  ? 'checked' : '' : 'checked'} >
        <label class="form-check-label"
        for="paginationCheck">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label 
        data-bs-toggle="tooltip" data-bs-placement="top" 
        title='Legt fest, ob zu tabindex="0" sichtbaren Folien hinzugefügt werden soll oder nicht.'
        class="form-label">slide Focus
        <i class="fa fa-info-circle font-blue cursor-pointer"> </i></label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="slide_focus" type="checkbox" 
        role="switch" id="slideFocusCheck"${sld ? sld.slide_focus  ? 'checked' : '' : 'checked'} >
        <label class="form-check-label"
        for="slideFocusCheck">aktiv</label>
        </div>
        </div>
        </div>
        
        <hr>
        <h5>Design </h5>
        <hr>
        <div class="row pt-3">    
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label class="form-label">Hover</label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="hover" type="checkbox" 
        role="switch" id="checkHover" ${sld ? sld.hover  ? 'checked' : '' : 'checked'}>
        <label class="form-check-label"
        for="checkHover">aktiv</label>
        </div>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label class="form-label">Bild Label</label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="label" type="checkbox" 
        role="switch" id="labelCheck" ${sld && sld.label ? 'checked' : ''} ${sld && sld.hover ? 'disabled' : ''}>
        <label class="form-check-label"
        for="labelCheck">aktiv</label>
        </div>
        </div>
        
        <div class="col-sm-6 col-md-4 col-xl-2 mb-3">
        <label class="form-label">Textauszug</label>
        <div class="form-check form-switch">
        <input class="form-check-input" name="textauszug" type="checkbox" 
        role="switch" id="textauszugCheck" ${sld && sld.textauszug ? 'checked' : ''}>
        <label class="form-check-label"
        for="textauszugCheck">aktiv</label>
        </div>
        </div>
        
        </div>
        <hr>
        <h5>Breakpoints <small class="small">( Responsive )</small></h5>
        <div class="form-text">Eigenschaften die in einer bestimmten
        Bildschirmbreite
        geändert werden sollen.
        </div>
        <hr>
        <div class="d-block">
        <button type="button" data-bs-toggle="collapse" 
        data-bs-target="#collapseBreakpoints" aria-expanded="false" aria-controls="collapseBreakpoints"  
        class="btn-toggle-active btn btn-blue-outline btn-sm"><i class="fa fa-tasks"></i>&nbsp; <span class="btn-txt">Breakpoints anzeigen</span></button>
        </div>
        <hr>
        <div class="collapse collapse-breakpoints" id="collapseBreakpoints">
        <h6>Breackpoint XS 450px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageXS" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_xs  ? sld.pro_page_xs : '' : '1'}" name="pro_page_xs"
        class="form-control"
        id="InputPageXS">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputXSGap" class="form-label">Gap</label>
        <input type="text" name="gap_xs" value="${sld ? sld.gap_xs  ? sld.gap_xs : '' : '0.1'}"  class="form-control" id="InputXSGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXSBreite" class="form-label">Breite</label>
        <input type="text" name="width_xs" value="${sld ? sld.width_xs  ? sld.width_xs : '' : '100%'}"  class="form-control" id="InputXSBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXSHeight" class="form-label">Höhe</label>
        <input type="text" name="height_xs" value="${sld ? sld.height_xs  ? sld.height_xs : '' : '250px'}" class="form-control" id="InputXSHeight">
        </div>
        </div>
        <hr>
        
        <h6>Breackpoint SM 576px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageSM" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_sm  ? sld.pro_page_sm : '' : '1'}" name="pro_page_sm"
        class="form-control"
        id="InputPageSM">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputSMGap" class="form-label">Gap</label>
        <input type="text" name="gap_sm" value="${sld ? sld.gap_sm  ? sld.gap_sm : '' : '0.1rem'}"  class="form-control" id="InputSMGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputSMBreite" class="form-label">Breite</label>
        <input type="text" name="width_sm" value="${sld ? sld.width_sm  ? sld.width_sm : '' : '100%'}"  class="form-control" id="InputSMBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputSMHeight" class="form-label">Höhe</label>
        <input type="text" name="height_sm" value="${sld ? sld.height_sm  ? sld.height_sm : '' : '250px'}" class="form-control" id="InputSMHeight">
        </div>
        </div>
        <hr>
        
        <h6>Breackpoint MD 768px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageMD" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_md  ? sld.pro_page_md : '' : '1'}" name="pro_page_md"
        class="form-control"
        id="InputPageMD">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputMDGap" class="form-label">Gap</label>
        <input type="text" name="gap_md" value="${sld ? sld.gap_md  ? sld.gap_md : '' : '0.3rem'}"  class="form-control" id="InputMDGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputMDBreite" class="form-label">Breite</label>
        <input type="text" name="width_md" value="${sld ? sld.width_md  ? sld.width_md : '' : '100%'}"  class="form-control" id="InputMDBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputMDHeight" class="form-label">Höhe</label>
        <input type="text" name="height_md" value="${sld ? sld.height_md  ? sld.height_md : '' : '300px'}" class="form-control" id="InputMDHeight">
        </div>
        </div>
        <hr>
        
        <h6>Breackpoint LG 992px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageLG" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_lg  ? sld.pro_page_lg : '' : '1'}" name="pro_page_lg"
        class="form-control"
        id="InputPageLG">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputLGGap" class="form-label">Gap</label>
        <input type="text" name="gap_lg" value="${sld ? sld.gap_lg  ? sld.gap_lg : '' : '0.3rem'}"  class="form-control" id="InputLGGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputLGBreite" class="form-label">Breite</label>
        <input type="text" name="width_lg" value="${sld ? sld.width_lg  ? sld.width_lg : '' : '100%'}"  class="form-control" id="InputLGBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputLGHeight" class="form-label">Höhe</label>
        <input type="text" name="height_lg" value="${sld ? sld.height_lg  ? sld.height_lg : '' : '300px'}" class="form-control" id="InputLGHeight">
        </div>
        </div>
        <hr>
        
        <h6>Breackpoint XL 1200px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageXL" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_xl  ? sld.pro_page_xl : '' : '2'}" name="pro_page_xl"
        class="form-control"
        id="InputPageXL">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputXLGap" class="form-label">Gap</label>
        <input type="text" name="gap_xl" value="${sld ? sld.gap_xl  ? sld.gap_xl : '' : '0.3rem'}"  class="form-control" id="InputXLGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXLBreite" class="form-label">Breite</label>
        <input type="text" name="width_xl" value="${sld ? sld.width_xl  ? sld.width_xl : '' : '100%'}"  class="form-control" id="InputXLBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXLHeight" class="form-label">Höhe</label>
        <input type="text" name="height_xl" value="${sld ? sld.height_xl  ? sld.height_xl : '' : '250px'}" class="form-control" id="InputXLHeight">
        </div>
        </div>
        <hr>
        
        <h6>Breackpoint XXL 1400px</h6>
        <hr>
        <div class="row">
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputPageXXL" class="form-label">per Page</label>
        <input type="number" value="${sld ? sld.pro_page_xxl  ? sld.pro_page_xxl : '' : '3'}" name="pro_page_xxl"
        class="form-control"
        id="InputPageXXL">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
        <label for="InputXXLGap" class="form-label">Gap</label>
        <input type="text" name="gap_xxl" value="${sld ? sld.gap_xxl  ? sld.gap_xxl : '' : '0.3rem'}"  class="form-control" id="InputXXLGap">
        </div>
        </div>
        
        <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXXLBreite" class="form-label">Breite</label>
        <input type="text" name="width_xxl" value="${sld ? sld.width_xxl  ? sld.width_xxl : '' : '100%'}"  class="form-control" id="InputXXLBreite">
        </div>
         <div class="col-md-6 col-lg-4 col-xl-2 mb-1">
        <label for="InputXXLHeight" class="form-label">Höhe
                
        </label>
        <input type="text" name="height_xxl" value="${sld ? sld.height_xxl  ? sld.height_xxl : '' : '250px'}" class="form-control" id="InputXXLHeight">
        </div>
        </div>
        <hr>
        </div><!--collapse-->
        
        <button type="submit" class="btn btn-blue me-2"><i class="fa fa-sliders"></i>
        &nbsp;${data ? 'Änderungen speichern' : 'Slider erstellen'}</button>
        <button type="button" class="load-slider-data btn-hover-light btn btn-light border me-2"><i class="text-danger fa fa-times"></i>&nbsp; abbrechen
        </button>
        </div><!--item-->
        </form>
        </div><!--wrapper-->
        `;
        $('#slideFormWrapper').html(html);


        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }


    /**===========================================================
     ================ LOAD SLIDER TOASTS TEMPLATE ================
     =============================================================
     */
    function slider_toasts_template(record){

        let html = `
        <div id="ToastWrapper" class="row gap-2 px-2 mb-3 py-3">`;
        $.each(record, function (key, val) {
         html += `<div id="slider${val.id}" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="toast-header">
         <i class="fa fa-sliders fa-2x me-2"></i>
         <strong class="me-auto">Slider</strong>
         <span style="font-size: 1rem" data-bs-id="${val.id}" data-bs-type="slider" data-bs-method="delete_post_items"
         data-bs-toggle="modal" data-bs-target="#formDeleteModal"
         class="cursor-pointer">
         <small class="text-danger">löschen</small> <i class="text-danger fa fa-trash"></i>
         </span>
         </div>
         <div class="toast-body">
         <i class="font-blue fa fa-caret-right"></i>&nbsp; <b class="strong-font-weight">${val.bezeichnung}</b>
         <hr class="mt-1 mb-2">
         <button data-type="update" data-id="${val.id}" 
         class="load-slider-temp-edit btn btn-blue-outline btn-sm my-1"><i class="fa fa-sliders"></i>&nbsp; bearbeiten</button>
         </div>
         </div>`;
        });
        html += '</div>';
        $('#slideFormWrapper').html(html);
    }

    /**=============================================
     ================ Löschen Modal ================
     ===============================================
     */
    let deleteModal = document.getElementById('formDeleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let formType = '';
            let id = button.getAttribute('data-bs-id');
            let type = button.getAttribute('data-bs-type');
            let method = button.getAttribute('data-bs-method');
            let modalTitle = deleteModal.querySelector('.modal-title');
            let modalBodyMsg = deleteModal.querySelector('.modal-body');
            switch (type){
                case 'slider':
                    formType = 'Slider';
                    break;
            }
            document.querySelector('.btn-delete-items').setAttribute('data-id', id);
            document.querySelector('.btn-delete-items').setAttribute('data-method', method);
            document.querySelector('.btn-delete-items').setAttribute('data-type', type);
            modalBodyMsg.innerHTML = `<h6 class="text-center"><b class="text-danger">${formType} wirklich löschen?</b><small class="d-block">Diese Aktion kann <b class="text-danger">nicht</b> rückgängig gemacht werden!</small></h6>`;
            modalTitle.innerHTML = `<i class="fa fa-trash-o"></i>&nbsp; ${formType} löschen`;
        });
    }


    /**=============================================
     ================ FORM Serialize ================
     ================================================
     */
    $.fn.serializeObject = function () {
        let o = {};
        let a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    /**=========================================
     ========== AJAX RESPONSE MESSAGE ===========
     ============================================
     */
    function success_message(msg) {
        let x = document.getElementById("snackbar-success");
        x.innerHTML = msg;
        x.className = "show";
        setTimeout(function () {
            x.className = x.className.replace("show", "");
        }, 3000);
    }

    function warning_message(msg) {
        let x = document.getElementById("snackbar-warning");
        x.innerHTML = msg;
        x.className = "show";
        setTimeout(function () {
            x.className = x.className.replace("show", "");
        }, 3000);
    }
});