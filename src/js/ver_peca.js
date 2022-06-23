"use strict";

// Implementa a funcionalidade do carrossel de imagens

const carrossel = document.getElementById("carrossel");
const proxima = document.getElementById("proxima");
const anterior = document.getElementById("anterior");

let id = 0;

proxima.onclick = () => {
  id = (id + 1) % imagens.length;
  carrossel.style.backgroundImage = `url(${imagens[id]})`;
}
anterior.onclick = () => {
  id = (id - 1 + imagens.length) % imagens.length;
  carrossel.style.backgroundImage = `url(${imagens[id]})`;
}