**AutoTech Pro**

Sistema web de gestão para oficinas mecânicas desenvolvido com PHP e Laravel. Permite controle completo de ordens de serviço, estoque de peças, cadastro de clientes e veículos, e consulta à Tabela FIPE.

---

**Tecnologias**

- PHP 8.1 + Laravel 10
- MySQL
- Bootstrap 5
- API FIPE (parallelum.com.br)

---

**Como rodar o projeto**

1. Clone o repositório
2. Execute `composer install`
3. Copie o `.env.example` para `.env` e configure o banco de dados
4. Execute `php artisan key:generate`
5. Rode o SQL em `database/create_database.sql` no MySQL
6. Execute `php artisan serve`
7. Acesse `http://localhost:8000`

Login inicial: `teste@autotech.com` — Senha: `password`

---

**Funcionalidades**

- Login com controle de acesso por cargo
- Ordens de serviço com fluxo completo de status
- Upload de fotos de entrada e saída dos veículos
- Garantia automática de 90 dias ao entregar o veículo
- Estoque de peças com alerta de quantidade baixa
- Consulta à Tabela FIPE por marca, modelo e ano

Projeto escolar — AutoTech Pro v1.0 — 2026