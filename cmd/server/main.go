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
		fmt.Fprintf(os.Stderr, "サーバー起動エラー: %v\n", err)
		os.Exit(1)
	}
}

// root は "/"にアクセスした際のハンドラ
func root(w http.ResponseWriter, r *http.Request) {
	_, err := fmt.Fprint(w, "Welcome!!")
	if err != nil {
		http.Error(w, "Internal Server Error", http.StatusInternalServerError)
		return
	}
}

// test は "/test"にアクセスした際のハンドラ
func test(w http.ResponseWriter, r *http.Request) {
	_, err := fmt.Fprint(w, "test path")
	if err != nil {
		http.Error(w, "Internal Server Error", http.StatusInternalServerError)
		return
	}
}
