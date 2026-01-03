package log

import "context"

// Logger は構造化ログ出力のための抽象化インターフェース
type Logger interface {
	// Debug はデバッグレベルのログを出力
	Debug(ctx context.Context, msg string, args ...any)
	// Info は情報レベルのログを出力
	Info(ctx context.Context, msg string, args ...any)
	// Warn は警告レベルのログを出力
	Warn(ctx context.Context, msg string, args ...any)
	// Error はエラーレベルのログを出力
	Error(ctx context.Context, msg string, args ...any)
}
