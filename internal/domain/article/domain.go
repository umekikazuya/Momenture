package article

import (
	"time"

	"github.com/google/uuid"
	"github.com/umekikazuya/momenture/internal/domain/platform"
)

// --- Type ---

// Article は記事エンティティ
type Article struct {
	id        ID
	title     Title
	platform  platform.Platform
	link      Link
	status    Status
	createdAt time.Time
	updatedAt time.Time
}

type OptFunc func(*Article) error

// --- Factory ---

// NewArticle は記事エンティティのファクトリー関数
func NewArticle(
	inputTitle string,
	inputPlatform platform.Platform,
	opts ...OptFunc,
) (*Article, error) {
	rawID := uuid.New()
	id, err := NewID(rawID)
	if err != nil {
		return &Article{}, err
	}
	title, err := NewTitle(inputTitle)
	if err != nil {
		return &Article{}, err
	}
	now := time.Now()
	entity := &Article{
		id:        id,
		title:     title,
		platform:  inputPlatform,
		status:    StatusDraft,
		createdAt: now,
		updatedAt: now,
	}

	for _, opt := range opts {
		if err := opt(entity); err != nil {
			return &Article{}, nil
		}
	}
	return entity, nil
}

// --- Functional Option ---

func OptTitle(input string) OptFunc {
	return func(a *Article) error {
		t, err := NewTitle(input)
		if err != nil {
			return err
		}
		a.title = t
		return nil
	}
}

func OptPlatform(input platform.Platform) OptFunc {
	return func(a *Article) error {
		a.platform = input
		return nil
	}
}

func OptLink(input string) OptFunc {
	return func(a *Article) error {
		l, err := NewLink(input)
		if err != nil {
			return err
		}
		a.link = l
		return nil
	}
}

func OptStatus(input string) OptFunc {
	return func(a *Article) error {
		s, err := NewStatus(input)
		if err != nil {
			return err
		}
		a.status = s
		return nil
	}
}

// --- 振る舞い ---

// Update は記事エンティティを更新する関数
func (a *Article) Update(opts ...OptFunc) error {
	for _, opt := range opts {
		if err := opt(a); err != nil {
			return err
		}
	}
	a.updatedAt = time.Now()
	return nil
}

// --- Getter ---

func (a Article) ID() ID {
	return a.id
}

func (a Article) Title() Title {
	return a.title
}

func (a Article) Platform() platform.Platform {
	return a.platform
}

func (a Article) Link() Link {
	return a.link
}

func (a Article) Status() Status {
	return a.status
}
