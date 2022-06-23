"use strict";

// Atualiza o <iframe> do Google Maps para mostrar o endereço clicado
function alterarMapa(endereco) {
  const mapa = document.getElementsByTagName("iframe")[0];
  mapa.src = urlMapa + encodeURIComponent(endereco);
}