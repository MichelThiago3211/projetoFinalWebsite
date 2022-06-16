"use strict";

// Input para adicionar imagens
const adicionarImagem = document.getElementById("add-imagem");
const imagemInput = adicionarImagem.querySelector("input[type=file]");

// Div onde estão contidas as imagens inseridas
const imagens = document.getElementById("imagens");

// Quando uma imagem for enviada, exibe ela
imagemInput.addEventListener("change", e => {
  imagens.querySelectorAll("img").forEach(img => img.remove());

  for (const imagem of e.target.files) {

    // Permite no máximo 5 imagens
    if (imagens.querySelectorAll("img").length >= 5) {
      alert("Limite de imagens atingido!");
      break;
    }

    const img = document.createElement("img");
    img.src = URL.createObjectURL(imagem);
    img.onload = () => URL.revokeObjectURL(img.src);
    adicionarImagem.before(img);
  }
});