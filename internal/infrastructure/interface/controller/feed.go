package controller

import (
	"fmt"
	"net/http"

	"github.com/gin-gonic/gin"
	"github.com/umekikazuya/momenture/internal/application/feed"
)

type FeedController struct {
	usecase feed.Intefactor
}

func NewFeedController(
	usecase feed.Intefactor,
) *FeedController {
	return &FeedController{
		usecase: usecase,
	}
}

type InputQiitaDto struct {
	ID string `uri:"id" binding:"required"`
}

type InputZennDto struct {
	ID string `uri:"id" binding:"required"`
}

func (ctl *FeedController) Qiita(c *gin.Context) {
	var input InputQiitaDto
	if err := c.ShouldBindUri(&input); err != nil {
		c.JSON(http.StatusBadRequest, err.Error())
	}
	res, err := ctl.usecase.Handle(c.Request.Context(), fmt.Sprintf("https://qiita.com/%s/feed", input.ID))
	if err != nil {
		c.JSON(http.StatusInternalServerError, err.Error())
		return
	}
	c.JSON(http.StatusOK, res)
}

func (ctl *FeedController) Zenn(c *gin.Context) {
	var input InputZennDto
	if err := c.ShouldBindUri(&input); err != nil {
		c.JSON(http.StatusBadRequest, err.Error())
	}
	res, err := ctl.usecase.Handle(c.Request.Context(), fmt.Sprintf("https://zenn.dev/%s/feed", input.ID))
	if err != nil {
		c.JSON(http.StatusInternalServerError, err.Error())
		return
	}
	c.JSON(http.StatusOK, res)
}
