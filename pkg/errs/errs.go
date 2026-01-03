package errs

import (
	"errors"
	"fmt"
)

// ErrType はエラーの種類を定義
type ErrType int

const (
	NotFound         ErrType = iota // リソースが見つからない (HTTP 404)
	InvalidArgument                 // リクエストの引数が不正 (HTTP 400)
	Conflict                        // リソースの状態が競合 (HTTP 409)
	PermissionDenied                // 権限がない (HTTP 403)
	Unauthenticated                 // 認証されていない (HTTP 401)
	Internal                        // 予期せぬサーバー内部のエラー (HTTP 500)
)

// Err はエラーを表す構造体
type Err struct {
	// Type はエラーの種類
	Type ErrType
	// Message はクライアントに表示するためのメッセージ
	Message string
	// cause はこのエラーを引き起こした元のエラー
	cause error
}

// new は新しい Err を生成
func new(errType ErrType, message string) *Err {
	return &Err{Type: errType, Message: message}
}

// Wrap は既存のエラーをラップして新しい Err を生成する
func Wrap(errType ErrType, message string, cause error) *Err {
	err := new(errType, message)
	err.cause = cause
	return err
}

// Error は error インターフェースを実装
func (e *Err) Error() string {
	if e.cause != nil {
		return fmt.Sprintf("%s: %v", e.Message, e.cause)
	}
	return e.Message
}

// Is はエラー(第一引数)が指定(第二引数)の型とマッチしているかを判定する
func Is(err error, errType ErrType) bool {
	var e *Err
	if errors.As(err, &e) {
		return e.Type == errType
	}
	return false
}

// Cause は元のエラーを返す
func (e *Err) Cause() error {
	return e.cause
}

// Unwrap は元のエラーを返すことで、errors.Is や errors.As での判定を可能にする
func (e *Err) Unwrap() error {
	return e.cause
}

// --- ヘルパー関数 ---

// NewNotFound はErrType: NotFoundのエラーを生成
func NewNotFound(message string) *Err {
	return new(NotFound, message)
}

// NewInvalidArgument はErrType: InvalidArgumentのエラーを生成
func NewInvalidArgument(message string) *Err {
	return new(InvalidArgument, message)
}

// NewConflict はErrType: Conflictのエラーを生成
func NewConflict(message string) *Err {
	return new(Conflict, message)
}

// NewPermissionDenied はErrType: PermissionDeniedのエラーを生成
func NewPermissionDenied(message string) *Err {
	return new(PermissionDenied, message)
}

// NewUnauthenticated はErrType: Unauthenticatedのエラーを生成
func NewUnauthenticated(message string) *Err {
	return new(Unauthenticated, message)
}

// NewInternal はErrType: Internalのエラーを生成
func NewInternal(message string) *Err {
	return new(Internal, message)
}