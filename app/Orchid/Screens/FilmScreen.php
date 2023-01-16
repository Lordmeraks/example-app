<?php

namespace App\Orchid\Screens;

use App\Models\Film;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FilmScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'films' => Film::with('originalLanguage')
                ->filters()
                ->defaultSort('vote_average', 'DESC')
                ->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Your Films';
    }

    public function description(): ?string
    {
        return 'Manage your films';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('films', [
                TD::make('title', 'Title'),
                TD::make('budget', 'Budget'),
                TD::make('vote_average', 'Average vote'),
                TD::make('originalLanguage.name', 'Original language'),
                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Film $film) {
                        return Button::make('Delete')
                            ->confirm('After deleting, the film will be gone forever.')
                            ->icon('trash')
                            ->method('remove', ['film' => $film->id]);
                    }),
            ])
        ];
    }

    /**
     * @param Film $film
     */
    public function remove(Film $film): void
    {
        $film->writers()->detach();
        $film->directors()->detach();
        $film->cast()->detach();
        $film->genres()->detach();
        $film->delete();

        Toast::info(__('Film was removed'));
    }
}
