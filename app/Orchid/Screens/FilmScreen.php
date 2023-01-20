<?php

namespace App\Orchid\Screens;

use App\Models\Film;
use App\Models\Language;
use App\Orchid\Layouts\FilmFiltersLayout;
use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\NumberRange;
use Orchid\Screen\Fields\Select;
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
            'films' => Film::with(['originalLanguage', 'genres'])
                ->filters(FilmFiltersLayout::class)
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
     * @throws BindingResolutionException
     */
    public function layout(): iterable
    {
        return [
            FilmFiltersLayout::class,
            Layout::table('films', [
                TD::make('title', 'Title')->filter(Input::make())->sort(),
                TD::make('budget', 'Budget')->filter(NumberRange::make())->sort(),
                TD::make('vote_average', 'Average vote')->sort(),
                TD::make('original_language_id', 'Original language')
                    ->render(function (Film $film) {
                        return $film->originalLanguage->name;
                    })
                    ->filter(Select::make()
                        ->fromModel(Language::class, 'name')
                        ->empty('No select')
                    ),
                TD::make('genres', 'Genres')
                    ->render(function (Film $film) {
                        return $film->genres->implode('name', ', ');
                    }),
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
