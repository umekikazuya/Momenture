package article

import (
	"errors"
	"net/url"
	"unicode/utf8"

	"github.com/google/uuid"
)

type (
	ID     struct{ value uuid.UUID }
	Title  struct{ value string }
	Link   struct{ value string }
	Status struct{ value string }
)

// --- Contraints ---

var (
	StatusDraft     = Status{value: "draft"}
	StatusPublished = Status{value: "published"}
)

const (
	maxTitleLen = 50
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

// NewTitle はTitleオブジェクトのファクトリー関数
func NewTitle(input string) (Title, error) {
	if utf8.RuneCountInString(input) == 0 {
		return Title{}, errors.New("Titleオブジェクトの生成に失敗しました")
	}
	if utf8.RuneCountInString(input) > maxTitleLen {
		return Title{}, errors.New("Titleオブジェクトの生成に失敗しました")
	}
	return Title{value: input}, nil
}

// NewLink はLinkオブジェクトのファクトリー関数
func NewLink(input string) (Link, error) {
	_, err := url.ParseRequestURI(input)
	if err != nil {
		return Link{}, errors.New("Linkの形式に誤りがあります")
	}
	return Link{value: input}, nil
}

// NewStatus はStatusオブジェクトのファクトリー関数
func NewStatus(s string) (Status, error) {
	switch (Status{value: s}).Value() {
	case StatusDraft.value, StatusDraft.value:
		return Status{value: s}, nil
	default:
		return Status{}, errors.New("Statusの形式は'draft'or'published'で入力してください")
	}
}

// --- Getter ---

// Value はIDのGetter
func (id ID) Value() uuid.UUID {
	return id.value
}

// Value はTitleのGetter
func (t Title) Value() string {
	return t.value
}

// Value はLinkのGetter
func (l Link) Value() string {
	return l.value
}

// Value はStatusの値を文字列で返却する
func (s Status) Value() string {
	return s.value
}
