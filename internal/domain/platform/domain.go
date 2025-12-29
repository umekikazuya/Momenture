package platform

import (
	"time"

	"github.com/google/uuid"
)

// --- Type ---

type Platform struct {
	id        ID
	name      Name
	createdAt time.Time
	updatedAt time.Time
}

// --- Factory ---

// NewPlatform はPlatformエンティティのファクトリー関数
func NewPlatform(
	name string,
) (Platform, error) {
	rawID := uuid.New()
	id, err := NewID(rawID)
	if err != nil {
		return Platform{}, err
	}
	n, err := NewName(name)
	if err != nil {
		return Platform{}, err
	}
	now := time.Now()
	return Platform{
		id:        id,
		name:      n,
		createdAt: now,
		updatedAt: now,
	}, nil
}

// --- 振る舞い ---

// Update はPlatformエンティティの名称を更新する

func (as *Platform) Update(rawName string) error {
	name, err := NewName(rawName)
	if err != nil {
		return err
	}
	as.name = name
	return nil
}

// --- Getter ---

func (as Platform) ID() ID {
	return as.id
}

func (as Platform) Name() Name {
	return as.name
}

func (as Platform) CreatedAt() time.Time {
	return as.createdAt
}

func (as Platform) UpdatedAt() time.Time {
	return as.updatedAt
}
