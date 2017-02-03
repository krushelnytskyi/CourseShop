$( function() {
    $( "#tabs" ).tabs();
} );

$(document).on('submit', 'form.ajax', function () {

    var url = $(this).attr('action');
    var method = $(this).attr('method');

    var data = $(this).serializeArray();

    var submitData = {};

    for (var index in data) {
        submitData[data[index].name]
            = data[index].value;
    }

    $.ajax(
        {
            url: url,
            method: method,
            data: submitData,
            success: function (data) {

                $('span.error-messages').html('');

                if (data.hasOwnProperty('messages') == true) {

                    data = data.messages;

                    for (var name in data) {

                        var messages = '';

                        data[name].forEach(function (message) {
                            messages += '<span class="badge badge-danger">' + message + '</span>'
                        });

                        $('input[name=' + name + ']')
                            .parent()
                            .find('span.error-messages')
                            .html(messages);
                    }
                }
            }
        }
    );

    return false;
});

