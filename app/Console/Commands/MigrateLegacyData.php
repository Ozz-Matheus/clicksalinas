<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MigrateLegacyData extends Command
{
    protected $signature = 'app:migrate-legacy-data';

    protected $description = 'Migra datos desde la BD de 2018 a la nueva estructura conservando IDs y SEO';

    public function handle(): void
    {
        $this->info('Iniciando migración histórica (ETL)...');

        // Desactivar llaves foráneas temporalmente para insertar IDs exactos y evitar errores de restricción
        Schema::disableForeignKeyConstraints();

        // Limpiar tablas destino (te permite correr el comando varias veces si estás haciendo pruebas)
        $this->warn('Limpiando tablas de destino...');
        DB::table('services')->truncate();
        DB::table('albums')->truncate();
        DB::table('categories')->truncate();
        DB::table('posts')->truncate();
        DB::table('tags')->truncate();
        DB::table('post_tag')->truncate();
        DB::table('media')->truncate();
        DB::table('emails')->truncate();
        DB::table('static_pages')->truncate();

        // --- 1. Módulo Portafolio ---

        $this->info('Migrando Servicios (antiguo photographs)...');
        $services = DB::connection('legacy')->table('photographs')->get();
        foreach ($services as $service) {
            DB::table('services')->insert([
                'id' => $service->id,
                'name' => $service->name,
                'slug' => $service->url, // El mapeo clave para el SEO
                'description' => $service->cover_paragraph ?? null,
                'created_at' => $service->created_at,
                'updated_at' => $service->updated_at,
            ]);
        }

        $this->info('Migrando Álbumes (antiguo pages)...');
        $albums = DB::connection('legacy')->table('pages')->get();
        foreach ($albums as $album) {
            DB::table('albums')->insert([
                'id' => $album->id,
                'title' => $album->title,
                'slug' => $album->url, // El mapeo clave para el SEO
                'body' => $album->body ?? null,
                'published_at' => $album->published_at ?? null,
                'service_id' => $album->photography_id ?? null, // Mapeo de la llave foránea
                'user_id' => 2, // Asumimos un usuario por defecto si no existía
                'created_at' => $album->created_at,
                'updated_at' => $album->updated_at,
            ]);
        }

        $this->info('Migrando Fotografías de Álbumes a la tabla Media...');
        // Usamos chunk(500) para no saturar la memoria RAM con 5,000 registros de golpe
        DB::connection('legacy')->table('images')->orderBy('id')->chunk(500, function ($images) {
            $mediaData = [];
            foreach ($images as $img) {
                $mediaData[] = [
                    'id' => $img->id, // Respetamos el ID original
                    'mediable_type' => 'App\Models\Album', // Definición de la relación polimórfica
                    'mediable_id' => $img->page_id,
                    'name' => $img->name, // El texto ALT original
                    'file_path' => $img->url, // La ruta física original
                    'created_at' => $img->created_at,
                    'updated_at' => $img->updated_at,
                ];
            }
            DB::table('media')->insert($mediaData);
            $this->output->write('.'); // Indicador visual de progreso
        });
        $this->newLine();

        // --- 2. Módulo Blog ---

        $this->info('Migrando Categorías del Blog...');
        $categories = DB::connection('legacy')->table('categories')->get();
        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->url,
                'created_at' => $cat->created_at,
                'updated_at' => $cat->updated_at,
            ]);
        }

        $this->info('Migrando Posts...');
        $posts = DB::connection('legacy')->table('posts')->get();
        foreach ($posts as $post) {
            DB::table('posts')->insert([
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->url,
                'excerpt' => $post->excerpt ?? null,
                'iframe' => $post->iframe ?? null,
                'body' => $post->body ?? null,
                'published_at' => $post->published_at ?? null,
                'category_id' => $post->category_id,
                'user_id' => 2, // Asumimos un usuario por defecto si no existía
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]);
        }

        $this->info('Migrando Tags...');
        $tags = DB::connection('legacy')->table('tags')->get();
        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->url,
                'created_at' => $tag->created_at,
                'updated_at' => $tag->updated_at,
            ]);
        }

        $this->info('Migrando Tabla Pivote (Post_Tag)...');
        $postTags = DB::connection('legacy')->table('post_tag')->get();
        foreach ($postTags as $pt) {
            DB::table('post_tag')->insert([
                'id' => $pt->id,
                'post_id' => $pt->post_id,
                'tag_id' => $pt->tag_id,
            ]);
        }

        // Migramos las fotos de los posts si existían en la tabla vieja
        if (Schema::connection('legacy')->hasTable('photos')) {
            $this->info('Migrando Fotografías de Posts a Media...');

            // Calculamos el último ID insertado para evitar colisiones con los IDs de las imágenes de álbumes
            $lastMediaId = DB::table('media')->max('id') ?? 0;

            DB::connection('legacy')->table('photos')->orderBy('id')->chunk(500, function ($photos) use (&$lastMediaId) {
                $mediaData = [];
                foreach ($photos as $photo) {
                    $lastMediaId++;
                    $mediaData[] = [
                        'id' => $lastMediaId, // Creamos un nuevo ID consecutivo
                        'mediable_type' => 'App\Models\Post',
                        'mediable_id' => $photo->post_id,
                        'name' => $photo->name ?? null,
                        'file_path' => $photo->url,
                        'created_at' => $photo->created_at ?? now(),
                        'updated_at' => $photo->updated_at ?? now(),
                    ];
                }
                DB::table('media')->insert($mediaData);
                $this->output->write('.');
            });
            $this->newLine();
        }

        // --- 3. Módulo Buzón de Contacto ---
        if (Schema::connection('legacy')->hasTable('emails')) {
            $this->info('Migrando Buzón de Correos...');
            $emails = DB::connection('legacy')->table('emails')->get();

            $emailsData = [];
            foreach ($emails as $email) {
                $emailsData[] = [
                    'id' => $email->id,
                    'name' => $email->name ?? 'Sin nombre',
                    'email' => $email->email ?? 'sin@correo.com',
                    'phone' => $email->phone ?? 'No proporcionado',
                    'message' => $email->message ?? null,
                    'created_at' => $email->created_at ?? now(),
                    'updated_at' => $email->updated_at ?? now(),
                ];
            }

            // Usamos insert masivo ya que no son miles de registros pesados
            DB::table('emails')->insert($emailsData);
            $this->info('Correos migrados correctamente.');
        } else {
            $this->warn('No se encontró la tabla emails en la base de datos antigua, omitiendo...');
        }

        // --- 4. Módulo Páginas Estáticas (antiguo multimedia) ---
        if (Schema::connection('legacy')->hasTable('multimedia')) {
            $this->info('Migrando Páginas Estáticas (antiguo multimedia a static_pages)...');
            $multimediaRecords = DB::connection('legacy')->table('multimedia')->get();

            $staticPagesData = [];
            foreach ($multimediaRecords as $page) {
                $staticPagesData[] = [
                    'name' => $page->name ?? 'Página '.$page->id,
                    // Si tu vieja tabla usaba 'url', lo mapeamos a 'slug', si no, lo generamos del nombre
                    'slug' => $page->url ?? Str::slug($page->name ?? 'pagina-'.$page->id),
                    'cover_title' => $page->cover_title ?? null,
                    'cover_paragraph' => $page->cover_paragraph ?? null,
                    'info_title' => $page->info_title ?? null,
                    'info_paragraph' => $page->info_paragraph ?? null,
                    // Si manejabas la portada ahí mismo:
                    'cover_image_path' => $page->cover_image_path ?? null,
                    'gallery' => null, // Asumimos null porque ahora se maneja diferente o en JSON
                    'created_at' => $page->created_at ?? now(),
                    'updated_at' => $page->updated_at ?? now(),
                ];
            }

            DB::table('static_pages')->insert($staticPagesData);
            $this->info('Páginas estáticas migradas correctamente.');
        } else {
            $this->warn('No se encontró la tabla multimedia en legacy. Omitiendo...');
        }

        Schema::enableForeignKeyConstraints();

        $this->info('¡Migración ETL completada exitosamente! Tu SEO y tus relaciones relacionales están intactos.');
    }
}
