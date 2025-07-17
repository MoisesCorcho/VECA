<?php

namespace App\Services;

use App\Models\Task;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function createTasksFromSurveyAnswer(SurveyAnswer $surveyAnswer): void
    {
        $taskQuestions = $surveyAnswer->surveyQuestionAnswers()
            ->whereHas('surveyQuestion', function ($query) {
                $query->where('is_task_trigger', true);
            })
            ->whereNotNull('answer')
            ->where('answer', '!=', '')
            ->get();

        foreach ($taskQuestions as $questionAnswer) {
            if (! empty($questionAnswer->answer)) {
                $this->createTask($questionAnswer);
            }
        }
    }

    private function createTask(SurveyQuestionAnswer $questionAnswer): Task
    {
        return Task::create([
            'title' => $questionAnswer->answer,
            'status' => 'pending',
            'user_id' => $questionAnswer->surveyAnswer->user_id,
        ]);
    }

    public function getTasksForUser(int $userId, ?string $status): Collection
    {
        return Task::query()
            ->forUser($userId)
            ->filterByStatus($status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function completeTask(int $taskId, int $userId): bool
    {
        $task = Task::pending()
            ->forUser($userId)
            ->find($taskId);

        if (!$task) {
            return false;
        }

        $task->markAsCompleted();
        return true;
    }

    public function cancelTask(int $taskId, int $userId): bool
    {
        $task = Task::pending()
            ->forUser($userId)
            ->find($taskId);

        if (!$task) {
            return false;
        }

        $task->markAsCancelled();
        return true;
    }

    public function getTaskStats(int $userId): array
    {
        return [
            'pending' => Task::pending()->forUser($userId)->count(),
            'completed' => Task::completed()->forUser($userId)->count(),
            'cancelled' => Task::cancelled()->forUser($userId)->count(),
            'total' => Task::forUser($userId)->count(),
        ];
    }
}
