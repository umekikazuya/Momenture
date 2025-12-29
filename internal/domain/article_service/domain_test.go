package articleservice

import (
	"reflect"
	"testing"
	"time"

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
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got, err := NewArticleService(tt.args.name)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			require.Equal(t, tt.args.name, got.Name().value)
		})
	}
}

func TestArticleService_ID(t *testing.T) {
	type fields struct {
		id        ID
		name      Name
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name string
		want ID
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
		})
	}
}

func TestArticleService_Name(t *testing.T) {
	type fields struct {
		id        ID
		name      Name
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   Name
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			as := &ArticleService{
				id:        tt.fields.id,
				name:      tt.fields.name,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := as.Name(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("ArticleService.Name() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticleService_CreatedAt(t *testing.T) {
	type fields struct {
		id        ID
		name      Name
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   time.Time
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			as := &ArticleService{
				id:        tt.fields.id,
				name:      tt.fields.name,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := as.CreatedAt(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("ArticleService.CreatedAt() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticleService_UpdatedAt(t *testing.T) {
	type fields struct {
		id        ID
		name      Name
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   time.Time
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			as := &ArticleService{
				id:        tt.fields.id,
				name:      tt.fields.name,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := as.UpdatedAt(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("ArticleService.UpdatedAt() = %v, want %v", got, tt.want)
			}
		})
	}
}
