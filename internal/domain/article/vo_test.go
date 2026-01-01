package article

import (
	"strings"
	"testing"

	"github.com/go-playground/assert/v2"
	"github.com/google/uuid"
	"github.com/stretchr/testify/require"
)

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

func TestNewTitle(t *testing.T) {
	t.Parallel()
	type args struct {
		input string
	}
	tests := []struct {
		name    string
		args    args
		want    Title
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{input: "aa"},
			want:    Title{value: "aa"},
			wantErr: false,
		},
		{
			name:    "ok: case2",
			args:    args{input: strings.Repeat("a", 50)},
			want:    Title{value: strings.Repeat("a", 50)},
			wantErr: false,
		},
		{
			name:    "ok: case3",
			args:    args{input: strings.Repeat("あ", 50)},
			want:    Title{value: strings.Repeat("あ", 50)},
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    args{input: strings.Repeat("a", 51)},
			want:    Title{},
			wantErr: true,
		},
		{
			name:    "ng: case2",
			args:    args{input: strings.Repeat("あ", 51)},
			want:    Title{},
			wantErr: true,
		},
		{
			name:    "ng: case3",
			args:    args{input: ""},
			want:    Title{},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewTitle(tt.args.input)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want.Value(), got.Value())
		})
	}
}

func TestNewLink(t *testing.T) {
	t.Parallel()
	type args struct {
		input string
	}
	tests := []struct {
		name    string
		args    args
		want    Link
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{input: "https://github.com/"},
			want:    Link{value: "https://github.com/"},
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    args{input: "aiueo"},
			want:    Link{},
			wantErr: true,
		},
		{
			name:    "ng: case2",
			args:    args{input: ""},
			want:    Link{},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got, err := NewLink(tt.args.input)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want.Value(), got.Value())
		})
	}
}

func TestNewStatus(t *testing.T) {
	type args struct {
		s string
	}
	tests := []struct {
		name    string
		args    args
		want    Status
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{s: StatusPublished.Value()},
			want:    StatusPublished,
			wantErr: false,
		},
		{
			name:    "ok: case2",
			args:    args{s: StatusDraft.Value()},
			want:    StatusDraft,
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    args{s: "aa"},
			want:    Status{},
			wantErr: true,
		},
		{
			name:    "ng: case2",
			args:    args{s: ""},
			want:    Status{},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewStatus(tt.args.s)
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

func TestTitle_Value(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  Title
		want string
	}{
		{
			"ok: case1",
			Title{value: "aa"},
			"aa",
		},
		{
			"ok: case2",
			Title{},
			"",
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

func TestLink_Value(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  Link
		want string
	}{
		{
			"ok: case1",
			Link{value: "https://github.com/"},
			"https://github.com/",
		},
		{
			"ok: case2",
			Link{},
			"",
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

func TestStatus_Value(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  Status
		want string
	}{
		{
			"ok: case1",
			Status{value: "draft"},
			"draft",
		},
		{
			"ok: case2",
			Status{},
			"",
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
