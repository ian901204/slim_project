var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
document.getElementsByTagName('head')[0].appendChild(script);
function verify_token(){
    $.ajax({
        url: "https://admin.ian-shen.live/verify",
        headers: {"Authorization":"Bearer " + localStorage.getItem('token')},
        type: "POST",
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        error: function(xhr, ajaxOptions, thrownError){
            localStorage.removeItem('token');
            alert("請重新登入!");
            window.location.replace("https://admin.ian-shen.live/login");
        }
    });
}