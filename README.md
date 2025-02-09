<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

  # Documentação

## Descrição da Aplicação

### Funcionalidades principais:

- CRUD de Usuários: Permite criar, atualizar, listar e deletar usuários, com controle de acesso baseado em níveis.
- Integração com a API do IBGE: Realiza consultas às localidades brasileiras, como estados e cidades.

### Cache com Redis

Para otimizar o desempenho e reduzir o número de requisições externas, foi implementado um sistema de cache utilizando Redis. O cache é utilizado principalmente para armazenar as respostas da API do IBGE.

- Como funciona:
  - Ao realizar uma consulta na API do IBGE, a aplicação armazena a resposta no Redis por uma hora.
  - Caso a mesma consulta seja realizada novamente dentro do período de cache, a resposta será retornada diretamente do Redis, sem a necessidade de uma nova requisição à API externa.


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
### Testando a API com Insomnia

Opcionalmente, você pode importar o arquivo `Insomnia.json`, localizado na raiz do projeto, no Insomnia para testar as rotas da API.

- Como fazer:
  - Abra o Insomnia.
  - Clique em **Import** >> **Choose Files** >> Scan
  - Selecione o arquivo `Insomnia.json`.
  - Todas as rotas da API estarão disponíveis para teste no Insomnia.


- Caso precise parar os containers, utilize:

```bash
docker-compose down
```

- Para reiniciar o ambiente sem reconstruir as imagens:

```bash
docker-compose up
```

