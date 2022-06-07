const campoArquivos = document.querySelectorAll("input[type=file]");

campoArquivos.forEach((campo) => {
  campo.onchange = () => validarTamanho(campo);
  validarTamanho(campo);
});

function validarTamanho(campo) {
  const tamanhoMaximo = campo.previousElementSibling.value;
  const descricaoTamanho = (tamanhoMaximo / 1024**2).toFixed(2);

  if(campo.files[0].size > tamanhoMaximo){
    campo.setCustomValidity("O arquivo deve ter no máximo " + descricaoTamanho + " Megabytes");
  }
  else {
    campo.setCustomValidity("");
  }
}