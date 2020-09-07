<?php

namespace Jskrd\Shop\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EndedScope implements Scope
{
    protected $extensions = ['WithEnded', 'WithoutEnded', 'OnlyEnded'];

    public function apply(Builder $builder, Model $model): void
    {
        $builder
            ->whereNull($model->endedAtColumn)
            ->orWhere($model->endedAtColumn, '>', Carbon::now()->toDateTimeString());
    }

    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithEnded(Builder $builder): void
    {
        $builder->macro('withEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addWithoutEnded(Builder $builder): void
    {
        $builder->macro('withoutEnded', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder
                ->withoutGlobalScope($this)
                ->whereNull($model->endedAtColumn)
                ->orWhere($model->endedAtColumn, '>', Carbon::now()->toDateTimeString());
        });
    }

    protected function addOnlyEnded(Builder $builder): void
    {
        $builder->macro('onlyEnded', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder
                ->withoutGlobalScope($this)
                ->whereNotNull($model->endedAtColumn)
                ->where($model->endedAtColumn, '<=', Carbon::now()->toDateTimeString());
        });
    }
}
