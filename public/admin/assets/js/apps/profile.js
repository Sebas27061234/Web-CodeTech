var photo = document.getElementById("photo");
var photoPreviewC = document.getElementById("photoPreviewC");
var photoPreviewN = document.getElementById("photoPreviewN");

photo.addEventListener('change',()=>{
    var photoName = photo.files[0].name;
    const reader = new FileReader();
    reader.onload = (e) => {
        photoPreviewN.querySelector('span').style.backgroundImage =  `url(${e.target.result})`;
        photoPreviewN.classList.remove('d-none');
        photoPreviewC.classList.add('d-none');
    };
    reader.readAsDataURL(photo.files[0]);
});
