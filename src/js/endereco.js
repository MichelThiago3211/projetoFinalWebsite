"use strict";

const cepInput = document.getElementsByName("cep")[0];
const cidadeInput = document.getElementsByName("cidade")[0];
const ufInput = document.getElementsByName("uf")[0];

cepInput.addEventListener("input", testarCEP);
testarCEP();

// Verifica se um CEP existe e, nesse caso, autopreenche o nome da cidade e estado
async function testarCEP() {
  cepInput.setCustomValidity("CEP inválido");
  const cep = cepInput.value;
  if (cep.length !== 8) return;
  
  const url = `https://viacep.com.br/ws/${cep}/json/`;
  const req = await fetch(url);
  if (req.status !== 200) return;

  const {localidade, uf, erro} = await req.json();
  if (!erro) {
    cidadeInput.value = localidade;
    ufInput.value = uf;
    cepInput.setCustomValidity("");
  }
}