package log

import (
	"bytes"
	"context"
	"log/slog"
	"testing"

	"github.com/stretchr/testify/assert"
)

func TestNewSlogLogger(t *testing.T) {
	t.Parallel()
	t.Run("should create a logger with JSON handler", func(t *testing.T) {
		t.Parallel()
		var buf bytes.Buffer
		logger := NewSlogLogger(&buf, slog.LevelDebug, true)
		assert.NotNil(t, logger)

		logger.Info(context.Background(), "test message", "key", "value")
		output := buf.String()
		assert.Contains(t, output, `"level":"INFO"`)
		assert.Contains(t, output, `"msg":"test message"`)
		assert.Contains(t, output, `"key":"value"`)
	})

	t.Run("should create a logger with text handler", func(t *testing.T) {
		t.Parallel()
		var buf bytes.Buffer
		logger := NewSlogLogger(&buf, slog.LevelDebug, false)
		assert.NotNil(t, logger)

		logger.Info(context.Background(), "test message", "key", "value")
		output := buf.String()
		assert.Contains(t, output, "level=INFO")
		assert.Contains(t, output, "msg=\"test message\"")
		assert.Contains(t, output, "key=value")
	})
}

func TestSlogLogger_LoggingMethods(t *testing.T) {
	t.Parallel()
	ctx := context.Background()

	type logFunc func(l *slogLogger, ctx context.Context, msg string, args ...any)

	testCases := []struct {
		name     string
		level    slog.Level
		logFunc  logFunc
		levelStr string
		isJSON   bool
	}{
		{"Debug JSON", slog.LevelDebug, (*slogLogger).Debug, "DEBUG", true},
		{"Info JSON", slog.LevelInfo, (*slogLogger).Info, "INFO", true},
		{"Warn JSON", slog.LevelWarn, (*slogLogger).Warn, "WARN", true},
		{"Error JSON", slog.LevelError, (*slogLogger).Error, "ERROR", true},
		{"Debug Text", slog.LevelDebug, (*slogLogger).Debug, "DEBUG", false},
		{"Info Text", slog.LevelInfo, (*slogLogger).Info, "INFO", false},
		{"Warn Text", slog.LevelWarn, (*slogLogger).Warn, "WARN", false},
		{"Error Text", slog.LevelError, (*slogLogger).Error, "ERROR", false},
	}

	for _, tc := range testCases {
		tc := tc
		t.Run(tc.name, func(t *testing.T) {
			t.Parallel()
			var buf bytes.Buffer
			// NewSlogLogger returns Logger, so we need to cast it.
			logger := NewSlogLogger(&buf, slog.LevelDebug, tc.isJSON).(*slogLogger)

			msg := "this is a test"
			args := []any{"key1", "value1", "key2", 123}

			tc.logFunc(logger, ctx, msg, args...)

			output := buf.String()

			if tc.isJSON {
				assert.Contains(t, output, `"level":"`+tc.levelStr+`"`)
				assert.Contains(t, output, `"msg":"`+msg+`"`)
				assert.Contains(t, output, `"key1":"value1"`)
				assert.Contains(t, output, `"key2":123`)
			} else {
				assert.Contains(t, output, "level="+tc.levelStr)
				assert.Contains(t, output, "msg=\""+msg+"\"")
				assert.Contains(t, output, "key1=value1")
				assert.Contains(t, output, "key2=123")
			}
		})
	}
}

func TestSlogLogger_LevelFiltering(t *testing.T) {
	t.Parallel()
	t.Run("should not log debug messages if level is info", func(t *testing.T) {
		t.Parallel()
		var buf bytes.Buffer
		logger := NewSlogLogger(&buf, slog.LevelInfo, false) // Level is Info

		logger.Debug(context.Background(), "this should not be logged")

		assert.Empty(t, buf.String())
	})

	t.Run("should log info messages if level is info", func(t *testing.T) {
		t.Parallel()
		var buf bytes.Buffer
		logger := NewSlogLogger(&buf, slog.LevelInfo, false) // Level is Info

		logger.Info(context.Background(), "this should be logged")

		assert.NotEmpty(t, buf.String())
		assert.Contains(t, buf.String(), "this should be logged")
	})
}
