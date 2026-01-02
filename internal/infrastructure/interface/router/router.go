package router

import (
	"net/http"

	"github.com/gin-gonic/gin"
	"github.com/umekikazuya/momenture/internal/infrastructure/interface/controller"
)

// NewRouter はアプリケーションのHTTPルーターを生成します
func NewRouter(
	feedCtr *controller.FeedController,
) *gin.Engine {
	r := gin.New()
	r.Use(gin.Recovery())

	// GET /api/v1/action エンドポイントにコントローラのハンドラを登録
	r.GET("/api/qiita/:id", feedCtr.Qiita)

	// 404
	r.NoRoute(func(c *gin.Context) {
		c.JSON(http.StatusNotFound, gin.H{"error": "404 not found"})
	})
	// 405
	r.NoMethod(func(c *gin.Context) {
		c.JSON(http.StatusMethodNotAllowed, gin.H{"error": "405 method not allowed"})
	})

	return r
}
