package feed

import (
	"context"
	"io"
	"net/http"
	"time"

	application "github.com/umekikazuya/momenture/internal/application/feed"
)

type FeedFetcher struct {
	client *http.Client
}

var _ application.FeedFetcher = (*FeedFetcher)(nil)

func NewFeedFetcher() application.FeedFetcher {
	return &FeedFetcher{
		client: &http.Client{Timeout: 10 * time.Second},
	}
}

func (f *FeedFetcher) Handle(ctx context.Context, url string) ([]byte, error) {
	resp, err := f.client.Get(url)
	if err != nil {
		return nil, err
	}
	defer resp.Body.Close()
	body, err := io.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}
	return body, nil
}
