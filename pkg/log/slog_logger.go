package log

import (
	"context"
	"io"
	"log/slog"
)

var _ Logger = (*slogLogger)(nil)

// slogLogger は pkg/log Logger インターフェースの実装
type slogLogger struct {
	l *slog.Logger
}

// NewSlogLogger は slog ベースの Logger を生成
//
// w: ログの出力先
// level: ログレベル（slog.LevelDebug, slog.LevelInfo など）
// isJSON: true の場合 JSON 形式、false の場合テキスト形式で出力
func NewSlogLogger(w io.Writer, level slog.Level, isJSON bool) Logger {
	var handler slog.Handler
	opts := &slog.HandlerOptions{
		Level: level,
	}

	if isJSON {
		handler = slog.NewJSONHandler(w, opts)
	} else {
		handler = slog.NewTextHandler(w, opts)
	}

	return &slogLogger{
		l: slog.New(handler),
	}
}

func (l *slogLogger) Debug(ctx context.Context, msg string, args ...any) {
	l.l.DebugContext(ctx, msg, args...)
}

func (l *slogLogger) Info(ctx context.Context, msg string, args ...any) {
	l.l.InfoContext(ctx, msg, args...)
}

func (l *slogLogger) Warn(ctx context.Context, msg string, args ...any) {
	l.l.WarnContext(ctx, msg, args...)
}

func (l *slogLogger) Error(ctx context.Context, msg string, args ...any) {
	l.l.ErrorContext(ctx, msg, args...)
}
