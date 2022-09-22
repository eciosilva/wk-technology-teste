# WK Technology - Teste para preenchimento da vaga de desenvolvedor FullStack
Neste teste técnico as tecnologias escolhidas foram PHP 8.1 (backend), MySQL 8 (SGBD), Angular (Frontend).
Também foram utilizados Composer e Docker, a fim de evitar problemas de compatibilidade por motivo de divergências em configurações de máquinas ou ambientes de desenvolvimento.
O Symfony 6.1 foi escolhido como framework para o desenvolvimento da API.

## Guia de instalação
Você deve ter o **Docker** e o **Docker-Compose** instalados;

1. Certifique-se de que as portas 8080 e 3306 não estão em uso na sua máquina (ou mude as portas no arquivo docker-compose.yaml);
2. Clone o repositório;
3. Via linha de comando, execute os seguintes comandos:
    1. *docker network create wktech-network*;
    2. *docker-compose up --build -d*;
4. Instale as dependências de terceiros via **Composer** (*composer install*);
5. Acesse a aplicação em seu navegador pela url: ***http://localhost:8080***;