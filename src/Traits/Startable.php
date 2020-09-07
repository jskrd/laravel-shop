<?php

namespace Jskrd\Shop\Traits;

use Carbon\Carbon;
use Jskrd\Shop\Scopes\UnstartedScope;

trait Startable
{
    public $startedAtColumn = 'started_at';

    public static function bootStartable(): void
    {
        static::addGlobalScope(new UnstartedScope());
    }

    public function initializeStartable(): void
    {
        $this->dates[] = $this->startedAtColumn;

        $this->fillable[] = $this->startedAtColumn;
    }

    public function started(): bool
    {
        return (
            $this->{$this->startedAtColumn} !== null &&
            $this->{$this->startedAtColumn}->lessThanOrEqualTo(Carbon::now())
        );
    }
}
