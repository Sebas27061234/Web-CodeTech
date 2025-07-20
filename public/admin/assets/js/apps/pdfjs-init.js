document.addEventListener("DOMContentLoaded", function () {
    var buttonsModal = document.querySelectorAll('.certificateModal');

    buttonsModal.forEach(button => {
        button.addEventListener('click', function(){
            var link = button.getAttribute('data-certificate');
            var contenedorLink = document.querySelector('#modalCertificate iframe');
            contenedorLink.setAttribute('src',link);
        })
    })
})