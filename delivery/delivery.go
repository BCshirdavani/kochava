package main

import (
	"context"
	"encoding/json"
	"fmt"
	"log"
	"os"
	"strings"

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
	Foo 	string `json:"foo"`
}

var ctx = context.Background()

var redisClient = redis.NewClient(&redis.Options{
    Addr: "redis-server:6379",
})

func main() {
	// setup logger output file
	file, err := os.OpenFile("postback.log", os.O_CREATE|os.O_APPEND|os.O_WRONLY, 0644)
	if err != nil {
		log.Fatal(err)
	}
	log.SetOutput(file)

	// subscribe to redis channel to get updates
	subscriber := redisClient.Subscribe(ctx, "postback-queue-pub-sub")
	for {
		msg, err := subscriber.ReceiveMessage(ctx)
		if err != nil {
			log.Fatal(err)
			panic(err)
		}

		// parse the string from redis
		var postback Postback
		if err := json.Unmarshal([]byte(msg.Payload), &postback); err != nil {
			log.Fatal(err)
			panic(err)
		}
		// insert data into url placeholders
		formattedUrl := strings.Replace(postback.Endpoint.URL, "{mascot}", postback.Data[0].Mascot, 1)
		formattedUrl = strings.Replace(formattedUrl, "{location}", postback.Data[0].Location, 1)
		formattedUrl = strings.Replace(formattedUrl, "{bar}", postback.Data[0].Foo, 1)
		responseToLog := "\n" + postback.Endpoint.Method + "\n" + formattedUrl
		// log the formatted url
	
		fmt.Println("logging:")
		fmt.Println(responseToLog)
		log.Println(responseToLog)
	}
}