"use strict";

// Input para adicionar mais imagens
const imagemInput = document.getElementById("imagens-input");

// Div onde estão contidas as imagens inseridas
const imagens = document.getElementById("imagens")


// Quando uma imagem for enviada, adiciona ela à lista
imagemInput.addEventListener("change", e => {

  // O usuário pode enviar várias imagens de uma só vez
  console.log(e.target.files);

  // Permite que até 5 imagens sejam inseridas
  if (imagens.getElementsByTagName("img").length >= 5) {
    alert("Limite de imagens atingido!");
    return;
  }

  // USAR TEMPLATE NO HTML AO INVÉS DE CRIAR TODOS OS ELEMENTOS

  // Imagem enviada
  const imgElem = document.createElement("img");
  
  // Botão para remover a imagem
  const removerBtn = document.createElement("i");
  removerBtn.classList.add("fa", "fa-times", "fa-2x");
  
  const removerDiv = document.createElement("div");
  removerDiv.classList.add("remover");
  removerDiv.append(removerBtn);
  removerDiv.addEventListener("click", () => {
    imagens.removeChild(imgCont);
  });

  // Container
  const imgCont = document.createElement("div");
  imgCont.classList.add("img-cont")
  imgCont.append(imgElem);
  imgCont.append(removerDiv);

  // Define a fonte da imagem
  imgElem.src = URL.createObjectURL(e.target.files[0]);
  imgElem.onload = () => URL.revokeObjectURL(imgElem.src);
  
  // adiciona o container à lista
  imagemInput.parentElement.before(imgCont);
});