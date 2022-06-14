"use strict";

// Input para adicionar mais imagens
const adicionarImagem = document.getElementById("add-imagem");
const imagemInput = adicionarImagem.querySelector("input[type=file]");

// Div onde estão contidas as imagens inseridas
const imagens = document.getElementById("imagens");
const templateImagem = document.getElementById("template-imagem");

const imagensInseridas = [];

// Quando uma imagem for enviada, adiciona ela à lista
imagemInput.addEventListener("change", e => {
  for (const imagem of e.target.files) {

    if (imagens.querySelectorAll(".imagem").length > 5) {
      alert("Limite de imagens atingido!");
      return;
    }

    // Cria um novo elemento para a imagem
    const imagemElem = templateImagem.content.cloneNode(true);
    const img = imagemElem.querySelector("img");
    const remover = imagemElem.querySelector(".remover");
    const container = imagemElem.querySelector(".imagem");

    img.src = URL.createObjectURL(imagem);
    img.onload = () => URL.revokeObjectURL(img.src);

    remover.addEventListener("click", () => {
      imagens.removeChild(container);
      imagensInseridas.splice(imagensInseridas.indexOf(imagem), 1);
    });
    
    // Adiciona a imagem à lista
    adicionarImagem.before(imagemElem);
    imagensInseridas.push(imagem);
  }
});

const preco = document.getElementsByName("preco")[0];

// Interceptar envio do form para adicionar as imagens inseridas

const form = document.getElementsByTagName("form")[0];

form.addEventListener("submit", e => {
  const dadosForm = new FormData(form);

  const req = new XMLHttpRequest();
  req.open("POST", form.action);
  
  for (let imagem of imagensInseridas) {
    dadosForm.append("imagens[]", imagem);
  }

  req.send(dadosForm);
  req.onreadystatechange = () => console.log(req.responseText);

  e.preventDefault();
});