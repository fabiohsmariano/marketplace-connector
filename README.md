# Marketplace connector

Este projeto serve como um ponto de integração entre diferentes sistemas, atuando como um conector de marketplace. A aplicação recebe solicitações de importação de anúncios, processa essas solicitações, consulta os anúncios no marketplace especificado e, por fim, envia os dados coletados para um hub centralizado.

Obs.: O README foi escrito visando a execução do projeto em máquinas **Linux**.

## Setup do projeto 🚀

### Inicialização

Para começar, instale as dependências do projeto executando o seguinte comando:

```
composer install
```

Com as dependências instaladas, execute o seguinte comando para iniciar o projeto:

```
sudo make start
```

Após os containers serem iniciados, a aplicação pode ser acessada em http://localhost.

Agora, é necessário iniciar o container do mock da API. Para isso, execute o seguinte comando:

```
sudo make start-mock
```

Pronto! Agora basta enviar uma requisição POST (com o corpo da requisição vazio) para a url http://localhost/api/imports para agendar a importação de anúncios.

## Construído com

* [PHP](https://www.php.net/)
* [Laravel](https://laravel.com/)
* [Laravel Sail](https://laravel.com/docs/11.x/sail)
* [MySQL](https://www.mysql.com/)
* [Redis](https://redis.io/)
* [Docker](https://www.docker.com/)
