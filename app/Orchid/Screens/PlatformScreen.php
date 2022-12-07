<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Task;
use App\Models\Team;
use App\Models\Member;
use Orchid\Screen\Screen;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Actions\Button;
use App\Events\StatusTasksUpdated;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public $models = [
        'tasks' => Task::class,
        'teams' => Team::class,
        'members' => Member::class,
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tasks' => Task::get(),
            'teams' => Team::get(),
            'members' => Member::get(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Главная';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Главная';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Matrix::make('members')
                    ->title('Участники')
                    ->columns([
                        'ID' => 'id',
                        'Имя' => 'name',
                        'Фамилия' => 'last_name',
                        'Фото' => 'photo',
                        'Команда' => 'team_id',
                        'Задание' => 'task_id',
                        'Помощник' => 'helper_id',
                        'Победитель' => 'is_winner'
                    ])
                    ->fields([
                        'id' => Input::make('members')->type('number')
                            ->fromModel(Member::class, 'id'),
                        'name' => Input::make('members')->type('text')
                            ->fromModel(Member::class, 'name'),
                        'last_name' => Input::make('members')->type('text')
                            ->fromModel(Member::class, 'last_name'),
                        'photo' => Input::make('members')->type('text')
                            ->fromModel(Member::class, 'photo'),
                        'team_id' => Relation::make('team')
                            ->fromModel(Team::class, 'name'),
                        'task_id' => Relation::make('task')
                            ->fromModel(Task::class, 'name'),
                        'helper_id' => Relation::make('member')
                            ->fromModel(Member::class, 'name')
                            ->displayAppend('full')
                            ->empty('Не выбрано', null),
                        'is_winner' => CheckBox::make('members')->sendTrueOrFalse()
                            ->fromModel(Member::class, 'is_winner'),
                    ]),
            ]),
            Layout::rows([
                Matrix::make('tasks')
                    ->title('Задания')
                    ->columns([
                        'ID' => 'id',
                        'Названия' => 'name',
                        'Решено' => 'is_solved',
                    ])
                    ->fields([
                        'id' => Input::make('tasks')->type('number')
                            ->fromModel(Task::class, 'id'),
                        'name' => Input::make('tasks')->type('text')
                            ->fromModel(Task::class, 'name'),
                        'is_solved' => CheckBox::make('tasks')->sendTrueOrFalse()
                            ->fromModel(Task::class, 'last_name'),
                    ]),
            ]),
            Layout::rows([
                Matrix::make('teams')
                    ->title('Команды')
                    ->columns([
                        'ID' => 'id',
                        'Названия' => 'name',
                    ])
                    ->fields([
                        'id' => Input::make('members')->type('number')
                            ->fromModel(Team::class, 'id'),
                        'name' => Input::make('members')->type('text')
                            ->fromModel(Team::class, 'name'),
                    ]),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $data = [
            'tasks' => $request->get('tasks'),
            'teams' => $request->get('teams'),
            'members' => $request->get('members'),
        ];

        $this->saveModelsCollection($data);
        StatusTasksUpdated::dispatch($data);

        return redirect()->route('platform.main');
    }

    private function saveModelsCollection(array $models)
    {
        foreach ($models as $key => $data) {
            $model = new $this->models[$key]();
            foreach ($data as $val) {
                $model->upsert($val, ['id']);
            }
        }
    }
}
