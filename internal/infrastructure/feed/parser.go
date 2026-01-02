package feed

import (
	"context"
	"encoding/xml"
	"time"

	application "github.com/umekikazuya/momenture/internal/application/feed"
	domain "github.com/umekikazuya/momenture/internal/domain/feed"
)

type QiitaFeedParser struct{}

type ZennFeedParser struct{}

var (
	_ application.FeedParser = (*QiitaFeedParser)(nil)
	_ application.FeedParser = (*ZennFeedParser)(nil)
)

func NewQiitaFeedParser() application.FeedParser {
	return &QiitaFeedParser{}
}

func NewZennFeedParser() application.FeedParser {
	return &ZennFeedParser{}
}

type qiitaFeed struct {
	XMLName xml.Name     `xml:"feed"`
	Title   string       `xml:"title"`
	Link    string       `xml:"link"`
	Entries []qiitaEntry `xml:"entry"`
}

// qiitaEntry はフィード内の各コンテンツの構造体
type qiitaEntry struct {
	Title     string `xml:"title"`
	Link      string `xml:"url"`
	Published string `xml:"published"`
}

func (p *QiitaFeedParser) Handle(ctx context.Context, body []byte) (*domain.Feed, error) {
	var rss qiitaFeed
	if err := xml.Unmarshal(body, &rss); err != nil {
		return nil, err
	}
	r, err := toEntityFromQiitaEntry(rss)
	if err != nil {
		return nil, err
	}
	return r, nil
}

// toEntityFromQiitaEntry
func toEntityFromQiitaEntry(data qiitaFeed) (*domain.Feed, error) {
	var articles []domain.Article
	for _, o := range data.Entries {
		t, err := time.Parse(time.RFC3339, o.Published)
		if err != nil {
			continue
		}
		a, err := domain.ReconstructArticle(o.Title, o.Link, t)
		if err != nil {
			continue
		}
		articles = append(articles, *a)
	}
	f, err := domain.ReconstructFeed(data.Title, data.Link, articles)
	if err != nil {
		return nil, err
	}
	return f, nil
}

func (p *ZennFeedParser) Handle(ctx context.Context, body []byte) (*domain.Feed, error) {
	return nil, nil
}
