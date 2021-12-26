# Requisitos para rodar o projeto
* Git
* Docker
* Docker-compose

# Tecnologias usadas no projeto
* Docker
* Mysql 8
* Apache2
* PHP 7.4
* Framework Laravel
* Composer

# Instruções para rodar o projeto

1. Faça o clone do projeto.
~~~shell
    git clone git@github.com:ohRobertoCarlos/cadastro-produtos.git
~~~

2. Entre na pasta do projeto:
~~~shell
    cd cadastro-produtos/
~~~

3. Antes de executar o próximo comando, aconselho parar algum banco mysql ou aplicação que esteja usando a porta 3306 para que as portas não entrem em conflito.


4. Na raiz do projeto execute o comando abaixo para baixar as imagens e inicializar os containers:
~~~shell
    docker-compose up -d
~~~

5. Espere o download das imagens e criação dos conteiners.

6. O container do MySQL demora um pouco para inicializar e ficar pronto para conexões, portanto é presico esperar um pouco para que ele fique pronto, mas isso só acontece pela primeira vez que o container é executado.

7. Agora, na raiz do projeto execute o seguinte comando para rodar as migrations (Lembrando que depois que as migrations são executadas não é necessário executá-las novamente):

~~~shell
    docker-compose exec app php artisan migrate
~~~

8. Se ocorrer algum erro de conexão recusada, é bem provável que o mysql ainda não esteja pronto para conexões, aguarde um pouco, dependendo da configuração da sua máquina, pode demorar mais.

9. Acesse o navegador na endereço: [localhost:8000]('http://localhost:8000') para acessar a aplicação.


# Extração de relatórios do banco

## Todos produtos que estão associados a alguma tag

~~~sql
    SELECT t.name AS tags, p.name AS produtos FROM products_tags LEFT JOIN products AS p ON p.id = products_tags.product_id LEFT JOIN tags AS t ON t.id = products_tags.tag_id;
~~~

## Quantidade de produtos associados a cada tag agrupados por categoria

~~~sql
    SELECT t.name AS tags, COUNT(p.name) AS produtos FROM products_tags LEFT JOIN products AS p ON p.id = products_tags.product_id LEFT JOIN tags AS t ON t.id = products_tags.tag_id GROUP BY tags;
~~~

## Quantidade de tags associadas a cada produto
~~~sql
    SELECT COUNT(t.name) AS tags, p.name AS produtos FROM products_tags LEFT JOIN products AS p ON p.id = products_tags.product_id LEFT JOIN tags AS t ON t.id = products_tags.tag_id GROUP BY produtos;
~~~

## Quantidade de tags associadas a cada produto ordenadas pela quantidade de tags em ordem decrescente
~~~sql
    SELECT COUNT(t.name) AS tags, p.name AS produtos FROM products_tags LEFT JOIN products AS p ON p.id = products_tags.product_id LEFT JOIN tags AS t ON t.id = products_tags.tag_id GROUP BY produtos ORDER BY tags desc;
~~~

## Quantidade do maior número de produtos associados a uma tag
~~~sql
    SELECT MAX(produtos) AS tag_mais_produtos FROM (SELECT t.name AS tags, COUNT(p.name) AS produtos FROM products_tags LEFT JOIN products AS p ON p.id = products_tags.product_id LEFT JOIN tags AS t ON t.id = products_tags.tag_id GROUP BY tags) AS t;
~~~

## Todos os produtos

~~~sql
    SELECT * FROM products;
~~~

## Todas as tags

~~~sql
    SELECT * FROM tags;
~~~
