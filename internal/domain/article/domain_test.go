package article

import (
	"reflect"
	"testing"
	"time"

	"github.com/go-playground/assert/v2"
	"github.com/stretchr/testify/require"
	"github.com/umekikazuya/momenture/internal/domain/platform"
)

func TestNewArticle(t *testing.T) {
	t.Parallel()
	p, err := platform.NewPlatform(
		"original", platform.OptURL("https://github.com/"),
	)
	require.NoError(t, err)
	type args struct {
		inputTitle    string
		inputPlatform platform.Platform
		opts          []OptFunc
	}
	tests := []struct {
		name string
		args args
		want struct {
			title        string
			link         string
			platformName string
			platformURL  string
			status       string
		}
		wantErr bool
	}{
		{
			name: "ok: case1",
			args: args{
				inputTitle:    "aa",
				inputPlatform: *p,
				opts:          []OptFunc{OptLink("https://github.com/")},
			},
			want: struct {
				title        string
				link         string
				platformName string
				platformURL  string
				status       string
			}{
				title:        "aa",
				link:         "https://github.com/",
				platformName: "original",
				platformURL:  "https://github.com/",
				status:       StatusDraft.Value(),
			},
		},
		{
			name: "ok: case2",
			args: args{
				inputTitle:    "aa",
				inputPlatform: platform.Platform{},
				opts:          []OptFunc{OptLink("https://github.com/")},
			},
			want: struct {
				title        string
				link         string
				platformName string
				platformURL  string
				status       string
			}{
				title:        "aa",
				link:         "https://github.com/",
				platformName: "",
				platformURL:  "",
				status:       StatusDraft.Value(),
			},
		},
		{
			name: "ng: case1",
			args: args{
				inputTitle:    "",
				inputPlatform: *p,
				opts:          []OptFunc{OptLink("https://github.com/")},
			},
			want: struct {
				title        string
				link         string
				platformName string
				platformURL  string
				status       string
			}{
				title:        "",
				link:         "",
				platformName: "",
				platformURL:  "",
				status:       "",
			},
			wantErr: true,
		},
		{
			name: "ng: case2",
			args: args{
				inputTitle:    "aa",
				inputPlatform: *p,
				opts:          []OptFunc{OptLink("")},
			},
			want: struct {
				title        string
				link         string
				platformName string
				platformURL  string
				status       string
			}{
				title:        "",
				link:         "",
				platformName: "",
				platformURL:  "",
				status:       "",
			},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			got, err := NewArticle(tt.args.inputTitle, tt.args.inputPlatform, tt.args.opts...)
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want.title, got.Title().Value())
			assert.Equal(t, tt.want.link, got.Link().Value())
			assert.Equal(t, tt.want.platformName, got.Platform().Name().Value())
			assert.Equal(t, tt.want.platformURL, got.Platform().URL().Value())
			assert.Equal(t, tt.want.status, got.Status().Value())
		})
	}
}

func TestOptTitle(t *testing.T) {
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
			target := &Article{}
			opt := OptTitle(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.Title().Value())
		})
	}
}

func TestOptPlatform(t *testing.T) {
	// TODO: add test
}

func TestOptLink(t *testing.T) {
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
			args:    args{input: ""},
			want:    "",
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			target := &Article{}
			opt := OptLink(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.Link().Value())
		})
	}
}

func TestOptStatus(t *testing.T) {
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
			args:    args{input: "draft"},
			want:    "draft",
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
			target := &Article{}
			opt := OptStatus(tt.args.input)
			got := opt(target)
			if tt.wantErr {
				require.Error(t, got)
			} else {
				require.NoError(t, got)
			}
			require.Equal(t, tt.want, target.Status().Value())
		})
	}
}

func TestArticle_Update(t *testing.T) {
	t.Parallel()
	p, err := platform.NewPlatform(
		"aaa", platform.OptURL("https://github.com/"), platform.OptAccountName("aa"),
	)
	require.NoError(t, err)
	type args struct {
		opts []OptFunc
	}
	tests := []struct {
		name string
		args args
		want struct {
			title  string
			link   string
			status string
		}
		wantErr bool
	}{
		{
			name: "ok: case1",
			args: args{opts: []OptFunc{
				OptLink("https://example.com/"),
				OptStatus(StatusPublished.Value()),
			}},
			want: struct {
				title  string
				link   string
				status string
			}{
				"original", "https://example.com/", StatusPublished.Value(),
			},
			wantErr: false,
		},
		{
			name: "ng: case1",
			args: args{opts: []OptFunc{
				OptLink(""),
				OptStatus(StatusPublished.Value()),
			}},
			want: struct {
				title  string
				link   string
				status string
			}{
				"original", "https://github.com/", StatusDraft.Value(),
			},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			t.Parallel()
			a, err := NewArticle(
				"original", *p, OptLink("https://github.com/"), OptStatus(StatusDraft.Value()),
			)
			require.NoError(t, err)
			// Act
			err = a.Update(tt.args.opts...)
			// Assert
			if tt.wantErr {
				require.Error(t, err)
			} else {
				require.NoError(t, err)
			}
			assert.Equal(t, tt.want.title, a.Title().Value())
			assert.Equal(t, tt.want.link, a.Link().Value())
			assert.Equal(t, tt.want.status, a.Status().Value())
		})
	}
}

func TestArticle_ID(t *testing.T) {
	type fields struct {
		id        ID
		title     Title
		platform  platform.Platform
		link      Link
		status    Status
		createdAt time.Time
		updatedAt time.Time
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
			a := Article{
				id:        tt.fields.id,
				title:     tt.fields.title,
				platform:  tt.fields.platform,
				link:      tt.fields.link,
				status:    tt.fields.status,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := a.ID(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Article.ID() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticle_Title(t *testing.T) {
	t.Parallel()
	type fields struct {
		id        ID
		title     Title
		platform  platform.Platform
		link      Link
		status    Status
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   Title
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			a := Article{
				id:        tt.fields.id,
				title:     tt.fields.title,
				platform:  tt.fields.platform,
				link:      tt.fields.link,
				status:    tt.fields.status,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := a.Title(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Article.Title() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticle_Platform(t *testing.T) {
	type fields struct {
		id        ID
		title     Title
		platform  platform.Platform
		link      Link
		status    Status
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   platform.Platform
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			a := Article{
				id:        tt.fields.id,
				title:     tt.fields.title,
				platform:  tt.fields.platform,
				link:      tt.fields.link,
				status:    tt.fields.status,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := a.Platform(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Article.Platform() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticle_Link(t *testing.T) {
	type fields struct {
		id        ID
		title     Title
		platform  platform.Platform
		link      Link
		status    Status
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   Link
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			a := Article{
				id:        tt.fields.id,
				title:     tt.fields.title,
				platform:  tt.fields.platform,
				link:      tt.fields.link,
				status:    tt.fields.status,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := a.Link(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Article.Link() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestArticle_Status(t *testing.T) {
	type fields struct {
		id        ID
		title     Title
		platform  platform.Platform
		link      Link
		status    Status
		createdAt time.Time
		updatedAt time.Time
	}
	tests := []struct {
		name   string
		fields fields
		want   Status
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			a := Article{
				id:        tt.fields.id,
				title:     tt.fields.title,
				platform:  tt.fields.platform,
				link:      tt.fields.link,
				status:    tt.fields.status,
				createdAt: tt.fields.createdAt,
				updatedAt: tt.fields.updatedAt,
			}
			if got := a.Status(); !reflect.DeepEqual(got, tt.want) {
				t.Errorf("Article.Status() = %v, want %v", got, tt.want)
			}
		})
	}
}
