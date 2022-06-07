"use strict";

import { Debouncer } from "./debounce.js";

// CPF/CNPJ

const cnpInput = document.querySelector("#cnp > input");
const cnpLabel = document.querySelector("#cnp > label");

function atualizarCnpInput() {
  const value = document.getElementById("tipo").value;

  if (value === "brecho") {
    cnpLabel.innerHTML = "CPF";
    cnpInput.pattern = "\\d{11}"
    cnpInput.placeholder = "___.___.___-__";
  }
  else {
    cnpLabel.innerHTML = "CNPJ";
    cnpInput.pattern = "\\d{14}"
    cnpInput.placeholder = "__.___.___/0001-__";
  }
};

document.getElementById("tipo").addEventListener("change", atualizarCnpInput);
atualizarCnpInput();

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

// Autopreenchimento do endereço

const ENDERECO_API_URL = "https://api.geoapify.com/v1/geocode/autocomplete?text=#&apiKey=f62b5fe78b08493c995352735ed8bfd3";

const sugestoesEndereco = document.querySelector("#endereco > div.sugestoes");
const enderecoInput = document.getElementById("endereco-input")

const sugestoesDebouncer = new Debouncer(sugerirEndereco, 500);

function definirEndereco(sugestao) {
  enderecoInput.value = sugestao.formatted;
  enderecoInput.setCustomValidity("");
	
  document.getElementById("rua-hidden").value = sugestao.street;
  document.getElementById("numero-hidden").value = sugestao.numero;
  document.getElementById("cep-hidden").value = sugestao.cep;
  document.getElementById("cidade-hidden").value = sugestao.cidade;
}

async function sugerirEndereco() {
  const termo = enderecoInput.value.trim();

  if (termo === "") {
    esconderSugestoes();
  }
  else {
    const url = ENDERECO_API_URL.replace("#", termo);

		const sugestoes = (await (await fetch(url)).json()).features || [];

		if (sugestoes.length === 0) {
			sugestoesEndereco.innerHTML = "<span>Nenhum resultado disponível.</span>";
		}
		else {
			sugestoesEndereco.innerHTML = "";
			for (let sugestao of sugestoes) {
				const span = document.createElement("span");
				span.className = "sugestao";
				span.innerHTML = sugestao.properties.formatted;
				span.onclick = () => definirEndereco(sugestao.properties);
				sugestoesEndereco.append(span);
			}
		}
	}
}

function esconderSugestoes(e) {
  let alvo = e?.explicitOriginalTarget;
  if (alvo) {
    if (alvo.nodeName === "#text") {
      alvo = alvo.parentElement;
    }
    if (alvo.classList.contains("sugestao")) {
      alvo.click();
    }
  }
  sugestoesEndereco.style.display = "none";
}

function mostrarSugestoes() {
  enderecoInput.setCustomValidity("Endereço inválido");
  sugestoesDebouncer.invoke();
  sugestoesEndereco.style.display = "flex";
  sugestoesEndereco.innerHTML = "<span>Carregando...</span>";
}

enderecoInput.addEventListener("input", mostrarSugestoes);
enderecoInput.addEventListener("blur", e => esconderSugestoes(e));