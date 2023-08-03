Para subir o projeto, realizar as seguintes etapas:

    - renomear o .env.example para .env;
    
    - definir as configurações do banco de dados no .env;
    
    - subir o projeto:
    
        - make up (irá rodar o comando ./vendor/bin/sail up -d).
        
    - instalar as dependencias:
    
        - docker-compose exec facil.consulta composer install

    - rodar as migrations:
    
        - docker-compose exec facil.consulta php artisan migrate

    - rodar as seeders:
    
        - docker-compose exec facil.consulta php artisan db:seed

Para acessar o projeto, utilizar a seguinte url -> http://localhost:8083
