package feed

import (
	"context"
	"fmt"
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
	req, err := http.NewRequestWithContext(ctx, http.MethodGet, url, nil)
	if err != nil {
		return nil, err
	}
	resp, err := f.client.Do(req)
	if err != nil {
		return nil, err
	}
	defer resp.Body.Close()
	if resp.StatusCode < 200 || resp.StatusCode >= 300 {
		return nil, fmt.Errorf("unexpected status code: %d", resp.StatusCode)
	}
	body, err := io.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}
	return body, nil
}
