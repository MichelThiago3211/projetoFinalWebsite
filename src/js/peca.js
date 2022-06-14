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
      alert("Limite de iamgens atingido!");
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
      console.log(imagensInseridas);
    });
    
    // Adiciona a imagem à lista
    adicionarImagem.before(imagemElem);
    imagensInseridas.push(imagem);
    console.log(imagensInseridas);
  }
});

const preco = document.getElementsByName("preco")[0];
console.log(preco);