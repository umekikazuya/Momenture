package articleservice

import (
	"testing"

	"github.com/go-playground/assert/v2"
	"github.com/google/uuid"
	"github.com/stretchr/testify/require"
)

func TestNewArticleService(t *testing.T) {
	type args struct {
		name string
	}
	tests := []struct {
		name    string
		args    args
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{name: "aa"},
			wantErr: false,
		},
		{
			name: "ng: case1 - Nameオブジェクトの初期化に失敗",
			args: args{
				name: "",
			},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got, err := NewArticleService(tt.args.name)
			if tt.wantErr {
				require.Error(t, err)
				require.Equal(t, "", got.Name().Value())
			} else {
				require.NoError(t, err)
				require.Equal(t, tt.args.name, got.Name().value)
			}
		})
	}
}

func TestArticleService_ID(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  ID
		want uuid.UUID
	}{
		{name: "ok: case1", arg: ID{value: testID}, want: testID},
		{name: "ok: case2", arg: ID{}, want: uuid.Nil},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got := tt.arg.Value()
			assert.Equal(t, tt.want, got)
		})
	}
}

func TestArticleService_Name(t *testing.T) {
	t.Parallel()
	tests := []struct {
		name string
		arg  Name
		want string
	}{
		{name: "ok: case1", arg: Name{value: "aa"}, want: "aa"},
		{name: "ok: case2", arg: Name{value: ""}, want: ""},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got := tt.arg.Value()
			assert.Equal(t, tt.want, got)
		})
	}
}
