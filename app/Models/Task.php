<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Mass assignment rules
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean'
    ];

    /**
     * @var string[]
     */
    protected $touches = ['project'];

    public function path()
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->project->recordActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->project->recordActivity('task_incompleted');
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
