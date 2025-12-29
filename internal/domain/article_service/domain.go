package articleservice

import (
	"time"

	"github.com/google/uuid"
)

// --- Type ---

type ArticleService struct {
	id        ID
	name      Name
	createdAt time.Time
	updatedAt time.Time
}

// --- Factory ---

// NewArticleService はArticleServiceエンティティのファクトリー関数
func NewArticleService(
	name string,
) (ArticleService, error) {
	rawID := uuid.New()
	id, err := NewID(rawID)
	if err != nil {
		return ArticleService{}, err
	}
	n, err := NewName(name)
	if err != nil {
		return ArticleService{}, err
	}
	now := time.Now()
	return ArticleService{
		id:        id,
		name:      n,
		createdAt: now,
		updatedAt: now,
	}, nil
}

// --- 振る舞い ---

// Update はArticleServiceエンティティの名称を更新する

func (as *ArticleService) Update(rawName string) error {
	name, err := NewName(rawName)
	if err != nil {
		return err
	}
	as.name = name
	return nil
}

// --- Getter ---

func (as ArticleService) ID() ID {
	return as.id
}

func (as ArticleService) Name() Name {
	return as.name
}

func (as ArticleService) CreatedAt() time.Time {
	return as.createdAt
}

func (as ArticleService) UpdatedAt() time.Time {
	return as.updatedAt
}
