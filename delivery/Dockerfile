FROM golang:alpine3.15

RUN apk --update add redis 
WORKDIR /home/delivery
RUN go mod init delivery
RUN go get github.com/go-redis/redis/v8
COPY . /home/delivery

CMD [ "go", "run", "./delivery.go"]