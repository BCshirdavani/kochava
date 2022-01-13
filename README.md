# kochava
##mini project for kochava

###to run:
1. `docker-compose build`
2. `docker-compose up`
3. visit localhost:8080 in a browser window
4. fill out the form and click submit to have the Ingestion Agent dispatch to the Redis postback queue
5. in this terminal window that ran the docker-compose commands, you will see the print outputs from each container

###to view the log:
1. open new terminal
2. use the following command to open a shell inside the docker container that has the log: `docker exec -it kochava_delivery-go_1 sh`
3. run `ls` to show files, and run `cat postback.log ` to display contents of the log