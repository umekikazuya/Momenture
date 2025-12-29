package platform

import (
	"testing"

	"github.com/go-playground/assert/v2"
	"github.com/stretchr/testify/require"
)

func TestNewPlatform(t *testing.T) {
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
			got, err := NewPlatform(tt.args.name)
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

func TestPlatform_Update(t *testing.T) {
	t.Parallel()
	originalName := "before"
	as, err := NewPlatform(originalName)
	require.NoError(t, err)
	tests := []struct {
		name    string
		entity  Platform
		args    string
		wantErr bool
	}{
		{name: "ok: case1", entity: as, args: "after", wantErr: false},
		{name: "ng: case1", entity: as, args: "", wantErr: true},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			err = tt.entity.Update(tt.args)
			if tt.wantErr {
				require.Error(t, err)
				assert.Equal(t, originalName, tt.entity.Name().Value())
			} else {
				require.NoError(t, err)
				require.NoError(t, err)
				assert.Equal(t, tt.args, tt.entity.Name().Value())
			}
		})
	}
}
