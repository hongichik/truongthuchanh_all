<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HomeSetting;

class MigrateWebsiteConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:website-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from config/website.php to home_settings table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Lấy dữ liệu từ config/website.php
            $websiteConfig = config('website');
            
            if (empty($websiteConfig)) {
                $this->error('Config file website.php is empty or not found!');
                return 1;
            }

            // Lấy hoặc tạo home setting
            $homeSetting = HomeSetting::current();

            // Migrate header image
            if (isset($websiteConfig['header_image']['current'])) {
                $homeSetting->header_image = $websiteConfig['header_image']['current'];
            }

            // Migrate logo
            if (isset($websiteConfig['logo']['current'])) {
                $homeSetting->logo = $websiteConfig['logo']['current'];
            }

            // Migrate contact info
            if (isset($websiteConfig['contact_info'])) {
                $homeSetting->contact_info = [
                    'phone' => $websiteConfig['contact_info']['phone'] ?? '',
                    'email' => $websiteConfig['contact_info']['email'] ?? '',
                    'address' => $websiteConfig['contact_info']['address'] ?? ''
                ];
            }

            // Migrate school info
            if (isset($websiteConfig['school_info'])) {
                $homeSetting->school_info = [
                    'name' => $websiteConfig['school_info']['name'] ?? '',
                    'parent_organization' => $websiteConfig['school_info']['parent_organization'] ?? '',
                    'short_description' => $websiteConfig['school_info']['short_description'] ?? ''
                ];
            }

            // Migrate social links
            if (isset($websiteConfig['social_links'])) {
                $homeSetting->social_links = [
                    'facebook' => $websiteConfig['social_links']['facebook'] ?? '',
                    'youtube' => $websiteConfig['social_links']['youtube'] ?? '',
                    'website' => $websiteConfig['social_links']['website'] ?? ''
                ];
            }

            $homeSetting->save();

            $this->info('✅ Successfully migrated website config to home_settings table!');
            $this->info('📄 Data migrated:');
            $this->info("   - Header Image: {$homeSetting->header_image}");
            $this->info("   - Logo: {$homeSetting->logo}");
            $this->info("   - Phone: " . ($homeSetting->contact_info['phone'] ?? 'N/A'));
            $this->info("   - Email: " . ($homeSetting->contact_info['email'] ?? 'N/A'));
            $this->info("   - School Name: " . ($homeSetting->school_info['name'] ?? 'N/A'));
            
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error migrating website config: ' . $e->getMessage());
            return 1;
        }
    }
}