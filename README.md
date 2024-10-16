# Projeto de Gerenciamento de Projetos e Tarefas - Laravel 11

Este é um sistema de gerenciamento de projetos e tarefas desenvolvido com Laravel 11. A aplicação segue os princípios SOLID, como "Responsabilidade Única" e "Inversão de Dependência", utilizando uma camada de serviços para lógica de negócios, repositórios para gerenciamento de dados, além de eventos e documentação gerada com Swagger. Os testes unitários foram implementados utilizando o Pest.

---

## Instalação e Configuração

Siga os passos abaixo para instalar e executar o projeto localmente.

### 1. Clonar o Repositório

```bash
git clone https://github.com/renatodlm/ip4y-task-manager
```

### 2. Configurar o Ambiente

Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário:

```bash
cp .env.example .env
```

### 3. Instalar Dependências

Instale as dependências do projeto utilizando o Composer:

```bash
composer install
```

### 4. Gerar a Chave da Aplicação

Gere a chave da aplicação Laravel:

```bash
php artisan key:generate
```

### 5. Configurar o Banco de Dados

Atualize as variáveis de ambiente do banco de dados no arquivo `.env` e execute as migrações:

```bash
php artisan migrate
```

### 6. Executar a Aplicação

Inicie o servidor local do Laravel:

```bash
php artisan serve
```

Iniciar o Redis:

```bash
sudo service redis-server start
redis-cli ping

```

---

## Estrutura de Diretórios

A estrutura do projeto está organizada de forma modular, facilitando a manutenção e escalabilidade. Abaixo estão os principais diretórios e seus respectivos arquivos:

### `app/Http/Controllers/`

-   **`ProjectController.php`**: Gerencia operações de criação, atualização, listagem e remoção de projetos.
-   **`TaskController.php`**: Gerencia tarefas e suas atribuições a usuários, além de atualizações.

### `app/Http/Requests/`

-   **`ProjectRequest.php`**: Define as regras de validação para as operações relacionadas a projetos.
-   **`TaskRequest.php`**: Define as regras de validação para operações com tarefas.

### `app/Http/Resources/`

-   **`ProjectResource.php`**: Formata os dados dos projetos para serem retornados como JSON.
-   **`TaskResource.php`**: Formata os dados das tarefas em formato JSON.

### `app/Interfaces/`

-   **`ProjectServiceInterface.php`**: Define a interface para o serviço de gerenciamento de projetos.
-   **`ProjectRepositoryInterface.php`**: Interface para o repositório de projetos.
-   **`TaskServiceInterface.php`**: Interface para o serviço de gerenciamento de tarefas.
-   **`TaskRepositoryInterface.php`**: Interface para o repositório de tarefas.

### `app/Services/`

-   **`ProjectService.php`**: Implementa a lógica de negócios relacionada a projetos.
-   **`TaskService.php`**: Implementa a lógica de gerenciamento de tarefas, incluindo notificações.

### `app/Repositories/`

-   **`ProjectRepository.php`**: Lida com a persistência dos dados de projetos no banco de dados.
-   **`TaskRepository.php`**: Gerencia a persistência de dados das tarefas no banco de dados.

### `app/Models/`

-   **`Project.php`**: Modelo que representa a entidade Projeto.
-   **`Task.php`**: Modelo que representa a entidade Tarefa.

---

## Detalhes dos Serviços

Os serviços no projeto seguem os princípios SOLID, em especial o princípio de "Inversão de Dependência", utilizando interfaces para garantir a abstração e independência da lógica de implementação dos repositórios. Aqui estão os principais serviços e suas responsabilidades:

-   **`ProjectService.php`**: Controla a lógica de criação, atualização, listagem e remoção de projetos, assim como a geração de relatórios.
-   **`TaskService.php`**: Gerencia as tarefas, incluindo a lógica de notificação para os usuários.

---

## Configuração do Pest

O **Pest** é um framework de testes PHP simples e poderoso, que oferece uma sintaxe mais limpa do que outros frameworks tradicionais.

### Passos para Instalar o Pest

1. **Instalar o Pest via Composer**

    Execute o comando abaixo para adicionar o Pest como dependência de desenvolvimento no Laravel:

    ```bash
    composer require pestphp/pest --dev
    ```

2. **Instalar o Pest para Laravel**

    Após instalar o Pest, execute o seguinte comando para integrar o Pest ao Laravel:

    ```bash
    php artisan pest:install
    ```

    Esse comando irá configurar os diretórios de testes e gerar arquivos necessários para o funcionamento do Pest.

3. **Executar os Testes com Pest**

    Para rodar os testes, basta executar o seguinte comando:

    ```bash
    ./vendor/bin/pest
    ```

---

## Testes com Pest

Este projeto utiliza o **Pest** como framework para testes unitários. Ele oferece uma sintaxe mais fluida e simples para escrever e manter os testes.

### Como Executar os Testes

Para rodar todos os testes unitários, execute o seguinte comando:

```bash
./vendor/bin/pest
```

Os testes abrangem toda a lógica de negócios, garantindo que a aplicação funcione corretamente e que as principais funcionalidades, como a criação de projetos e tarefas, estejam validadas.

---

## Swagger para Documentação de API

A documentação da API foi gerada utilizando **Swagger**, permitindo uma visualização clara dos endpoints disponíveis, juntamente com os parâmetros esperados e os formatos de resposta.

---

## Configuração do SQL Server no Docker

Agora vamos configurar o SQL Server no Docker. Utilize o seguinte arquivo `docker-compose.yml` para configurar um contêiner SQL Server no Docker:

```yaml
version: "3.8"

services:
    sqlserver:
        image: mcr.microsoft.com/mssql/server:2019-latest
        container_name: sqlserver
        environment:
            - ACCEPT_EULA=Y
            - SA_PASSWORD=\${SA_PASSWORD}
        ports:
            - "1433:1433"
        networks:
            - sqlserver-network
        volumes:
            - sqlserver-data:/var/opt/mssql

networks:
    sqlserver-network:

volumes:
    sqlserver-data:
```

### Passos para Configurar o SQL Server

1. **Atualizar as Variáveis de Ambiente**

    No seu arquivo `.env`, adicione a variável `SA_PASSWORD` com a senha para o administrador do SQL Server. Por exemplo:

    ```bash
    SA_PASSWORD=SeuPasswordSeguro123
    ```

2. **Subir o Contêiner do SQL Server**

    Execute o comando abaixo para iniciar o SQL Server no Docker:

    ```bash
    docker-compose up -d
    ```

3. **Conectar o Laravel ao SQL Server**

    Atualize as configurações de banco de dados no arquivo `.env` para utilizar o SQL Server:

    ```bash
    DB_CONNECTION=sqlsrv
    DB_HOST=sqlserver
    DB_PORT=1433
    DB_DATABASE=nome_do_banco
    DB_USERNAME=sa
    DB_PASSWORD=\${SA_PASSWORD}
    ```

---
