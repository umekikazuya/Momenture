package platform

import (
	"strings"
	"testing"

	"github.com/go-playground/assert/v2"
	"github.com/google/uuid"
	"github.com/stretchr/testify/require"
)

// testID は本テストで利用するID
var testID = uuid.New()

func TestNewID(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name    string
		args    uuid.UUID
		want    ID
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    testID,
			want:    ID{testID},
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    uuid.Nil,
			want:    ID{},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewID(tt.args)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want, got)
		})
	}
}

func TestNewName(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name    string
		args    string
		want    Name
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    "aa",
			want:    Name{"aa"},
			wantErr: false,
		},
		{
			name:    "ok: case2 - 50 length",
			args:    strings.Repeat("a", 50),
			want:    Name{strings.Repeat("a", 50)},
			wantErr: false,
		},
		{
			name:    "ok: case3 - 50 length(multi bytes)",
			args:    strings.Repeat("あ", 50),
			want:    Name{strings.Repeat("あ", 50)},
			wantErr: false,
		},
		{
			name:    "ng: case1 - count over",
			args:    strings.Repeat("a", 51),
			want:    Name{},
			wantErr: true,
		},
		{
			name:    "ng: case2 - empty",
			args:    "",
			want:    Name{},
			wantErr: true,
		},
		{
			name:    "ok: case4 - empty(contain spaces)",
			args:    "  ",
			want:    Name{value: "  "},
			wantErr: false,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewName(tt.args)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want.Value(), got.Value())
		})
	}
}

func TestID_Value(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  ID
		want uuid.UUID
	}{
		{
			"ok: case1",
			ID{testID},
			testID,
		},
		{
			"ok: case2",
			ID{},
			uuid.Nil,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got := tt.arg.Value()
			assert.Equal(t, tt.want, got)
		})
	}
}

func TestName_Value(t *testing.T) {
	t.Parallel()

	tests := []struct {
		name string
		arg  Name
		want string
	}{
		{
			name: "ok: case1",
			arg:  Name{value: "aaa"},
			want: "aaa",
		},
		{
			name: "ok: case2",
			arg:  Name{},
			want: "",
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got := tt.arg.Value()
			assert.Equal(t, tt.want, got)
		})
	}
}
