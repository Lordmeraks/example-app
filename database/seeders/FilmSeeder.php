<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    private Collection $persons;
    private Collection $languages;
    private Collection $certifications;
    private Collection $genres;

    public function __construct()
    {
        $this->persons = new Collection();
        $this->languages = new Collection();
        $this->certifications = new Collection();
        $this->genres = new Collection();
    }

    private function getPerson($name)
    {
        if ($this->persons->has($name)) {
            return $this->persons->get($name);
        } else {
            $person = Person::create(['full_name' => $name]);
            $this->persons->put($name, $person);
            return $person;
        }
    }

    private function getCertification($name)
    {
        if (is_null($name)) {
            $key = 'none';
        } else {
            $key = $name;
        }
        if ($this->certifications->has($key)) {
            return $this->certifications->get($key);
        } else {
            $item = Certification::create(['name' => $name ?? '']);
            $this->certifications->put($key, $item);
            return $item;
        }
    }

    private function getGenre($name)
    {
        if ($this->genres->has($name)) {
            return $this->genres->get($name);
        } else {
            $item = Genre::create(['name' => $name]);
            $this->genres->put($name, $item);
            return $item;
        }
    }

    private function getLanguage($name)
    {
        if (is_null($name)) {
            $key = 'none';
        } else {
            $key = $name;
        }
        if ($this->languages->has($key)) {
            return $this->languages->get($key);
        } else {
            $item = Language::create(['name' => $name ?? '']);
            $this->languages->put($key, $item);
            return $item;
        }
    }

    public function run()
    {
        $path = storage_path('/app/public/tmdb_movies.json');
        try {
            $string = file_get_contents($path);
            if (!$string) {
                throw new \Exception('File not found or corrupted');
            }
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
                if (is_null($film->title)) {
                    continue;
                }
                $film->vote_average = $filmParsed['vote_average'] ?? null;
                $film->vote_count = $filmParsed['vote_count'] ?? null;
                $film->similar = json_encode($filmParsed['similar'] ?? null);
                $film->trailer_yt = $filmParsed['trailer_yt'] ?? null;
                $film->external_ids = json_encode($filmParsed['external_ids'] ?? null);
                $language = $this->getLanguage($filmParsed['original_language'] ?? null);
                $film->originalLanguage()->associate($language);
                $certification = $this->getCertification($filmParsed['certification'] ?? null);
                $film->certification()->associate($certification);
                $film->save();

                if (is_array($filmParsed['genres'])) {
                    foreach ($filmParsed['genres'] as $genre) {
                        $genre = $this->getGenre($genre);
                        $film->genres()->attach($genre);
                    }
                } elseif (is_string($filmParsed['genres'])) {
                    $genre = $this->getGenre($filmParsed['genres']);
                    $film->genres()->attach($genre);
                }

                foreach ($filmParsed['directors'] as $person) {
                    $person = $this->getPerson($person['name']);
                    $film->directors()->attach($person);
                }

                foreach ($filmParsed['writers'] as $person) {
                    $person = $this->getPerson($person['name']);
                    $film->writers()->attach($person);;
                }

                foreach ($filmParsed['cast'] as $person) {
                    $person = $this->getPerson($person['name']);
                    $film->cast()->attach($person);;
                }

                $film->save();
                $bar->advance();
            }

            $bar->finish();
        } catch (\Exception $e) {
            $this->command->getOutput()->writeln($e->getMessage());
        }
    }
}
