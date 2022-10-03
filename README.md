# WK Technology - Teste para preenchimento da vaga de desenvolvedor FullStack

<br />

## Considerações gerais

Neste teste técnico as tecnologias escolhidas foram **PHP 8.1** (backend), **MySQL 8** (SGBD), **Angular 14** (Frontend).
Também foram utilizados **Composer**, para viabilizar a utilização de bibliotecas de terceiros, e **Docker**, a fim de evitar problemas por motivo de divergências em configurações de máquinas ou ambientes de desenvolvimento e teste.
O **Symfony 6.1** foi escolhido como framework para o desenvolvimento da API, enquanto o **Bootstrap 4.1**, para guiar o desenvolvimento da UI - neste quesito, utilizei um tema chamado Flacto, do qual possuo a devida licença, adquirida através do site *https://wrapbootstrap.com*.

<br />

## Guia de instalação
Você deve ter o **Docker** e o **Docker-Compose** instalados;

1. Certifique-se de que as portas 8080 e 3306 não estão em uso na sua máquina (ou mude as portas no arquivo docker-compose.yaml);
2. Clone o repositório;
3. Via linha de comando, execute os seguintes comandos:
    1. *docker network create wktech-network*;
    2. *docker-compose up --build -d*;
4. Instale as dependências de terceiros via **Composer** (*composer install*) - este passo pode ser executado direto do *container* de aplicação, caso você não tenha o **Composer** instalado na sua máquina;
5. Acesse a aplicação em seu navegador pela url: ***http://localhost:8080***;

## Detalhes da implementação
1. Validações dos dados de entrada (forms) realizadas tanto do lado do cliente (Frontend), quanto do servidor (Backend). Esta última faz uso das *Constraints* e *Violations* do Symfony;
2. O ambiente de desenvolvimento do Frontend faz uso de um proxy para evitar problema de **CORS**, isto é, requisições enviadas da aplicação Angular na porta 4200 para o servidor Docker/NginX/PHP/Symfony, na 8080, são roteadas. Para habilitar o seu uso, basta iniciar o ambiente Angular com o comando "*npm start*", que já está configurado para fazer uso do Proxy, ao invés do "*ng serve*";
3. As mensagens enviadas pela API fazem uso do sistema de tradução do Symfony.
4. O desenvolvimento dos códigos de ambas as aplicações foi feito seguindo os princípios e conceitos de *SOLID* e *Clean Code*;
5. A API implementa o padrão *RESTFul* e faz o uso correto dos respectivos verbos HTTP e do padrão de nomenclatura dos *endpoints* para cada *resource*.