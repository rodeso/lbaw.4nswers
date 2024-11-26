# lbaw24112 - 4NSWERS

## Group Members

    Afonso Castro (up202208026@fe.up.pt)
    Leonor Couto (up202205796@fe.up.pt)
    Pedro Santos (up202205900@fe.up.pt)
    Rodrigo de Sousa (up202205751@fe.up.pt)

## Instructions to send the docker image

login to gitlab registry:
```
docker login gitlab.up.pt:5050
```

build the docker image:
```
./build.sh
```





## Instructions to run the project

Run to start the docker containers:
```
docker run -d --name lbaw24112 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24112
```



Run to update the closed questions:
```
docker exec -it lbaw24112 php /var/www/artisan schedule:run
```

Open in browser:
```
http://localhost:8001
```