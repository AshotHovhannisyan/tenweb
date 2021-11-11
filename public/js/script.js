jQuery(document).ready(function($) {
    $('.twebcf-main-form').on('submit', function (e) {
        e.preventDefault();
        let formId = $(this).attr('data-id');
        const contactForm = $('.twebcf-form-' + formId);
        // let formData = contactForm.serializeArray();
        let formData = new FormData($(this)[0]);
        // const formArr = getArr(formData);

        // var file = $('#file-img')[0].files[0];
        // formData.append("action", "twebcf_form_submission");
        


        $.ajax({
            type : "POST",
            url: TWEBCF_AJAX_DATA.url,
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(result){
                $('#message-data').html(result);
            }});

    })

    $("#file-img").on('change', function (e) {
        $(".twebcf-main-form .change-file span").html('Change image... ');

        if ( this.files && this.files[0] ) {

            var reader = new FileReader();
            reader.onload = (function (e) {
                $(this).val( e.target.result);
            });
            reader.readAsDataURL(this.files[0]);

        }
    });

    $('.twebcf-main-form .change-file span').on('click', function (e) {
        $("#file-img").trigger('click');
    })

    function getArr(formData){
        let data = {};
        $.each( formData, function( key, obj ) {
            if (obj.value !== ''){
                data[obj.name] = obj.value;
            }
        })
        return data;
    }
});
