package main

import (
	"net/http"
	"os"

	feedApp "github.com/umekikazuya/momenture/internal/application/feed"
	feedInfra "github.com/umekikazuya/momenture/internal/infrastructure/feed"
	"github.com/umekikazuya/momenture/internal/infrastructure/interface/controller"
	"github.com/umekikazuya/momenture/internal/infrastructure/interface/router"
)

func main() {
	// ctx := context.Background()

	feedFetcher := feedInfra.NewFeedFetcher()
	feedQiitaParser := feedInfra.NewQiitaFeedParser()
	feedZennParser := feedInfra.NewZennFeedParser()
	feedQiitaUsecase := feedApp.NewFeedUsecase(feedFetcher, feedQiitaParser)
	feedZennUsecase := feedApp.NewFeedUsecase(feedFetcher, feedZennParser)
	qiitaCtr := controller.NewFeedController(*feedQiitaUsecase)
	zennCtr := controller.NewFeedController(*feedZennUsecase)

	// ルーターの初期化
	r := router.NewRouter(qiitaCtr, zennCtr)

	// サーバー起動
	if err := http.ListenAndServe(":"+"8080", r); err != nil {
		os.Exit(1)
	}
}
