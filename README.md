# 🧠 Desafio Técnico – Vue.js + Backend JWT

## 🚀 Sobre o projeto
Breve descrição da sua solução.

## 🏗️ Stack utilizada
- Frontend: Vue.js 3 + TypeScript + Tailwind
- Backend: Laravel
- Banco de dados: sqlite

## 🔧 Como executar
### Backend + FrontEnd
```bash
cd backend
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan jwt:secret
composer run dev
```

## 🧩 Observações
- Descreva aqui as decisões técnicas importantes;
- Caso tenha usado IA, mencione em quais partes e por quê.

Bem, foi a primeira vez que usei Laravel, já tive bastante experiencia com PHP backend com render de html/js então foi até tranquilo pegar o jeito.
 Muito bacana a forma com que o Laravel comunica com o vue.js, principalmente na questão das rotas.

Utilizei PrimeVue que é uma biblioteca de componentes que utilizo em quase todos os meus projetos, também utilizei o tailwindcss para estilização via classes.

A IA foi utilizada em um momento onde o projeto não estava rodando, e ela me ajudou a descobrir que eu tinha que ativar as extensões do sqlite no php.ini.
Também tenho o copilot instalado no vscode, então sugestões de código foram utilizadas em algumas linhas, basicamente a IA foi utilizada exclusivamente como ferramenta de produtividade nesse caso.

Segui a documentação do laravel, então o inertiajs foi usado para administrar as rotas do vue, foi a primeira vez que utilizei então não sei se implementei da melhor forma.


## 💡 Melhorias futuras
- Criar um interceptor de html no front, para administrar melhor o token/refresh-token
- Implementar refresh token no backend
- Adicionar feedback melhor de loading nas telas 
- Criar cache local de votos para impedir o reload de todas as ideias ao votar
- Implementar paginação no backend e no frontend
