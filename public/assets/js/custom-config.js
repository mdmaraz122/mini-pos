// Show Loader
function showLoader(){
    $(".loader").fadeIn("slow");
}
// hide Loader
function hideLoader(){
    $(".loader").fadeOut("hide");
}
// success Toast Message
function successToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "green",
        }
    }).showToast();
}
// error Toast Message
function errorToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "red",
        }
    }).showToast();
}


