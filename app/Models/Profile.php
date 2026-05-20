<?php

namespace App\Models;

class Profile extends Model {
    protected $table = 'profile';

    public function getProfile() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = 1");
        $stmt->execute();
        $profile = $stmt->fetch();

        // If not found (shouldn't happen because of migration, but fallback just in case)
        if (!$profile) {
            $defaultMissions = [
                'Menyajikan berita dan informasi lokal yang akurat, berimbang, dan tepercaya.',
                'Menyediakan program edukasi dan hiburan yang sehat serta membangun kreativitas lokal.',
                'Melestarikan seni, budaya, dan kearifan lokal Muaro Jambi.',
                'Menjadi wadah aspirasi dan interaksi sosial masyarakat secara inklusif.'
            ];
            $defaultCrew = [
                [
                    'name' => 'Junaedi (Djun)',
                    'role' => 'Station Manager & Founder',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
                    'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'facebook' => 'https://www.facebook.com/gibelfm/']
                ],
                [
                    'name' => 'Sarah Amelia',
                    'role' => 'Program Director & Announcer',
                    'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400',
                    'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'tiktok' => 'https://www.tiktok.com/@djun_23']
                ],
                [
                    'name' => 'Rian Hidayat',
                    'role' => 'Technical Coordinator',
                    'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400',
                    'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'facebook' => 'https://www.facebook.com/gibelfm/']
                ]
            ];

            return [
                'station_name' => 'GibelFm',
                'tagline' => 'The Spirit of Muaro Jambi',
                'description' => 'GibelFm adalah radio komunitas terkemuka di Muaro Jambi yang menyajikan informasi terkini, edukasi, hiburan, dan kebudayaan lokal secara interaktif dan dinamis untuk memajukan daerah.',
                'vision' => 'Menjadi media penyiaran komunitas terdepan dalam membangun masyarakat Muaro Jambi yang informatif, edukatif, dan berbudaya.',
                'missions' => json_encode($defaultMissions, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'crew' => json_encode($defaultCrew, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            ];
        }

        return $profile;
    }

    public function updateProfile($station_name, $tagline, $description, $vision, $missions, $crew) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET station_name = ?, tagline = ?, description = ?, vision = ?, missions = ?, crew = ? WHERE id = 1");
        return $stmt->execute([$station_name, $tagline, $description, $vision, $missions, $crew]);
    }
}
