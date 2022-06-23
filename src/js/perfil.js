"use strict";

function alterarMapa(endereco) {
  const mapa = document.getElementsByTagName("iframe")[0];

  mapa.src = urlMapa + encodeURIComponent(endereco);
}