<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Pengumuman;
use App\Models\AgendaKegiatan;
use App\Models\Gallery;
use App\Models\Layanan;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/berita')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/kategori')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/pengumuman')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/agenda')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/data')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/galeri')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/struktur-organisasi')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/sambutan-pimpinan')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Dynamic URLs: Berita
        Post::query()->where('status', 'published')->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(Url::create(route('berita.show', $post->slug))
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        });

        // Dynamic URLs: Pengumuman
        Pengumuman::all()->each(function (Pengumuman $pengumuman) use ($sitemap) {
            $sitemap->add(Url::create(route('pengumuman.show', $pengumuman->slug))
                ->setLastModificationDate($pengumuman->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
        });

        // Dynamic URLs: Agenda
        AgendaKegiatan::all()->each(function (AgendaKegiatan $agenda) use ($sitemap) {
            $sitemap->add(Url::create(route('agenda.show', $agenda->id))
                ->setLastModificationDate($agenda->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
        });

        // Dynamic URLs: Galeri
        Gallery::query()->whereNotNull('published_at')->get()->each(function (Gallery $gallery) use ($sitemap) {
            $sitemap->add(Url::create(route('galeri.show', $gallery->slug))
                ->setLastModificationDate($gallery->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6));
        });
        
        // Dynamic URLs: Layanan
        Layanan::all()->each(function (Layanan $layanan) use ($sitemap) {
            $sitemap->add(Url::create(url("/layanan/{$layanan->slug}"))
                ->setLastModificationDate($layanan->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
