export default async function env(variavel) {
  const resposta = await fetch(`php/get_env.php?var=${variavel}`);
  return await resposta.text();
}