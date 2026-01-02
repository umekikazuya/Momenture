package feed

import (
	"context"
	"net/http"
	"reflect"
	"testing"
	"time"

	application "github.com/umekikazuya/momenture/internal/application/feed"
)

func TestNewFeedFetcher(t *testing.T) {
	tests := []struct {
		name    string
		want    application.FeedFetcher
		wantErr bool
	}{
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := NewFeedFetcher()
			if tt.wantErr {
				return
			}
			if !reflect.DeepEqual(got, tt.want) {
				t.Errorf("NewFeedFetcher() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestFeedFetcher_Handle(t *testing.T) {
	t.Parallel()
	ctx := context.Background()
	type fields struct {
		client *http.Client
	}
	type args struct {
		ctx context.Context
		url string
	}
	tests := []struct {
		name    string
		fields  fields
		args    args
		want    []byte
		wantErr bool
	}{
		{
			name: "ok: case1",
			fields: fields{
				client: &http.Client{Timeout: 10 * time.Second},
			},
			args: args{
				ctx,
				"https://qiita.com/popular-items/feed",
			},
		},
		// TODO: Add test cases.
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			f := &FeedFetcher{
				client: tt.fields.client,
			}
			_, err := f.Handle(tt.args.ctx, tt.args.url)
			if (err != nil) != tt.wantErr {
				t.Fatalf("FeedFetcher.Handle() error = %v, wantErr %v", err, tt.wantErr)
			}
			if tt.wantErr {
				return
			}
		})
	}
}
