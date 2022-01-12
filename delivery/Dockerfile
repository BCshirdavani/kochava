FROM golang:alpine3.15
# RUN apt-get update && \
#     apt-get install -y && \
#     apt-get -y install sudo

# ENV DEBIAN_FRONTEND=noninteractive
# ENV TZ=Pacific
# RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# RUN rm -rf /usr/local/go && tar -C /usr/local -xzf go1.17.6.linux-amd64.tar.gz
# RUN tar -C /usr/local -xzf go1.17.6.linux-amd64.tar.gz

# RUN apt-get install wget -y

# RUN wget https://dl.google.com/go/go1.17.6.linux-amd64.tar.gz
# RUN sudo tar -C /usr/local/ -xzf go1.17.6.linux-amd64.tar.gz

# RUN export PATH=$PATH:/usr/local/go/bin
RUN apk --update add redis 

WORKDIR /home/delivery
RUN go mod init delivery
RUN go get github.com/go-redis/redis/v8
COPY . /home/delivery
# WORKDIR /home/delivery
CMD [ "go", "run", "./delivery.go"]