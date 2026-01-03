package feed

import (
	"context"

	domain "github.com/umekikazuya/momenture/internal/domain/feed"
)

type Interactor struct {
	fetcher FeedFetcher
	parser  FeedParser
}

func NewFeedUsecase(
	fetcher FeedFetcher,
	parser FeedParser,
) *Interactor {
	return &Interactor{
		fetcher: fetcher,
		parser:  parser,
	}
}

func (i *Interactor) Handle(ctx context.Context, url string) (*domain.Feed, error) {
	// HTTP通信
	body, err := i.fetcher.Handle(ctx, url)
	if err != nil {
		return nil, err
	}
	entities, err := i.parser.Handle(ctx, body)
	if err != nil {
		return nil, err
	}
	return entities, nil
}
