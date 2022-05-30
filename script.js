function success() {
    window.addEventListener("DOMContentLoaded", function loaded() {
    Swal.fire({
        icon: 'success',
        title: 'Votre message a bien été envoyé',
        target: 'body',
        showConfirmButton: false,
        timer: 1500
    })
})
}

function failed() {
    window.addEventListener("DOMContentLoaded", function loaded() {
    Swal.fire({
        icon: 'error',
        title: 'erreur dans la saisie du Captcha',
        target: 'body',
        showConfirmButton: false,
        timer: 1500
    })
})
}
