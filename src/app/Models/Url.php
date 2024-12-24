<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $original_url
 * @property string $short_code
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Url extends Model
{
    protected $guarded = [];
}
