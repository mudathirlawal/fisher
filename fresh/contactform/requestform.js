$(document).ready(function(a) {

    var contact = $(".requestForm");

    contact.submit(function(event) {
        event.preventDefault();
        var data = {
            name: $('#name').val(),
            email: $('#email').val(),
            subject: $('#projType').val(),
            message: $('#projDesc').val()
        };
        $.ajax({
            type: "POST",
            url: "contactform/requestquote.php",
            data: data,
            success: function (response) {
                document.getElementById("requestForm").reset();
                $('#sendmessage').show();
            },
            error: function(error) {
                $('#errormessage').html(error);
            }
        });
    });
});