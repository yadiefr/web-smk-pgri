<?php

namespace App\Console\Commands;

use App\Helpers\HostingStorageHelper;
use App\Models\GaleriFoto;
use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncStorageToHosting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:sync-hosting 
                           {--dry-run : Show what would be synced without actually doing it}
                           {--force : Force sync even if not in hosting environment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync storage files from project/storage/app/public to public_html/storage for hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Storage Hosting Sync Tool');
        $this->newLine();

        $isDryRun = $this->option('dry-run');
        $isForced = $this->option('force');

        // Check hosting environment
        $isHosting = HostingStorageHelper::isHostingEnvironment();

        if (! $isHosting && ! $isForced) {
            $this->warn('⚠️  Not in hosting environment. Use --force to run anyway.');

            return;
        }

        if ($isDryRun) {
            $this->info('🧪 DRY RUN MODE - No files will be moved');
            $this->newLine();
        }

        // Get hosting paths
        $paths = HostingStorageHelper::getHostingPaths();

        $this->info('📂 Hosting Paths:');
        $this->table(['Path Type', 'Location'], [
            ['Current Laravel', $paths['current_laravel']],
            ['Laravel Storage', $paths['laravel_storage']],
            ['Public HTML', $paths['public_html']],
            ['Public Storage', $paths['public_storage']],
        ]);
        $this->newLine();

        // Ensure directories exist
        if (! $isDryRun) {
            $this->info('📁 Creating directories...');
            $dirResults = HostingStorageHelper::ensureHostingDirectories();
            foreach ($dirResults as $name => $result) {
                $this->line("  - $name: $result");
            }
            $this->newLine();
        }

        // Sync Settings Images
        $this->syncSettingsImages($paths, $isDryRun);

        // Sync Gallery Photos
        $this->syncGalleryPhotos($paths, $isDryRun);

        $this->newLine();
        $this->info('✅ Storage sync completed!');
    }

    private function syncSettingsImages($paths, $isDryRun)
    {
        $this->info('📸 Syncing Settings Images...');

        $imageSettings = Settings::where('type', 'image')->whereNotNull('value')->get();

        if ($imageSettings->isEmpty()) {
            $this->warn('  No image settings found.');

            return;
        }

        $syncCount = 0;
        $skipCount = 0;

        foreach ($imageSettings as $setting) {
            if (empty($setting->value)) {
                continue;
            }

            $relativePath = $setting->value;
            $sourceFile = $paths['current_storage'].'/'.$relativePath;
            $targetFile = $paths['public_storage'].'/'.$relativePath;

            if (! file_exists($sourceFile)) {
                $this->warn("  ⚠️  Source not found: $relativePath");

                continue;
            }

            if (file_exists($targetFile)) {
                $this->line("  ✓ Already exists: $relativePath");
                $skipCount++;

                continue;
            }

            if ($isDryRun) {
                $this->info("  📋 Would sync: $relativePath");
                $syncCount++;
            } else {
                $targetDir = dirname($targetFile);
                if (! is_dir($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                if (copy($sourceFile, $targetFile)) {
                    @chmod($targetFile, 0644);
                    $this->info("  ✅ Synced: $relativePath");
                    $syncCount++;
                } else {
                    $this->error("  ❌ Failed: $relativePath");
                }
            }
        }

        $this->line("  📊 Settings: $syncCount synced, $skipCount skipped");
    }

    private function syncGalleryPhotos($paths, $isDryRun)
    {
        $this->info('🖼️  Syncing Gallery Photos...');

        $photos = GaleriFoto::all();

        if ($photos->isEmpty()) {
            $this->warn('  No gallery photos found.');

            return;
        }

        $syncCount = 0;
        $skipCount = 0;

        foreach ($photos as $photo) {
            if (empty($photo->foto)) {
                continue;
            }

            $relativePath = 'galeri/'.$photo->foto;
            $sourceFile = $paths['current_storage'].'/'.$relativePath;
            $targetFile = $paths['public_storage'].'/'.$relativePath;

            if (! file_exists($sourceFile)) {
                $this->warn("  ⚠️  Source not found: $relativePath");

                continue;
            }

            if (file_exists($targetFile)) {
                $skipCount++;

                continue;
            }

            if ($isDryRun) {
                $this->info("  📋 Would sync: $relativePath");
                $syncCount++;
            } else {
                $targetDir = dirname($targetFile);
                if (! is_dir($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                if (copy($sourceFile, $targetFile)) {
                    @chmod($targetFile, 0644);
                    $syncCount++;

                    if ($syncCount % 10 === 0) {
                        $this->line("  📈 Synced $syncCount photos...");
                    }
                } else {
                    $this->error("  ❌ Failed: $relativePath");
                }
            }
        }

        $this->line("  📊 Gallery: $syncCount synced, $skipCount skipped");
    }
}
