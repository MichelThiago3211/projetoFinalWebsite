"use strict";

for (let elem of document.querySelectorAll('input[type="file"]')) {
  const tamanhoElem = elem.previousElementSibling;
  if (tamanhoElem.name != "MAX_FILE_SIZE") {
    continue;
  }

  let tamanhoMaximo = tamanhoElem.value;

  elem.addEventListener("change", e => {
    for (let i = 0; i < e.target.files.length; i++) {
      const tamanho = e.target.files[i].size;

      if (tamanho > tamanhoMaximo) {
        alert("Imagens devem ter no máximo 1MB");
        e.target.value = "";
        e.stopImmediatePropagation();
        break;
      }
    }
  });
}