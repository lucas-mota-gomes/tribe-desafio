# 🧩 Desafio Técnico – Vue.js (TypeScript) + Backend com API JWT

## 🎯 Objetivo
Avaliar:
- Proficiência real em **Vue.js + TypeScript**;  
- Capacidade de projetar e consumir uma **API segura (JWT)**;  
- Organização, clareza e criatividade;  
- Capacidade de tomar boas decisões técnicas e justificar escolhas.

> 💡 **Sugerimos não usar ferramentas de IA** para gerar código.  
> O foco do teste é avaliar **sua lógica, clareza de raciocínio e estilo pessoal de implementação**.  
> Caso utilize IA em alguma etapa, descreva isso claramente no README.

---

## 🧱 Contexto: “IdeiaLab”
Crie uma aplicação chamada **IdeiaLab**, onde usuários podem **cadastrar ideias** e **votar** nas ideias de outros usuários.

---

## ⚙️ Requisitos técnicos obrigatórios

### 🔒 1. Autenticação JWT
- Implementar autenticação com **JSON Web Tokens (JWT)**.  
- Fluxo básico:
  - Registro (`POST /api/register`)
  - Login (`POST /api/login`)
  - Logout (`POST /api/logout`)
  - Acesso autenticado com header:
    ```
    Authorization: Bearer <token>
    ```
- Recomendado: biblioteca `tymon/jwt-auth` para Laravel.

### 💡 2. CRUD de Ideias
- Campos: `id`, `titulo`, `descricao`, `autor_id`, `created_at`, `updated_at`
- Regras:
  - Apenas o autor pode editar/excluir suas ideias;
  - Todos os usuários autenticados podem listar e visualizar ideias.

Endpoints esperados:
```
GET    /api/ideias
POST   /api/ideias
GET    /api/ideias/{id}
PUT    /api/ideias/{id}
DELETE /api/ideias/{id}
```

### 👍 3. Votação
- Um usuário pode **votar uma única vez por ideia**;
- Endpoint sugerido:
  ```
  POST /api/ideias/{id}/votar
  ```
- Deve retornar a contagem atualizada de votos.

### 💻 4. Frontend (Vue.js + TypeScript)
- Construído com **Vue 3**, **TypeScript**, **Vue Router** e **Pinia** (ou Composition API);
- Comunicação com a API via **Axios**;
- Deve conter:
  - Login / Registro
  - Listagem de ideias
  - Criação / Edição de ideias
  - Perfil / Logout
- Interface funcional e responsiva (TailwindCSS é bem-vindo).

---

## 🧰 Backend
- O **backend Laravel é opcional**, mas **valerá mais pontos**.  
- Caso prefira outra stack (Node/NestJS, Adonis, Django, FastAPI, Go, etc.), é permitido — desde que:
  - Use **JWT** para autenticação;
  - Exponha uma **API REST funcional** com os mesmos endpoints.

> 💬 O uso do **Laravel com JWT** será valorizado por refletir a stack principal da empresa.

---

## 💡 Diferenciais criativos (opcionais)
- Busca e filtro de ideias;
- Indicação visual se o usuário já votou;
- Ranking de ideias mais votadas;
- Atualização em tempo real (Broadcasting / Polling);
- Layout moderno e responsivo.

---

## 📦 Entrega
Entregar via **repositório Git público** (GitHub, GitLab ou Bitbucket).

O repositório deve conter:
1. **Frontend Vue + TypeScript**;  
2. **Backend (Laravel ou outro)**;  
3. Arquivo **README.md** com:
   - Instruções de instalação e execução;
   - Stack utilizada e justificativas técnicas;
   - Caso tenha usado IA, descreva onde e como;
   - O que faria diferente se tivesse mais tempo.

---

## ⏱️ Prazos
- O teste deve ser **realizado durante o fim de semana**;  
- Entrega até **segunda-feira, às 9h da manhã**;  
- Tempo estimado de execução: **4 a 6 horas**.

---

## 📋 Critérios de Avaliação

| Categoria | Peso | O que será avaliado |
|------------|------|--------------------|
| **Frontend (Vue + TS)** | 40% | Organização, componentização, tipagem, integração com API |
| **Backend (Laravel + JWT)** | 30% | Clareza, segurança, estrutura da API e modelagem |
| **UX / Design** | 15% | Usabilidade, estética e responsividade |
| **Documentação / Clareza** | 10% | Qualidade do README, explicações e decisões técnicas |
| **Criatividade e visão de produto** | 5% | Funcionalidades extras e refinamento |

> ⚠️ O uso de **Laravel** no backend soma **pontos extras**.  
> Códigos claramente gerados por IA sem entendimento demonstrado **podem ser desconsiderados**.

---

## 💬 Durante a entrevista
Após a entrega, o candidato poderá ser convidado a explicar:
1. Como implementou a autenticação JWT;
2. Como protegeu as rotas no frontend;
3. O motivo das principais escolhas técnicas;
4. Como ampliaria ou otimizaria o sistema.
