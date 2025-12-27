package main

import (
	"fmt"
	"net/http"
	"os"
)

func main() {
	server := http.Server{
		Addr:    ":8080",
		Handler: nil,
	}
	http.HandleFunc("/", root)
	http.HandleFunc("/test", test)
	err := server.ListenAndServe()
	if err != nil {
		os.Exit(1)
	}
}

// root は "/"にアクセスした際のハンドラ
func root(w http.ResponseWriter, r *http.Request) {
	fmt.Fprint(w, "Welcome!!")
}

// test は "/"にアクセスした際のハンドラ
func test(w http.ResponseWriter, r *http.Request) {
	fmt.Fprint(w, "test path")
}
