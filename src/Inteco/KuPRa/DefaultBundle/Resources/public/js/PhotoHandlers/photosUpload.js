Inteco.bindings.photosUpload = {
    run: function (element) {


        console.log(element.fileupload);
        console.log(element);
        element.fileupload({
            url: element.data('url'),
            dataType: 'json',

            start: function(e) {
                var $progressBar = $('#progress-bar');
                $progressBar.removeClass('fade');
                $progressBar.find('.progress-bar-success:first').css(
                    'width',
                    0 + '%'
                );
            },

            done: function (e, data) {

                if (typeof data.violations == 'undefined') {

                    var $collectionHolder = $('#media-photos');
                    var prototype = $collectionHolder.attr('data-prototype');

                    var newItem = prototype.replace(RegExp('__name__', 'g'), Avek.Core.generateGuid());
                    newItem = newItem.replace(RegExp('__originalName__'), data.result.originalName);
                    newItem = newItem.replace(RegExp('__originalPath__'), data.result.originalPath);
                    newItem = newItem.replace(RegExp('__path__'), data.result.path);

                    $collectionHolder.find('tbody:first').append(newItem);

                    $collectionHolder.find('tbody:first tr:last')
                        .find('input:first').val(data.result.originalName)
                        .next().val(data.result.originalPath)
                        .next().val(data.result.path);

                    $collectionHolder.find('tbody:first tr:last')
                        .find('td:first span:first').html('<img src="'+data.result.thumbnail+'" />');

                } else {
                    $.each(data.result.violations, function(i,v) {
                        $('#uploadErrorsList').append('<div class="alert"><button data-dismiss="alert" class="close" type="button">×</button>'+v+'</div>')
                    })
                }

                setTimeout(function() {
                    var $progressBar = $('#progress-bar');
                    $progressBar.addClass('fade');
                    $progressBar.find('.progress-bar-success:first').css(
                        'width',
                        0 + '%'
                    );
                }, 3000);
            },
            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);
                var $progressBar = $('#progress-bar');

                $progressBar.find('.progress-bar-success:first').css(
                    'width',
                    progress + '%'
                );
            }
        });
    }
};