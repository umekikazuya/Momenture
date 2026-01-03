package feed

import (
	"context"
	"net/http"
	"net/http/httptest"
	"testing"
	"time"
)

func TestFeedFetcher_Handle(t *testing.T) {
	t.Parallel()

	// Mockサーバーを生成
	mockServer := httptest.NewServer(http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		w.WriteHeader(http.StatusOK)
		w.Write([]byte(`<?xml version="1.0"?><rss><channel><title>Test Feed</title></channel></rss>`))
	}))
	defer mockServer.Close()

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
				ctx: ctx,
				url: mockServer.URL,
			},
			wantErr: false,
		},
		{
			name: "ng: case1",
			fields: fields{
				client: &http.Client{Timeout: 10 * time.Second},
			},
			args: args{
				ctx: ctx,
				url: "http://invalid-url-that-does-not-exist.example.com",
			},
			wantErr: true,
		},
	}
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			f := &FeedFetcher{
				client: tt.fields.client,
			}
			got, err := f.Handle(tt.args.ctx, tt.args.url)
			if (err != nil) != tt.wantErr {
				t.Fatalf("FeedFetcher.Handle() error = %v, wantErr %v", err, tt.wantErr)
			}
			if tt.wantErr {
				return
			}
			if len(got) == 0 {
				t.Error("FeedFetcher.Handle() returned empty body")
			}
		})
	}
}
