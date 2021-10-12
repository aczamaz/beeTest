$(document).ready(function () {
    if ($.cookie('addedTask'))
    {
        alert("Task Added!");
        $.removeCookie('addedTask');
    }
    
});