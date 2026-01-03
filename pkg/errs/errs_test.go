package errs

import (
	"errors"
	"testing"

	"github.com/stretchr/testify/assert"
)

// TestNewHelperFunctions は、各ヘルパー関数が期待通りのエラーを生成するかをテスト
func TestNewHelperFunctions(t *testing.T) {
	// Arrange
	testCases := []struct {
		name         string
		constructor  func(string) *Err // テスト対象のヘルパー関数
		expectedType ErrType
		expectedMsg  string
	}{
		{"NewNotFound", NewNotFound, NotFound, "resource was not found"},
		{"NewInvalidArgument", NewInvalidArgument, InvalidArgument, "invalid argument provided"},
		{"NewConflict", NewConflict, Conflict, "resource conflict"},
		{"NewPermissionDenied", NewPermissionDenied, PermissionDenied, "permission denied"},
		{"NewUnauthenticated", NewUnauthenticated, Unauthenticated, "unauthenticated"},
		{"NewInternal", NewInternal, Internal, "internal server error"},
	}

	for _, tc := range testCases {
		t.Run(tc.name, func(t *testing.T) {
			// Act
			err := tc.constructor(tc.expectedMsg)

			// Assert
			if err.Type != tc.expectedType {
				t.Errorf("unexpected error type: got %v, want %v", err.Type, tc.expectedType)
			}
			if err.Message != tc.expectedMsg {
				t.Errorf("unexpected error message: got %q, want %q", err.Message, tc.expectedMsg)
			}
			if err.cause != nil {
				t.Errorf("expected cause to be nil, but got: %v", err.cause)
			}
		})
	}
}

// TestWrap は、Wrap関数が正しくエラーをラップできるかをテスト
func TestWrap(t *testing.T) {
	// Arrange
	originalErr := errors.New("this is the original error")
	wrapperMsg := "failed to process request"
	wrapperType := Internal

	// Act
	wrappedErr := Wrap(wrapperType, wrapperMsg, originalErr)

	// Assert
	if wrappedErr.Type != wrapperType {
		t.Errorf("unexpected error type: got %v, want %v", wrappedErr.Type, wrapperType)
	}
	if wrappedErr.Message != wrapperMsg {
		t.Errorf("unexpected error message: got %q, want %q", wrappedErr.Message, wrapperMsg)
	}
	if wrappedErr.cause != originalErr {
		t.Errorf("unexpected cause: got %v, want %v", wrappedErr.cause, originalErr)
	}
}

// TestErrorMethod は、Error()メソッドが期待通りの文字列を返すかテスト
func TestErrorMethod(t *testing.T) {
	t.Run("when cause is nil", func(t *testing.T) {
		// Arrange
		err := NewNotFound("not found")
		expected := "not found"

		// Act
		actual := err.Error()

		// Assert
		if actual != expected {
			t.Errorf("got %q, want %q", actual, expected)
		}
	})

	t.Run("when cause is not nil", func(t *testing.T) {
		// Arrange
		originalErr := errors.New("database connection failed")
		err := Wrap(Internal, "internal error", originalErr)
		expected := "internal error: database connection failed"

		// Act
		actual := err.Error()

		// Assert
		if actual != expected {
			t.Errorf("got %q, want %q", actual, expected)
		}
	})
}

// TestUnwrapMethod は、Unwrap()メソッドとerrors.Is/Asとの連携をテスト
func TestUnwrapMethod(t *testing.T) {
	// Arrange
	originalErr := errors.New("root cause error")
	// 2回ラップされたエラーを準備
	wrappedErr := Wrap(NotFound, "layer 1", Wrap(Internal, "layer 2", originalErr))

	t.Run("errors.Unwrap should return the direct cause", func(t *testing.T) {
		// Act
		unwrapped := errors.Unwrap(wrappedErr)

		// Assert
		// 1段階アンラップすると "layer 2" のエラーが返る想定
		var innerErr *Err
		if !errors.As(unwrapped, &innerErr) {
			t.Fatal("unwrapped error should be of type *Err")
		}
		if innerErr.Message != "layer 2" {
			t.Errorf("expected message 'layer 2', got %q", innerErr.Message)
		}
	})

	t.Run("errors.Is should find the original error", func(t *testing.T) {
		// Act & Assert
		if !errors.Is(wrappedErr, originalErr) {
			t.Error("errors.Is should be able to find the original error in the chain")
		}
	})

	t.Run("errors.As should find the first matching error type", func(t *testing.T) {
		// Act
		var target *Err
		found := errors.As(wrappedErr, &target)

		// Assert
		if !found {
			t.Fatal("errors.As should find an error of type *Err")
		}
		// errors.As はチェーンの中で最初に見つかった *Err 型のエラー (一番外側) を返す
		if target.Type != NotFound {
			t.Errorf("expected the outer error type NotFound, but got %v", target.Type)
		}
		if target.Message != "layer 1" {
			t.Errorf("expected the outer error message 'layer 1', but got %q", target.Message)
		}
	})
}

func TestIs(t *testing.T) {
	t.Parallel()
	// Arrange
	input := []struct {
		name     string
		err      error   // 第一引数
		errType  ErrType // 第二引数
		expected bool
	}{
		{
			name:     "ErrTypeが一致する場合",
			err:      NewNotFound("リソースが見つかりません"),
			errType:  NotFound,
			expected: true,
		},
		{
			name:     "ErrTypeが一致しない場合",
			err:      NewNotFound("リソースが見つかりません"),
			errType:  InvalidArgument,
			expected: false,
		},
		{
			name:     "ラップされたエラーのErrTypeが一致する場合",
			err:      Wrap(Internal, "内部エラー", NewNotFound("リソースが見つかりません")),
			errType:  Internal,
			expected: true,
		},
		{
			name:     "ラップされたエラーのErrTypeが一致しない場合",
			err:      Wrap(Internal, "内部エラー", NewNotFound("リソースが見つかりません")),
			errType:  InvalidArgument,
			expected: false,
		},
		{
			name:     "標準エラーの場合",
			err:      errors.New("標準エラー"),
			errType:  Internal,
			expected: false,
		},
		{
			name:     "nilの場合",
			err:      nil,
			errType:  NotFound,
			expected: false,
		},
	}
	for _, tt := range input {
		tt := tt
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()

			// Act
			got := Is(tt.err, tt.errType)

			// Assert
			assert.Equal(t, tt.expected, got)
		})

	}
}
