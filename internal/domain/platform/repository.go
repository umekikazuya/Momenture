package platform

import "context"

type Repo interface {
	FindAll(ctx context.Context) ([]*Platform, error)
	FindByID(ctx context.Context, id ID) (*Platform, error)
	Create(ctx context.Context, platform *Platform) (*Platform, error)
	Update(ctx context.Context, platform *Platform) (*Platform, error)
	Delete(ctx context.Context, id ID) error
}
