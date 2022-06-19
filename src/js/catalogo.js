"use strict";

const form = document.forms[0];
document.getElementById("limpar").onclick = limparFormulario;

// Reseta todos os campos do formulário e recarrega a página
function limparFormulario() {
  const selectElements = document.getElementsByTagName("select");
  for (let select of selectElements) {
    select.selectedIndex = 0;
  }
  const inputElements = document.getElementsByTagName("input");
  for (let input of inputElements) {
    input.value = "";
  }
  form.submit();
}