"use strict";

// Busca todos os <input>'s de tipo 'file'
for (let elem of document.querySelectorAll('input[type="file"]')) {

  // Verifica o tamanho máximo de arquivo permitido nesse input
  const tamanhoElem = elem.previousElementSibling;
  if (tamanhoElem.name != "MAX_FILE_SIZE") {
    continue;
  }
  let tamanhoMaximo = tamanhoElem.value;

  // Quando um arquivo for selecionado, verifica se o tamanho é maior que o permitido
  // Se for, exibe um aviso e cancela o envio
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

// Formata um tamanho em bytes para um formato legível (ex: 1024 bytes = 1KB)
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