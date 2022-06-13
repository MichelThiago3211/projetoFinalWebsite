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
        alert("Os arquivos devem ter no máximo " + formatarBytes(tamanhoMaximo));
        e.target.value = "";
        e.stopImmediatePropagation();
        break;
      }
    }
  });
}

function formatarBytes(bytes) {
  if (bytes >= 1024 * 1024) {
    return (bytes / 1024 / 1024).toFixed(2) + " MB";
  }
  else if (bytes >= 1024) {
    return (bytes / 1024).toFixed(2) + " KB";
  }
  else {
    return bytes + " bytes";
  }
}