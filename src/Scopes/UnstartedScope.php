<?php

namespace Jskrd\Shop\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UnstartedScope implements Scope
{
    protected $extensions = ['WithUnstarted', 'WithoutUnstarted', 'OnlyUnstarted'];

    public function apply(Builder $builder, Model $model): void
    {
        $builder
            ->whereNotNull($model->startedAtColumn)
            ->where($model->startedAtColumn, '<=', Carbon::now()->toDateTimeString());
    }

    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithUnstarted(Builder $builder): void
    {
        $builder->macro('withUnstarted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addWithoutUnstarted(Builder $builder): void
    {
        $builder->macro('withoutUnstarted', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder
                ->withoutGlobalScope($this)
                ->whereNotNull($model->startedAtColumn)
                ->where($model->startedAtColumn, '<=', Carbon::now()->toDateTimeString());
        });
    }

    protected function addOnlyUnstarted(Builder $builder): void
    {
        $builder->macro('onlyUnstarted', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder
                ->withoutGlobalScope($this)
                ->whereNull($model->startedAtColumn)
                ->orWhere($model->startedAtColumn, '>', Carbon::now()->toDateTimeString());
        });
    }
}
