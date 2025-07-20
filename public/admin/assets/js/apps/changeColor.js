document.addEventListener("DOMContentLoaded", function () {
  function rgbToHex(rgb) {
    const matches = rgb.match(/\d+/g);
    const hex = matches
      .map(value => parseInt(value).toString(16).padStart(2, '0'))
      .join('');
    return `#${hex}`;
  }

  const colorDrop = document.querySelectorAll('.colorDrop');

  colorDrop.forEach((drop)=>{
    drop.addEventListener('shown.bs.dropdown', event => {
      const dropMenu = drop.nextElementSibling;
      const colorBox = dropMenu.querySelector('.color-box');
      const colorSelectItems = dropMenu.querySelectorAll('.color-select');
      const inputSelectColor = dropMenu.querySelector('input[name=colorCode]');
      const buttonAcept = dropMenu.querySelector('.btnChangeColor');
      const buttonCancel = dropMenu.querySelector('.btnCancelChangeColor');
      const posItem = drop.getAttribute('data-pos');

      colorSelectItems.forEach((item)=>{
        var width = item.offsetWidth;
        item.style.height = `${width}px`;

        item.addEventListener('click',(event)=>{
          event.stopPropagation();
          const color = rgbToHex(getComputedStyle(item).backgroundColor);
          colorBox.style.backgroundColor = color;
          inputSelectColor.value = color;

          colorSelectItems.forEach(el => el.classList.remove('selected-color'));
          item.classList.add('selected-color');
        });
      });

      const colorBoxWidth = colorBox.offsetWidth;
      colorBox.style.height = `${colorBoxWidth}px`;
      colorBox.style.backgroundColor = inputSelectColor.value;

      inputSelectColor.addEventListener('input',()=>{
        const color = inputSelectColor.value;
        colorBox.style.backgroundColor = color;
        colorSelectItems.forEach(el => el.classList.remove('selected-color'));
        colorSelectItems.forEach(el => {
          if (rgbToHex(getComputedStyle(el).backgroundColor) === color) {
            el.classList.add('selected-color');
          }
        });
      });

      buttonCancel.addEventListener('click',event => {
        const bsDropdown = bootstrap.Dropdown.getInstance(drop);
        bsDropdown.hide();
      });

      buttonAcept.addEventListener('click',()=>{
        const imgCard = document.querySelectorAll('.card-img-'+posItem);
        imgCard.forEach(el => el.style.setProperty('--back-color', inputSelectColor.value));
        const bsDropdown = bootstrap.Dropdown.getInstance(drop);
        bsDropdown.hide();
      })
    })
  })

  const filterButton = document.getElementById("filterButton");
  const filterCont = document.getElementById("filter-cont");
  const cancelFilter = document.getElementById("btnCancelFilter");
  const aplyFilter = document.getElementById("btnAplyFilter");

  filterButton.addEventListener('click',()=>{filterCont.classList.toggle('d-none')});
  cancelFilter.addEventListener('click',()=>{filterCont.classList.add('d-none')});
});