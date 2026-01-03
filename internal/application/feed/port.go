package feed

import (
	"context"

	domain "github.com/umekikazuya/momenture/internal/domain/feed"
)

type FeedFetcher interface {
	Handle(ctx context.Context, url string) ([]byte, error)
}

// FeedParser は[]byte型を適切なフィードの構造体に解析する関数
type FeedParser interface {
	Handle(ctx context.Context, body []byte) (*domain.Feed, error)
}
