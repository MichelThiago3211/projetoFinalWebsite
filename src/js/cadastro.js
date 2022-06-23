"use strict";

const nomeInput = document.getElementById("nome");
const cnpInput = document.getElementById("cnp");

// Quando o tipo de fornecedor for alterado, atualiza os campos do CNP e do nome
function atualizarTipo() {
  const value = document.getElementById("tipo").value;

  if (value === "brecho") {
    cnpInput.children[1].innerHTML = "CPF";
    cnpInput.children[0].pattern = "\\d{11}"
    cnpInput.children[0].placeholder = "___.___.___-__";

    nomeInput.children[1].innerHTML = "Nome completo";
  }
  else {
    cnpInput.children[1].innerHTML = "CNPJ";
    cnpInput.children[0].pattern = "\\d{14}"
    cnpInput.children[0].placeholder = "__.___.___/0001-__";

    nomeInput.children[1].innerHTML = "Nome da instituição";
  }
};

document.getElementById("tipo").addEventListener("change", atualizarTipo);
atualizarTipo();

// Verifica se as senhas são iguais
function testarConfirmacaoSenha() {
  if (confirmarSenhaInput.value !== senhaInput.value) {
    confirmarSenhaInput.setCustomValidity("As senhas não são iguais");
  }
  else {
    confirmarSenhaInput.setCustomValidity("");
  }
}

const confirmarSenhaInput = document.querySelector("#confirmar-senha > input");
const senhaInput = document.querySelector("#senha > input");

senhaInput.addEventListener("input", testarConfirmacaoSenha);
confirmarSenhaInput.addEventListener("input", testarConfirmacaoSenha);

// Quando uma imagem for enviada, exibe uma preview dela
document.getElementById("imagem").onchange = e => {
  let preview = document.getElementById('preview');
  preview.src = URL.createObjectURL(e.target.files[0]);
  preview.onload = function() {
    URL.revokeObjectURL(preview.src);
  }
}