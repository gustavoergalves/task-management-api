<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $position
 * @property string|null $department
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'position',
        'department',
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'employee_task')->withTimestamps();
    }
}
