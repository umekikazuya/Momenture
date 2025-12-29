package articleservice

import (
	"testing"

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

