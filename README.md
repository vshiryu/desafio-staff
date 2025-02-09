<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

  # Documentação

## Requisitos
Antes de começar, certifique-se de que você tem os seguintes itens instalados em sua máquina:

- **Docker** (versão mais recente)
- **Docker Compose** (versão 3.8 ou superior)

## Passos para Configuração

- Faça o clone deste repositório para sua máquina local:

```bash
git clone <URL_DO_REPOSITORIO>
cd <NOME_DO_REPOSITORIO>
```

- Copie o arquivo de exemplo `.env.example` para `.env`:

```bash
cp .env.example .env
```

- Execute o seguinte comando para construir as imagens Docker e subir os containers:

```bash
docker-compose up --build
```

Este comando irá:
- Construir a imagem da aplicação Laravel.
- Subir os containers da aplicação, banco de dados e Redis.

- Após concluir cesse a aplicação no navegador utilizando o endereço:

```
http://localhost:8080
```

- Acesse a documentação em:

```
http://localhost:8080/docs/api
```

- Caso precise parar os containers, utilize:

```bash
docker-compose down
```

- Para reiniciar o ambiente sem reconstruir as imagens:

```bash
docker-compose up
```

