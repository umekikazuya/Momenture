package platform

import (
	"reflect"
	"testing"
	"time"

	"github.com/stretchr/testify/require"
)

func TestNewPlatform(t *testing.T) {
	type args struct {
		name string
		opts []OptFunc
	}
	tests := []struct {
		name string
		args args
		want struct {
			name        string
			accountName string
			url         string
		}
		wantErr bool
	}{
		{
			name: "ok: case1",
			args: args{name: "aa", opts: []OptFunc{OptAccountName("aiueo"), OptURL("https://github.com/")}},
			want: struct {
				name        string
				accountName string
				url         string
			}{
				name:        "aa",
				accountName: "aiueo",
				url:         "https://github.com/",
			},
			wantErr: false,
		},
		{
			name: "ng: case1 - Nameオブジェクトの初期化に失敗",
			args: args{name: "", opts: []OptFunc{OptAccountName("aiueo"), OptURL("https://github.com/")}},
			want: struct {
				name        string
				accountName string
				url         string
			}{
				name:        "",
				accountName: "",
				url:         "",
			},
			wantErr: true,
		},
		{
			name: "ng: case2 - FunctionalOptionでエラー",
			args: args{name: "aa", opts: []OptFunc{OptAccountName(""), OptURL("https://github.com/")}},
			want: struct {
				name        string
				accountName string
				url         string
			}{
				name:        "",
				accountName: "",
				url:         "",
			},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewPlatform(tt.args.name, tt.args.opts...)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			require.Equal(t, tt.want.name, got.Name().Value())
			require.Equal(t, tt.want.accountName, got.AccountName().Value())
			require.Equal(t, tt.want.url, got.URL().Value())
		})
	}
}

func TestPlatform_Update(t *testing.T) {
	t.Parallel()
	// originalName := "before"
	// as, err := NewPlatform(originalName)
	// require.NoError(t, err)
	tests := []struct {
		name    string
		entity  Platform
		args    string
		wantErr bool
	}{
		// {name: "ok: case1", entity: as, args: "after", wantErr: false},
		// {name: "ng: case1", entity: as, args: "", wantErr: true},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			// err = tt.entity.Update(tt.args)
			// if tt.wantErr {
			// 	require.Error(t, err)
			// 	assert.Equal(t, originalName, tt.entity.Name().Value())
			// } else {
			// 	require.NoError(t, err)
			// 	assert.Equal(t, tt.args, tt.entity.Name().Value())
			// }
		})
	}
}

func TestOptName(t *testing.T) {
	t.Parallel()
	type args struct {
		input string
	}
	tests := []struct {
		name    string
		args    args
		want    string
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{input: "aa"},
			want:    "aa",
			wantErr: false,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			target := &Platform{}
			opt := OptName(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.Name().Value())
		})
	}
}

func TestOptAccountName(t *testing.T) {
	t.Parallel()
	type args struct {
		input string
	}
	tests := []struct {
		name    string
		args    args
		want    string
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{input: "aa"},
			want:    "aa",
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    args{input: ""},
			want:    "",
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			target := &Platform{}
			opt := OptAccountName(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.AccountName().Value())
		})
	}
}

func TestOptURL(t *testing.T) {
	t.Parallel()
	type args struct {
		input string
	}
	tests := []struct {
		name    string
		args    args
		want    string
		wantErr bool
	}{
		{
			name:    "ok: case1",
			args:    args{input: "https://github.com/"},
			want:    "https://github.com/",
			wantErr: false,
		},
		{
			name:    "ng: case1",
			args:    args{input: "aaa"},
			want:    "",
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			target := &Platform{}
			opt := OptURL(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
				t.Log(got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.URL().Value())
		})
	}
}

func TestPlatform_ID(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   ID
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.ID(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.ID() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestPlatform_Name(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
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
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.Name(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.Name() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestPlatform_AccountName(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   AccountName
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.AccountName(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.AccountName() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestPlatform_URL(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   URL
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.URL(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.URL() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestPlatform_CreatedAt(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
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
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.CreatedAt(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.CreatedAt() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestPlatform_UpdatedAt(t *testing.T) {
	type fields struct {
		id          ID
		name        Name
		accountName AccountName
		url         URL
		createdAt   time.Time
		updatedAt   time.Time
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
			p := Platform{
				id:          tt.fields.id,
				name:        tt.fields.name,
				accountName: tt.fields.accountName,
				url:         tt.fields.url,
				createdAt:   tt.fields.createdAt,
				updatedAt:   tt.fields.updatedAt,
			}
			if got := p.UpdatedAt(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Platform.UpdatedAt() = %v, want %v", got, tt.want)
			}
		})
	}
}
