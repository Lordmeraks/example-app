<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Person;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{

    public function run()
    {
        $path = storage_path() . "/app/public/tmdb_movies.json";
        $string = file_get_contents($path);
        $json_file = json_decode($string, true);
        $total = count($json_file);

        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        foreach ($json_file as $filmParsed) {
            $film = new Film();
            $film->budget = $filmParsed['budget'] ?? null;
            $film->homepage = $filmParsed['homepage'] ?? null;
            $film->overview = $filmParsed['overview'] ?? null;
            $film->popularity = $filmParsed['popularity'] ?? null;
            $film->poster_path = $filmParsed['poster_path'] ?? null;
            $film->release_date = $filmParsed['release_date'] ?? null;
            $film->revenue = $filmParsed['revenue'] ?? null;
            $film->runtime = $filmParsed['runtime'] ?? null;
            $film->tagline = $filmParsed['tagline'] ?? null;
            $film->title = $filmParsed['title'] ?? null;
            $film->vote_average = $filmParsed['vote_average'] ?? null;
            $film->vote_count = $filmParsed['vote_count'] ?? null;
            $film->similar = json_encode($filmParsed['similar'] ?? null);
            $film->trailer_yt = $filmParsed['trailer_yt'] ?? null;
            $film->external_ids = json_encode($filmParsed['external_ids'] ?? null);
            $language = Language::firstOrCreate(['name' => $filmParsed['original_language'] ?? '']);
            $film->originalLanguage()->associate($language);
            $certification = Certification::firstOrCreate(['name' => $filmParsed['certification'] ?? '']);
            $film->certification()->associate($certification);
            $film->save();
            if (is_array($filmParsed['genres'])) {
                foreach ($filmParsed['genres'] as $genre) {
                    $genre = Genre::firstOrCreate(['name' => $genre]);
                    $film->genres()->attach($genre);
                }
            } elseif (is_string($filmParsed['genres'])) {
                $genre = Genre::firstOrCreate(['name' => $filmParsed['genres']]);
                $film->genres()->attach($genre);
            }
            foreach ($filmParsed['directors'] as $person) {
                $person = Person::firstOrCreate(['full_name' => $person['name']]);
                $film->directors()->attach($person);
            }
            foreach ($filmParsed['writers'] as $person) {
                $person = Person::firstOrCreate(['full_name' => $person['name']]);
                $film->writers()->attach($person);;
            }
            foreach ($filmParsed['cast'] as $person) {
                $person = Person::firstOrCreate(['full_name' => $person['name']]);
                $film->cast()->attach($person);;
            }
            $film->save();
            $bar->advance();
        }
        $bar->finish();
    }
}
