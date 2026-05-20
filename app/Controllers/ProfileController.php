<?php

namespace App\Controllers;

class ProfileController {
    public function index() {
        $profileModel = new \App\Models\Profile();
        $profile = $profileModel->getProfile();
        
        $station_name = $profile['station_name'];
        $tagline = $profile['tagline'];
        $description = $profile['description'];
        $vision = $profile['vision'];
        
        $missions = json_decode($profile['missions'], true);
        $crew = json_decode($profile['crew'], true);

        view('profile', [
            'title' => 'Profil Stasiun - GibelFm',
            'station_name' => $station_name,
            'tagline' => $tagline,
            'description' => $description,
            'vision' => $vision,
            'missions' => $missions,
            'crew' => $crew
        ]);
    }
}
