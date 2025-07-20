const dragArea = document.querySelector('.dragArea');
const dragText = document.querySelector('.headerDrag');
const inputGaleria = document.getElementById('galeria_imagenes[]');
const showImagesArea = document.querySelector('.show_images');
let buttonDrag = document.querySelector('.buttonDrag');
filesAprove = [];

buttonDrag.onclick = () => {
    inputGaleria.click();
};

inputGaleria.addEventListener('change',function() {
    const files = this.files;
    for (const file of files){
        filesAprove.push(file);
    }
    actualizarInputFiles(filesAprove);
})

dragArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragText.textContent = 'Release to Upload';
    dragArea.classList.add('active');
});

dragArea.addEventListener('dragleave', (event) => {
    event.preventDefault();
    dragText.textContent = 'Drag & Drop';
    dragArea.classList.remove('active');
});

dragArea.addEventListener('drop', (event) => {
    event.preventDefault();
    files = event.dataTransfer.files;
    for (const file of files) {
        let fileType = file.type;
        let validExtensions = ['image/jpeg','image/jpg','image/png'];
        if (validExtensions.includes(fileType)){
            filesAprove.push(file);
        } else alert('This file is not an image');
    };
    actualizarInputFiles(filesAprove);
})

function actualizarInputFiles(files) {
    const dataTransfer = new DataTransfer();
    for (const file of files) {
        dataTransfer.items.add(file);
    }
    inputGaleria.files = dataTransfer.files;
    console.log(inputGaleria.files);
    mostrarFiles(filesAprove);
}

function mostrarFiles(files) {
    showImagesArea.innerHTML = '';

    const groupSize = 7;
    let currentGroup = null;

    files.forEach((file, index) => {
        if (index % groupSize === 0) {
            currentGroup = document.createElement('div');
            currentGroup.classList.add('rowImg');
            showImagesArea.appendChild(currentGroup);
        }
        processFile(file, currentGroup);
    });
}

function processFile(file,div){
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = () => {
            let fileURL = reader.result;
            let img = `<img src="${fileURL}" alt="" width="65" height="65">`;
            div.innerHTML += img;
            resolve();
        };
        reader.readAsDataURL(file);
    })
}