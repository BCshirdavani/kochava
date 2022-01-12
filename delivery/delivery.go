package main

import (
	"context"
	"encoding/json"
	"fmt"
	"log"

	"github.com/go-redis/redis/v8"
)

type Postback struct {
    Endpoint  Endpoint 	`json:"endpoint"`
    Data			[]Data 		`json:"data"`
}

type Endpoint struct {
	Method	string `json:"method"`
	URL   string `json:"url"`
}

type Data struct {
	Mascot		string `json:"mascot"`
	Location 	string `json:"location"`
}

var ctx = context.Background()

var redisClient = redis.NewClient(&redis.Options{
    Addr: "redis-server:6379",
})

func main() {
	log.Println("Hello world!")
	fmt.Println("hello world from fmt print")
	subscriber := redisClient.Subscribe(ctx, "postback-queue-pub-sub")

	val1, err1 := redisClient.Get(ctx, "postback-queue-pub-sub").Result()
	if err1 != nil {
		fmt.Println("possible error?")
	}
	fmt.Println("postback-queue-pub-sub", val1)

	for {
		msg, err := subscriber.ReceiveMessage(ctx)
		fmt.Println("printing msg:")
		fmt.Println(msg)
		if err != nil {
				panic(err)
		}

		var postback Postback

		if err := json.Unmarshal([]byte(msg.Payload), &postback); err != nil {
				panic(err)
		}

		fmt.Println("Received message from " + msg.Channel + " channel.")
		fmt.Printf("%+v\n", postback)
		prettyPostBack := fmt.Sprintf("%#v", postback)
		log.Println(prettyPostBack)
		fmt.Println(prettyPostBack)
	}
}