package feed

import (
	"context"

	domain "github.com/umekikazuya/momenture/internal/domain/feed"
)

type FeedFetcher interface {
	Handle(ctx context.Context, url string) ([]byte, error)
}

// FeedParser は
type FeedParser interface {
	Handle(ctx context.Context, body []byte) (*domain.Feed, error)
}
