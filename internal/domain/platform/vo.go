package platform

import (
	"errors"
	"unicode/utf8"

	"github.com/google/uuid"
)

type (
	ID   struct{ value uuid.UUID }
	Name struct{ value string }
)

// --- Contraints ---

const (
	maxName = 50
)

// --- Factory ---

// NewID はIDオブジェクトのファクトリー関数
func NewID(input uuid.UUID) (ID, error) {
	id := ID{value: input}
	if id.value == uuid.Nil {
		return ID{}, errors.New("IDオブジェクトの生成に失敗しました")
	}
	return id, nil
}

// NewName はNameオブジェクトのファクトリー関数
func NewName(input string) (Name, error) {
	if utf8.RuneCountInString(input) == 0 {
		return Name{}, errors.New("Nameオブジェクトの生成に失敗しました")
	}
	if utf8.RuneCountInString(input) > maxName {
		return Name{}, errors.New("Nameオブジェクトの生成に失敗しました")
	}
	return Name{value: input}, nil
}

// --- Getter ---

// Value はIDのGetter
func (id ID) Value() uuid.UUID {
	return id.value
}

// Value はNameのGetter
func (name Name) Value() string {
	return name.value
}
