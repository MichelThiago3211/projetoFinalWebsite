"use strict";

export default async function env(variavel) {
  const resposta = await fetch(`php/get_env?var=${variavel}`);
  return await resposta.text();
}