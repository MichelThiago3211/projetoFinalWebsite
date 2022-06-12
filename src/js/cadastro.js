"use strict";

// CPF/CNPJ

const nomeInput = document.getElementById("nome");
const sobrenomeInput = document.getElementById("sobrenome");

const cnpInput = document.getElementById("cnp");

function atualizarTipo() {
  const value = document.getElementById("tipo").value;

  if (value === "brecho") {
    cnpInput.children[1].innerHTML = "CPF";
    cnpInput.children[0].pattern = "\\d{11}"
    cnpInput.children[0].placeholder = "___.___.___-__";

    nomeInput.children[1].innerHTML = "Nome";
    nomeInput.children[0].setAttribute("maxlength", 69);
    sobrenomeInput.children[0].required = true;
    sobrenomeInput.hidden = false;
    nomeInput.style.gridColumn = "initial";
  }
  else {
    cnpInput.children[1].innerHTML = "CNPJ";
    cnpInput.children[0].pattern = "\\d{14}"
    cnpInput.children[0].placeholder = "__.___.___/0001-__";

    nomeInput.children[1].innerHTML = "Nome da instituição";
    nomeInput.children[0].setAttribute("maxlength", 100);
    sobrenomeInput.children[0].required = false;
    sobrenomeInput.hidden = true;
    nomeInput.style.gridColumn = "span 2";
  }
};

document.getElementById("tipo").addEventListener("change", atualizarTipo);
atualizarTipo();

// Confirmação da senha

const senhaInput = document.querySelector("#senha > input");
const confirmarSenhaInput = document.querySelector("#confirmar-senha > input");

function testarConfirmacaoSenha() {
  if (confirmarSenhaInput.value !== senhaInput.value) {
    confirmarSenhaInput.setCustomValidity("As senhas não são iguais");
  }
  else {
    confirmarSenhaInput.setCustomValidity("");
  }
}

senhaInput.addEventListener("input", testarConfirmacaoSenha);
confirmarSenhaInput.addEventListener("input", testarConfirmacaoSenha);

// Upload do logo

document.getElementById("imagem").onchange = e => {
  let preview = document.getElementById('preview');
  preview.src = URL.createObjectURL(e.target.files[0]);
  preview.onload = function() {
    URL.revokeObjectURL(preview.src);
  }
}