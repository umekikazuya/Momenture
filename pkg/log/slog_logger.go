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

// NewSlogLogger はロガーを生成
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
