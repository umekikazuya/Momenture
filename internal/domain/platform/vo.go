package platform

import (
	"errors"
	"net/url"
	"unicode/utf8"

	"github.com/google/uuid"
)

type (
	ID          struct{ value uuid.UUID }
	Name        struct{ value string }
	AccountName struct{ value string }
	URL         struct{ value string }
)

// --- Contraints ---

const (
	maxName = 50
	maxAccountName
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

// NewAccountName はアカウント名オブジェクトのファクトリー関数
func NewAccountName(input string) (AccountName, error) {
	if utf8.RuneCountInString(input) == 0 {
		return AccountName{}, errors.New("Account名オブジェクトの生成に失敗しました")
	}
	if utf8.RuneCountInString(input) > maxAccountName {
		return AccountName{}, errors.New("Account名オブジェクトの生成に失敗しました")
	}
	return AccountName{value: input}, nil
}

// NewURL はURLオブジェクトのファクトリー関数
func NewURL(input string) (URL, error) {
	_, err := url.ParseRequestURI(input)
	if err != nil {
		return URL{}, errors.New("URLの形式に誤りがあります")
	}
	return URL{value: input}, nil
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

// Value はAccountNameのGetter
func (an AccountName) Value() string {
	return an.value
}

// Value はURLのGetter
func (u URL) Value() string {
	return u.value
}
