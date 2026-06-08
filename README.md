# Portal do Aluno

Sistema web para gerenciamento acadêmico desenvolvido em PHP e MySQL.

## Funcionalidades

* Login de Alunos
* Login de Professores
* Login de Administradores
* Gestão de Avisos
* Consulta de Notas
* Consulta de Frequência
* Área Acadêmica
* Painel Administrativo
* Controle de Usuários

## Tecnologias Utilizadas

* PHP 8+
* MySQL
* HTML5
* CSS3
* JavaScript
* Bootstrap
* XAMPP

## Instalação

1. Clone o repositório:

```bash
git clone https://github.com/Thales-uft2022-2/Portal-Aluno-Demo.git
```

2. Importe o banco de dados:

```sql
database/portal-aluno-demo.sql
```

3. Configure a conexão com o banco em:

```php
config/database.php
```

4. Inicie o Apache e MySQL.

5. Acesse:

```text
http://localhost/Portal-Aluno-Demo
```

## Estrutura do Projeto

* auth/ → autenticação
* admin/ → painel administrativo
* academic/ → funcionalidades acadêmicas
* dashboard/ → painel principal
* config/ → configurações do sistema
* database/ → scripts SQL

## Autor

Thales Marques Rodrigues

## Licença

Projeto desenvolvido para fins acadêmicos e educacionais.