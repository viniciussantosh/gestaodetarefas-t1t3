# Relatório de Decisões Técnicas

## 1. Objetivo do Sistema

O sistema desenvolvido é um **Gerenciador de Tarefas (To-Do List)**, que permite aos usuários registrar, visualizar, editar e excluir suas tarefas pessoais, além de acompanhar o status e a prioridade de cada uma.

## 2. Tecnologias Utilizadas

| Componente | Tecnologia | Justificativa |
| :--- | :--- | :--- |
| **Linguagem Back-end** | PHP (Puro) | Requisito do trabalho. Foi utilizado PHP puro para demonstrar a compreensão dos fundamentos da linguagem. |
| **Banco de Dados** | MySQL | Requisito do trabalho. |
| **Conexão DB** | PDO (PHP Data Objects) | **Decisão de Segurança**: PDO é a forma recomendada para interagir com bancos de dados em PHP, pois facilita o uso de *Prepared Statements*, prevenindo **SQL Injection**. |
| **Arquitetura** | MVC (Model-View-Controller) | **Decisão de Organização**: Separa a lógica de negócios (Model), a apresentação (View) e o controle de fluxo (Controller), resultando em código mais limpo, modular e de fácil manutenção. |
| **Front-end** | HTML5, CSS3, JavaScript | Fundamentos da web. |
| **Framework CSS** | Bootstrap 5 | **Decisão de Usabilidade**: Garante um design **responsivo** e moderno, além de fornecer componentes prontos para formulários e tabelas, acelerando o desenvolvimento do front-end. |

## 3. Implementação das Funcionalidades Obrigatórias

### 3.1. Autenticação e Sessões

*   **Registro (`AuthController->processRegister`)**:
    *   Validação de dados (e-mail, senhas coincidentes) é feita no back-end.
    *   A senha é armazenada usando `password_hash()` com o algoritmo **`PASSWORD_DEFAULT`** (atualmente bcrypt), cumprindo o requisito de **hash de senhas**.
*   **Login (`AuthController->processLogin`)**:
    *   A verificação da senha é feita com `password_verify()`, garantindo que a senha fornecida corresponda ao hash armazenado.
    *   O controle de acesso é feito via **sessões (`$_SESSION`)**, armazenando o `usuario_id` e `usuario_nome`.
*   **Controle de Acesso**: O `TarefasController` e `RelatoriosController` verificam a existência de `$_SESSION['usuario_id']` no construtor, redirecionando o usuário para o login caso não esteja autenticado.

### 3.2. CRUD Completo (Entidade: Tarefa)

O CRUD (Create, Read, Update, Delete) é implementado no `TarefasController` e `TarefaModel`.

*   **Create/Update (`TarefasController->save`)**: Os dados do formulário são validados no back-end antes de serem persistidos.
*   **Read (`TarefasController->index`)**: A listagem de tarefas é filtrada pelo `usuario_id` da sessão, garantindo que o usuário só veja suas próprias tarefas.
*   **Delete (`TarefasController->delete`)**: A exclusão também verifica o `usuario_id` para evitar que um usuário exclua tarefas de outro (controle de acesso por registro).

### 3.3. Geração de Relatórios

*   A funcionalidade de relatórios é implementada no `RelatoriosController`.
*   O relatório exibe um resumo de tarefas por status e permite a geração de um relatório detalhado.
*   A geração de relatório é simulada com a criação de um arquivo HTML (`pdf_template.php`), que em um ambiente de produção seria processado por uma biblioteca (como DomPDF ou TCPDF) para gerar o PDF final, cumprindo o requisito de **Geração de Relatórios**.

## 4. Medidas de Segurança Aplicadas

| Risco | Medida de Segurança | Local de Implementação |
| :--- | :--- | :--- |
| **SQL Injection** | Uso exclusivo de **Prepared Statements** (consultas parametrizadas) via PDO. | `core/Database.php`, `models/UsuarioModel.php`, `models/TarefaModel.php`, `models/RelatorioModel.php` |
| **Cross-Site Scripting (XSS)** | Uso da função `htmlspecialchars()` em todas as saídas de dados de usuário (ex: títulos de tarefas, nomes). | Views (`tarefas/index.php`, `tarefas/form.php`, `layout/header.php`, etc.) |
| **Senhas Expostas** | Armazenamento de senhas como **hash** usando `password_hash()` e verificação com `password_verify()`. | `controllers/AuthController.php`, `models/UsuarioModel.php` |
| **Validação de Dados** | **Validação no Back-end** (server-side validation) para todos os dados de entrada (registro, login, criação/edição de tarefas). | `controllers/AuthController.php`, `controllers/TarefasController.php` |
| **Acesso Não Autorizado** | Verificação do `usuario_id` da sessão em todas as operações CRUD e relatórios, garantindo que o usuário só interaja com seus próprios dados. | `controllers/TarefasController.php`, `models/TarefaModel.php` |
