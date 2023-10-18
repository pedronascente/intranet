# <h1 align="center">Intranet</h1>

<p align="center">Este projeto é um sistema interno, desenvolvido para atender algumas das necessidades da empresa Grupo Volpato, o objetivo é automatizar processos repetidos de alguns setores.</p>

---

## Funções

- Gestão de Usuário
- Gestão de Perfil
- Gestão de Comissões

---

## Pré-requisitos

Para executar este projeto, você precisa ter instalado:



---

## Rodando a Aplicação

Siga os passos abaixo para rodar a aplicação Laravel:

**Passo 1: Clonar o Repositório**

Se você ainda não clonou o repositório do Laravel, use o comando Git para cloná-lo:

bash
git clone https://github.com/pedronascente/intranet.git

Substitua o URL pelo URL real do seu repositório no GitHub.

Passo 2: Instalar Dependências

Navegue até o diretório do projeto Laravel que você acabou de clonar e instale as dependências do Composer:

bash
Copy code
cd seu-repositorio
composer install
Passo 3: Configurar o Arquivo .env

Faça uma cópia do arquivo .env.example e renomeie-o para .env. Configure as informações do banco de dados, como o nome do banco de dados, nome de usuário e senha no arquivo .env.

bash
Copy code
cp .env.example .env
Passo 4: Gerar uma Chave de Aplicação

No Laravel, cada aplicação deve ter uma chave de aplicação única. Você pode gerar uma usando o comando artisan:

bash
Copy code
php artisan key:generate
Passo 5: Executar as Migrações do Banco de Dados

O Laravel utiliza migrações para criar as tabelas do banco de dados. Execute as migrações com o seguinte comando:

bash
Copy code
php artisan migrate
Passo 6: Iniciar o Servidor de Desenvolvimento

Para iniciar um servidor de desenvolvimento, use o comando:

bash
Copy code
php artisan serve
O servidor de desenvolvimento será iniciado em http://localhost:8000. Você pode acessar a aplicação a partir deste endereço.

Passo 7: Acessar a Aplicação

Abra um navegador e acesse http://localhost:8000. Você verá a sua aplicação Laravel funcionando.

Lembre-se de que este é um processo básico para rodar uma aplicação Laravel em um ambiente de desenvolvimento. Dependendo das necessidades do seu projeto, você pode precisar configurar outras variáveis de ambiente, instalar pacotes adicionais e executar tarefas específicas. Certifique-se de consultar a documentação oficial do Laravel para obter informações mais detalhadas.




- ## Técnologia

- [PHP](https://www.php.net/)
- [HTML](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS](https://developer.mozilla.org/en-US/docs/Web/CSS)
- [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
- [Laravel 8](https://laravel.com/)
- [Bootstrap](https://getbootstrap.com/)
- [jQuery](https://jquery.com/)

---

## Autor

Pedro Nascente
