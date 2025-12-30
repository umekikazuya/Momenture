package platform

import (
	"time"

	"github.com/google/uuid"
)

// --- Type ---

type Platform struct {
	id          ID
	name        Name
	accountName AccountName
	url         URL
	createdAt   time.Time
	updatedAt   time.Time
}

type OptFunc func(*Platform) error

// --- Factory ---

// NewPlatform はPlatformエンティティのファクトリー関数
func NewPlatform(
	name string,
	opts ...OptFunc,
) (*Platform, error) {
	rawID := uuid.New()
	id, err := NewID(rawID)
	if err != nil {
		return &Platform{}, err
	}
	n, err := NewName(name)
	if err != nil {
		return &Platform{}, err
	}
	now := time.Now()
	entity := &Platform{
		id:        id,
		name:      n,
		createdAt: now,
		updatedAt: now,
	}
	for _, opt := range opts {
		if err := opt(entity); err != nil {
			return &Platform{}, err
		}
	}
	return entity, nil
}

// --- Functional Option ---

// OptName はNameを設定するOption関数
func OptName(input string) OptFunc {
	return func(p *Platform) error {
		inputName, err := NewName(input)
		if err != nil {
			return err
		}
		p.name = inputName
		return nil
	}
}

// OptAccountName はAccountNameを設定するOption関数
func OptAccountName(input string) OptFunc {
	return func(p *Platform) error {
		accountName, err := NewAccountName(input)
		if err != nil {
			return err
		}
		p.accountName = accountName
		return nil
	}
}

// OptURL はURLを設定するOption関数
func OptURL(input string) OptFunc {
	return func(p *Platform) error {
		url, err := NewURL(input)
		if err != nil {
			return err
		}
		p.url = url
		return nil
	}
}

// --- 振る舞い ---

// Update はPlatformエンティティの各属性を更新する
func (p *Platform) Update(opts ...OptFunc) error {
	for _, opt := range opts {
		if err := opt(p); err != nil {
			return err
		}
	}
	p.updatedAt = time.Now()
	return nil
}

// --- Getter ---

func (p Platform) ID() ID {
	return p.id
}

func (p Platform) Name() Name {
	return p.name
}

func (p Platform) AccountName() AccountName {
	return p.accountName
}

func (p Platform) URL() URL {
	return p.url
}

func (p Platform) CreatedAt() time.Time {
	return p.createdAt
}

func (p Platform) UpdatedAt() time.Time {
	return p.updatedAt
}
