# lbaw24112
4NSWERS

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)


- **Project name:** lbaw24112 - 4NSWERS
- **Short description:** Q&A 
- **Environment:** Linux
- **Tools:** Laravel, Tailwind
- **Institution:** [FEUP](https://sigarra.up.pt/feup/en/web_page.Inicial)
- **Course:** [LBAW](https://sigarra.up.pt/feup/en/ucurr_geral.ficha_uc_view?pv_ocorrencia_id=541888) (Database and Web Applications Laboratory)
- **Project grade:** TBD
- **Group members:**
    - Afonso Castro (up202208026@fe.up.pt)
    - Leonor Couto (up202205796@fe.up.pt)
    - Pedro Santos (up202205900@fe.up.pt)
    - Rodrigo de Sousa (up202205751@fe.up.pt)

[YouTube](https://youtu.be/0Zd8gBMzRcQ)
---

## Instructions to run the project

### Through the project's docker image

Login to docker registry and start the container:
```bash
docker login gitlab.up.pt:5050

docker run -d --name lbaw24112 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24112
```

### Or alternatively, run it locally

```bash
git clone https://github.com/rodeso/lbaw.4nswers/

composer install
php artisan config:clear
php artisan clear-compiled
php artisan optimize

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan db:seed
php artisan schedule:run
php artisan storage:link

```


### Open in browser:
```
http://localhost:8001
```

### Use the following credentials to login:
```
Email: rodrigoemail@4nswers.com
Password: password123
```


### To stop and remove the container:

```bash
docker stop lbaw24112
docker rm lbaw24112
```
