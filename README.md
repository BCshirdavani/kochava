# mini project for kochava

### to run:

1. install and run docker, clone this repo
2. open a terminal, navigate to the repo's folder, then run `docker-compose build`
3. run `docker-compose up`
4. visit localhost:8080 in a browser window
5. fill out the form and click submit to have the php Ingestion Agent dispatch to the Redis postback queue. The go Delivery agent is subscribed to this Redis queue, so the previous submit action will publish to Redis, and the Delivery agent will take that object from redis and log it
6. in this terminal window that ran the `docker-compose` commands, you will see the print outputs from each container

### to view the log:

1. open new terminal
2. use the following command to open a shell inside the docker container that has the log: `docker exec -it kochava_delivery-go_1 sh`...if this fails, see the following options step
3. (OPTIONAL) if the previous command does not work, the container name may be different, in the terminal run the following command to show the active containers `docker ps`, and replace `kochava_delivery-go_1` in the previous command with the appropriate container name that is actually running
4. inside that container shell, run `ls` to show files, and run `cat postback.log` to display contents of the log
