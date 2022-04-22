


function showPassword(id)
{
    let el = $('#showPasswordIcon');

    if(el.hasClass('fa-eye-slash'))
    {
        el.removeClass('fa-eye-slash');
        el.addClass('fa-eye');
        $('#'+id).attr('type', 'text');
    }
    else
    {
        el.removeClass('fa-eye');
        el.addClass('fa-eye-slash');
        $('#'+id).attr('type', 'password');
    }
}
