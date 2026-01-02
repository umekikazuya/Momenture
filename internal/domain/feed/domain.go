package feed

import "time"

// --- Type ---

// Feed はフィードの構造体
type Feed struct {
	Title    string
	Link     string
	Articles []Article `xml:"data"`
}

// Article はフィード内の各コンテンツの構造体
type Article struct {
	Title     string
	Link      string
	published time.Time
}

// --- Factory ---

// ReconstructFeed はエンティティの再構築関数
func ReconstructFeed(
	rawTitle string,
	rawLink string,
	rawArticles []Article,
) (*Feed, error) {
	return &Feed{
		Title:    rawTitle,
		Link:     rawLink,
		Articles: rawArticles,
	}, nil
}

// ReconstructArticle はArticleエンティティの再構築関数
func ReconstructArticle(
	rawTitle string,
	rawLink string,
	rawPublished time.Time,
) (*Article, error) {
	return &Article{
		Title:     rawTitle,
		Link:      rawLink,
		published: rawPublished,
	}, nil
}
