<?php

namespace Jskrd\Shop\Traits;

use Carbon\Carbon;
use Jskrd\Shop\Scopes\EndedScope;

trait Endable
{
    public $endedAtColumn = 'ended_at';

    public static function bootEndable(): void
    {
        static::addGlobalScope(new EndedScope());
    }

    public function ended(): bool
    {
        return (
            $this->{$this->endedAtColumn} !== null &&
            $this->{$this->endedAtColumn}->lessThanOrEqualTo(Carbon::now())
        );
    }

    public function initializeEndable(): void
    {
        $this->dates[] = $this->endedAtColumn;

        $this->fillable[] = $this->endedAtColumn;
    }
}
