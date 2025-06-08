# 🐄 Cow Health Web
Interface web do sistema Cow Health AI, focado no monitoramento da saúde de vacas através de sensores inteligentes.

## 📋 Requisitos
- Docker e Docker Compose instalados
- Git instalado
- make instalado (caso contrário, instale via sudo apt install make ou equivalente)

## 🚀 Instalação
Siga os passos abaixo para clonar e configurar o projeto:

```bash
# Clone o repositório
git clone https://github.com/Cow-Health-AI/cow-health-web.git

# Acesse o diretório do projeto
cd cow-health-web

# Suba os containers em modo desacoplado
docker compose up -d
```

# 🔧 Configuração
```bash
# Renomeie o arquivo de variáveis de ambiente
mv .env.example .env

# Instale as dependências PHP
composer install

# Execute o comando de configuração geral
make all
```

## ⚠️ Erro "make: command not found"
Instale o make com:

```bash
sudo apt install make      # Debian/Ubuntu
sudo dnf install make      # Fedora
brew install make          # macOS
```

# 🛠 Solução de Problemas
Se o container do MySQL falhar ao subir:

```bash
# Pare e remova volumes
docker compose down -v

# Recrie os containers
docker compose up --build
```

# 💻 Acesso ao container PHP e Instalação de dependências do frontend

```bash
# Entre no container PHP
make p

# Instale as dependências do frontend
npm install

# Compile os assets do frontend
npm run build
```

# ⚙️ Otimização e migração
```bash
# Otimize a aplicação
php artisan optimize

# Rode as migrações com seed
php artisan migrate --seed
```

# 📡 Conexão MQTT
Para conectar a aplicação com o sistema embarcado via MQTT, abra dois terminais diferentes e execute os seguintes comandos:

```bash
# Faz o subscribe no tópico e ouve os dados
php artisan listen:mqtt

# Executa os jobs
php artisan queue:work
```

# ✅ Acesso ao sistema
Abra seu navegador e acesse:

```arduino
http://localhost
```
Login de administrador padrão:

- Email: admin@admin.com
- Senha: admin1234

