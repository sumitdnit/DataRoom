<?php
class NetworkTableSeeder extends Seeder{
    public function run()
    {
        DB::table('network')->delete();
        $data = array(
                    array(
                        'platform' => 'FACEBOOK',
                        'api_key' => '1567688963470672',
                        'secret_key' => 'e53971002215d7bd053c0d11dca0523b',
                        'scope' => 'email,publish_actions,manage_pages',
                    ),
                    array(
                        'platform' => 'TWITTER',
                        'api_key' => 'XMvmAuvdUjcgfKhFJaFB8KE85',
                        'secret_key' => 'BBWgQl5QXtqO3SIs8tj4jFVsqdeSejpsmg79VWBdoEyZDQbyJ7',
                        'scope' => '',
                    ),
                    array(
                        'platform' => 'LINKEDIN',
                        'api_key' => '78p01wil4xt1f2',
                        'secret_key' => '5MJ8SAQQ15IXGceu',
                        'scope' => '',
                    ),
                    array(
                        'platform' => 'FACEBOOK_PAGE',
                        'api_key' => '1567688963470672',
                        'secret_key' => 'e53971002215d7bd053c0d11dca0523b',
                        'scope' => '',
                    ),
                    array(
                        'platform' => 'YOUTUBE',
                        'api_key' => '556638105329-99jo5dtvaoih6fth12i1o7opf19e3c69.apps.googleusercontent.com',
                        'secret_key' => 'b9mEqOybgGNqBU8W5N6SId3K',
                        'scope' => 'https://www.googleapis.com/auth/userinfo.email,https://www.googleapis.com/auth/userinfo.profile,https://www.googleapis.com/auth/youtube,https://www.googleapis.com/auth/youtube.upload',
                    ),
                    array(
                        'platform' => 'LINKEDIN_COMPANY',
                        'api_key' => '78p01wil4xt1f2',
                        'secret_key' => '5MJ8SAQQ15IXGceu',
                        'scope' => '',
                    ),
                     array(
                        'platform' => 'WORDPRESS',
                        'api_key' => '',
                        'secret_key' => '',
                        'scope' => '',
                    ),
                   array(
                        'platform' => 'TUMBLR',
                        'api_key' => 'yNUSLxKTEsNwrg0jKGc7usUL14BZHZ4wmyWr0LqPh9TYjnccc1',
                        'secret_key' => 'TcsYdXdBXiiQDgB7y2Kx5qo8hokXMIOx5FwRVuJIQb6vb4LLHF',
                        'scope' => '',
                    ),
                );
        Network::insert($data);
    }
}