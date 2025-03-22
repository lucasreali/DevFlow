# DevFlow

DevFlow é uma ferramenta de gerenciamento de sprints e integração com GitHub, desenvolvida para facilitar o fluxo de trabalho de desenvolvedores, oferecendo funcionalidades como logs de commits e organização de tarefas em um sistema semelhante ao Trello.

## Comandos Necessários

Antes de rodar o projeto, é necessário configurar o ambiente e instalar as dependências. Aqui estão os comandos principais que você deve usar:

### 1. Instalar Dependências
```bash
composer install
```

### 2. Atualizar Dependências
```bash
composer du
```

### 3. Baixar biblioteca de variaveis de ambiente
```bash
composer require vlucas/phpdotenv
```

### 4. Rodar o Servidor
```bash
composer start
``` 


## Variaveis de Ambiente

Renomear o arquivo ``.env.exemple`` para ``.env`` e ajustar as informações sobre o banco de dados

```
DB_HOST=localhost:3306
DB_NAME=meu_banco
DB_USER=root
DB_PASS=minha_senha
```
## Integração com GitHub

Para configurar a integração com o GitHub, siga os passos abaixo:

1. Acesse as configurações do GitHub e vá até o último tópico chamado **Developer Settings**.
2. Dentro de **Developer Settings**, selecione **OAuth Apps** e clique em **New OAuth App** para criar um novo aplicativo.
3. Preencha os campos obrigatórios:
    - **Homepage URL**: `http://127.0.0.1:8000`
    - **Authorization callback URL**: `http://localhost:8000/callback`
4. Após criar o OAuth App, você receberá um **Client ID** e um **Client Secret**. Esses valores devem ser adicionados ao arquivo `.env` do projeto:

```
GITHUB_CLIENT_ID=seu_client_id
GITHUB_CLIENT_SECRET=seu_client_secret
```

Com isso, o DevFlow estará configurado para autenticar usuários e interagir com o GitHub.

## Estrutura de Roteamento e Lógica do DevFlow

O **DevFlow** segue uma arquitetura MVC (Model-View-Controller) e utiliza middlewares para gerenciar o fluxo de requisições. Aqui está uma explicação de como cada parte do sistema funciona.

### 1. **Rotas (Routes)**

As rotas são responsáveis por direcionar as requisições para os respectivos controladores e ações. Elas estão localizadas na pasta `routes` e são definidas no arquivo `web.php`. O arquivo contém as rotas principais da aplicação.

- **Exemplo de definição de rota em `web.php`:**

```php
use App\Controllers\UserController;

Router::get('home', function () {
    return view('home', ['title' => 'Página inicial']); // Retorna a pagina home com um valor atribuida à variavel $title que pode ser usada na view
})

Router::get('/dashboard', function () {
    AuthMiddleware::handle(); // Só permite acessar a pagina com o usuario logado
    return view('dashboard') // Retorna a pagina dashboard em app/Views
 });

Router::post('/login', [AuthController::class, 'login']); // Chama a classe AuthController e seu método login

```

Cada rota é composta por:

- Método HTTP (GET, POST, UPDATE, DELETE)
- URL (exemplo: /dashboard)
- Controlador (exemplo: UserController::class)
- Método do Controlador (exemplo: dashboard)

Quando uma requisição é feita para a URL definida, a aplicação irá procurar pelo controlador e chamar o método correspondente.

### 2. Controladores (Controllers)

Os controladores contêm a lógica de negócio e são responsáveis por manipular os dados e retornar a resposta correta para o usuário. Eles estão localizados na pasta ``app/Controllers``.
- **Exemplo de Controlador (UserController.php):**
```php
namespace App\Controllers;

use Core\Database;

class AuthController
{
    public static function login()
    {
        // Lógica para obter informações do usuário
        $name = $_GET['name'];
        // Exemplo de verificação simples
        if ($name == 'admin') {
            // Usuário autenticado
            return view('dashboard');
        }
        
        return view('login', ['error' => 'Usuário ou senha inválidos.']);
    }
}
```

### 3. Modelos (Models)

Os modelos são responsáveis por interagir com o banco de dados e representar as entidades da aplicação. Eles estão localizados na pasta `app/Models`. Cada modelo geralmente corresponde a uma tabela no banco de dados e contém métodos para realizar operações como criação, leitura, atualização e exclusão de registros (CRUD).

- **Exemplo de Modelo (User.php):**
```php
namespace App\Models;

use Core\Database;

class User
{
    public static create($name, $email, $password) {
        // logica ...
    }

    public static read($user_id) {
        // logica ...
    }

    public static update($user_id, $content) {
        // logica ...
    }

    public static delete($user_id) {
        // logica ...
    }
}
```

Cada modelo contém:

Os modelos permitem que a aplicação manipule os dados de forma estruturada e organizada, seguindo os princípios da arquitetura MVC.
a
