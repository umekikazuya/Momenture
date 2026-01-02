package article

import "context"

type Repo interface {
	FindAll(ctx context.Context) ([]*Article, error)
	FindByID(ctx context.Context, id ID) (*Article, error)
	Create(ctx context.Context, article *Article) (*Article, error)
	Update(ctx context.Context, article *Article) (*Article, error)
	Delete(ctx context.Context, id ID) error
}
