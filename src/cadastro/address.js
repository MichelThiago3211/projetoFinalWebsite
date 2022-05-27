"use strict";

import { Debouncer } from "./debounce.js";

const addressInput = document.getElementById("endereco");
const addressSuggestionsDiv = document.getElementById("sugestoes-endereco");

const ADDRESS_AUTOCOMPLETE_URL = "https://api.geoapify.com/v1/geocode/autocomplete?text=#&apiKey=f62b5fe78b08493c995352735ed8bfd3";

async function updateAddressSuggestions() {
  const url = ADDRESS_AUTOCOMPLETE_URL.replace("#", addressInput.value);
  const suggestions = await (await fetch(url)).json();

  clearAddressSuggestions();

  for (let suggestion of suggestions.features) {
    if (suggestion.properties.result_type != "building") continue;

    const elem = document.createElement("span");
    elem.onclick = () => {
      addressInput.value = elem.innerHTML;
    }
    elem.innerHTML = suggestion.properties.formatted;
    addressSuggestionsDiv.append(elem);
  }
}

const inputDebouncer = new Debouncer(updateAddressSuggestions, 500);
addressInput.addEventListener("input", () => {
  if (addressInput.value.trim() == "") {
    closeAddressSuggestions();
    return;
  }

  showAddressSuggestions();
  inputDebouncer.invoke();
});

const blurDebouncer = new Debouncer(closeAddressSuggestions, 1000);
addressInput.addEventListener("blur", blurDebouncer.getInvoker());

function closeAddressSuggestions() {
  addressSuggestionsDiv.style.display = "none";
}
function showAddressSuggestions() {
  addressSuggestionsDiv.style.display = "flex";
  addressSuggestionsDiv.innerHTML = "<span>carregando...</span>";
}
function clearAddressSuggestions() {
  addressSuggestionsDiv.innerHTML = "";
}