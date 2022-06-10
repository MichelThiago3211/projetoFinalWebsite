"use strict";

import { Debouncer } from "./debounce.js";

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
    sobrenomeInput.children[0].required = true;
    sobrenomeInput.hidden = false;
    nomeInput.style.gridColumn = "initial";
  }
  else {
    cnpInput.children[1].innerHTML = "CNPJ";
    cnpInput.children[0].pattern = "\\d{14}"
    cnpInput.children[0].placeholder = "__.___.___/0001-__";

    nomeInput.children[1].innerHTML = "Nome da instituição";
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

// Autopreenchimento do endereço

const ENDERECO_API_URL = "https://api.geoapify.com/v1/geocode/autocomplete?text=#&apiKey=f62b5fe78b08493c995352735ed8bfd3";

const sugestoesEndereco = document.querySelector("#endereco > div.sugestoes");
const enderecoInput = document.getElementById("endereco-input")

const sugestoesDebouncer = new Debouncer(sugerirEndereco, 500);

function definirEndereco(sugestao) {
  enderecoInput.value = sugestao.formatted;
  enderecoInput.setCustomValidity("");
	
  document.getElementById("rua-hidden").value = sugestao.street;
  document.getElementById("numero-hidden").value = sugestao.housenumber;
  document.getElementById("cep-hidden").value = sugestao.postcode;
  document.getElementById("cidade-hidden").value = sugestao.city;
}

async function sugerirEndereco() {
  const termo = enderecoInput.value.trim();

  if (termo === "") {
    esconderSugestoes();
  }
  else {
    const url = ENDERECO_API_URL.replace("#", termo);

		let sugestoes = (await (await fetch(url)).json()).features || [];
    sugestoes = sugestoes.filter(sugestao => sugestao.properties.result_type === "building");

		if (sugestoes.length === 0) {
			sugestoesEndereco.innerHTML = "<span>Nenhum resultado disponível.</span>";
		}
		else {
			sugestoesEndereco.innerHTML = "";
			for (let sugestao of sugestoes) {
				const span = document.createElement("span");
				span.className = "sugestao";
				span.innerHTML = sugestao.properties.formatted;
				span.onclick = () => {
          definirEndereco(sugestao.properties);
          esconderSugestoes();
        }
				sugestoesEndereco.append(span);
			}
		}
	}
}

function esconderSugestoes() {
  sugestoesEndereco.style.display = "none";
}

function mostrarSugestoes() {
  enderecoInput.setCustomValidity("Endereço inválido");
  sugestoesDebouncer.invoke();
  sugestoesEndereco.style.display = "flex";
  sugestoesEndereco.innerHTML = "<span>Carregando...</span>";
}

enderecoInput.addEventListener("input", mostrarSugestoes);

// Upload do logo

document.getElementById("imagem").onchange = e => {
  let preview = document.getElementById('preview');
  preview.src = URL.createObjectURL(e.target.files[0]);
  preview.onload = function() {
    URL.revokeObjectURL(preview.src);
  }
}