$(function () {

    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced"
    });

    $('.mainPicture').click(function (e) {

        e.preventDefault();

        var postId = $('#postId').val(),
            url    = ppi.baseUrl + 'admin/blog/uploadmedia/' + postId;

        $.get(url + '/quick-view', function (data) {
            $("#dialog.modal .modal-body").html(data);
            $('#dialog.modal .modal-header h3').html('Upload Pictures');
            $('#dialog.modal .modal-footer').hide();
        });

        $('#dialog').modal('show');

    });

    $('#addBlogPost').submit(function (e) {

        e.preventDefault();

        juvasoft.saveAndPublish($(this));
    });

    $('.saveDraft').click(function (e) {

        e.preventDefault();

        juvasoft.save($('#addBlogPost'));

    });

    $('.category').tagsInput({
        'height': '60px',
        'width': '95%',
        defaultText: 'Categories...',
        onAddTag: function (tag) {
        }
    });

    $('.tag').tagsInput({
        'height': '60px',
        'width': '95%',
        defaultText: 'Tags...',
        onAddTag: function (tag) {
        }
    });

});

juvasoft = {

    save: function (element) {

        var url = ppi.baseUrl + 'admin/blog/post/createsave';

        tinyMCE.triggerSave();

        $.post(url, $(element).serialize(), function (response) {

            if (response.status == 'error') {

                $('.alert-error.alert').fadeIn();
                $('.alert-error.alert').html('Please fill up the required fields.');
            }

            if (response.status == 'success') {
                $('.alert-success.alert').fadeIn();
                $('.alert-success.alert').html(response.message);
            }

        }, 'json');

    },
    saveAndPublish: function (element) {
        var url = ppi.baseUrl + 'admin/blog/post/createsave';

        $.post(url, $(element).serialize(), function (response) {

            if (response.status == 'error') {

                $('.alert-error.alert').fadeIn();
                $('.alert-error.alert').html('Please fill up the required fields.');
            }

            if (response.status == 'success') {
                juvasoft.publish(response.postId);
            }

        }, 'json');
    },
    publish: function (postId) {

        var url = ppi.baseUrl + 'admin/blog/post/publish';

        $.post(url, "id=" + postId, function (response) {
            if (response.status == 'success') {
                window.location.href = ppi.baseUrl + 'admin/blog/';
            }

            if (response.status == 'error') {
                $('.alert-error.alert').fadeIn();
                $('.alert-error.alert').html(response.message);
            }
        }, 'json');

    }

};