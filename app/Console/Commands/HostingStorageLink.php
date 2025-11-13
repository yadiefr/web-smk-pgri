<?php

namespace App\Console\Commands;

use App\Helpers\HostingStorageHelper;
use Illuminate\Console\Command;

class HostingStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:link-hosting 
                           {--force : Force recreation of symlink}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create storage symlink for hosting environment (public_html/storage -> project/storage/app/public)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔗 Hosting Storage Link Creator');
        $this->newLine();

        if (! HostingStorageHelper::isHostingEnvironment()) {
            $this->warn('⚠️  Not in hosting environment. This command is only for hosting.');

            return;
        }

        $paths = HostingStorageHelper::getHostingPaths();

        $this->info('📂 Detected paths:');
        $this->line("  Laravel Project: {$paths['laravel_project']}");
        $this->line("  Public HTML: {$paths['public_html']}");
        $this->line("  Source Storage: {$paths['current_storage']}");
        $this->newLine();

        $linkPath = $paths['public_html'].'/storage';
        $targetPath = $paths['current_storage'];

        // Check if link already exists
        if (is_link($linkPath)) {
            if ($this->option('force')) {
                unlink($linkPath);
                $this->info('🗑️  Removed existing symlink');
            } else {
                $this->warn('⚠️  Symlink already exists. Use --force to recreate.');

                return;
            }
        } elseif (is_dir($linkPath)) {
            $this->warn("⚠️  Directory $linkPath already exists. Please remove it manually.");

            return;
        }

        // Create symlink
        if (symlink($targetPath, $linkPath)) {
            $this->info("✅ Created symlink: $linkPath -> $targetPath");

            // Test symlink
            if (is_readable($linkPath)) {
                $this->info('✅ Symlink is readable');
            } else {
                $this->warn('⚠️  Symlink created but not readable. Check permissions.');
            }
        } else {
            $this->error('❌ Failed to create symlink');

            $this->newLine();
            $this->warn('💡 Manual steps:');
            $this->line('  1. SSH to your hosting');
            $this->line("  2. cd {$paths['public_html']}");
            $this->line("  3. ln -s {$targetPath} storage");
        }

        $this->newLine();
        $this->info('ℹ️  After creating symlink, run: php artisan storage:sync-hosting');
    }
}
