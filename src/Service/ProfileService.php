<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Skill;
use App\Entity\UserSkills;
use App\Entity\Experience;
use App\Entity\Project;
use App\Entity\Achievement;
use App\Entity\Recommendation;
use App\Enum\ExperienceType;
use App\Enum\AchievementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileService
{
    public function __construct(
        private EntityManagerInterface $em,
        private SluggerInterface $slugger,
        private string $avatarUploadDir,
    ) {}

    public function getFullProfile(int $userId): User
    {
        $user = $this->em->getRepository(User::class)->find($userId);
        if (!$user) {
            throw new \RuntimeException('User not found.');
        }
        return $user;
    }

    public function saveProfile(User $user, array $data): void
    {
        $insatien = $user->getInsatien();

        $user->setBio($data['bio'] ?? null);
        $user->setTagline($data['tagline'] ?? null);
        $user->setGithubLink($data['github_link'] ?? null);
        $user->setLinkedinLink($data['linkedin_link'] ?? null);
        $user->setProfileLink($data['profile_link'] ?? null);

        if ($insatien) {
            $insatien->setNom($data['nom'] ?? $insatien->getNom());
            $insatien->setPrenom($data['prenom'] ?? $insatien->getPrenom());
            $insatien->setPromoYear(
                isset($data['promo_year']) && $data['promo_year'] !== ''
                    ? (int) $data['promo_year']
                    : null
            );
        }

        $this->syncSkills($user, $data['skills'] ?? []);
        $this->syncExperiences($user, $data['experiences'] ?? []);
        $this->syncProjects($user, $data['projects'] ?? []);
        $this->syncAchievements($user, $data['achievements'] ?? []);

        $this->em->flush();
    }

    private function syncSkills(User $user, array $skillNames): void
    {
        // Remove old UserSkills entries
        foreach ($user->getUserSkills() as $userSkill) {
            $this->em->remove($userSkill);
        }
        $user->getUserSkills()->clear();

        foreach ($skillNames as $name) {
            $name = trim($name);
            if (!$name) continue;

            $skill = $this->em->getRepository(Skill::class)->findOneBy(['name' => $name]);
            if (!$skill) {
                $skill = new Skill();
                $skill->setName($name);
                $this->em->persist($skill);
            }

            $userSkill = new UserSkills();
            $userSkill->setUser($user);
            $userSkill->setSkill($skill);
            $this->em->persist($userSkill);
        }
    }

    private function syncExperiences(User $user, array $experiences): void
    {
        foreach ($user->getExperiences() as $exp) {
            $this->em->remove($exp);
        }
        $user->getExperiences()->clear();

        foreach ($experiences as $expData) {
            $exp = new Experience();
            $exp->setUser($user);
            $exp->setEntreprise($expData['entreprise'] ?? null);

            $expTypeStr = $expData['experience_type'] ?? 'job';
            $exp->setExperienceType(ExperienceType::from($expTypeStr));

            $exp->setDateDebut(
                !empty($expData['date_debut'])
                    ? new \DateTime($expData['date_debut'])
                    : null
            );
            $exp->setDateFin(
                !empty($expData['date_fin'])
                    ? new \DateTime($expData['date_fin'])
                    : null
            );
            $exp->setDescription($expData['description'] ?? null);
            $exp->setLien($expData['lien'] ?? null);
            $this->em->persist($exp);
        }
    }

    private function syncProjects(User $user, array $projects): void
    {
        foreach ($user->getProjects() as $proj) {
            $this->em->remove($proj);
        }
        $user->getProjects()->clear();

        foreach ($projects as $projData) {
            if (empty($projData['title'])) continue;
            $proj = new Project();
            $proj->setUser($user);
            $proj->setTitle($projData['title']);
            $proj->setDescription($projData['description'] ?? null);
            $proj->setLien($projData['lien'] ?? '');
            $proj->setDateDebut(
                !empty($projData['date_debut'])
                    ? new \DateTime($projData['date_debut'])
                    : null
            );
            $proj->setDateFin(
                !empty($projData['date_fin'])
                    ? new \DateTime($projData['date_fin'])
                    : null
            );
            $this->em->persist($proj);
        }
    }

    private function syncAchievements(User $user, array $achievements): void
    {
        foreach ($user->getAchievements() as $ach) {
            $this->em->remove($ach);
        }
        $user->getAchievements()->clear();

        foreach ($achievements as $achData) {
            if (empty($achData['title'])) continue;
            $ach = new Achievement();
            $ach->setUser($user);
            $ach->setTitle($achData['title']);
            $ach->setIssuer($achData['issuer'] ?? null);

            $achTypeStr = $achData['achievement_type'] ?? 'other';
            $ach->setAchievementType(AchievementType::from($achTypeStr));

            $ach->setDateObtained(
                !empty($achData['date_obtained'])
                    ? new \DateTime($achData['date_obtained'])
                    : null
            );
            $ach->setDescription($achData['description'] ?? null);
            $ach->setLien($achData['lien'] ?? null);
            $this->em->persist($ach);
        }
    }

    public function addRecommendation(User $fromUser, User $toUser, string $text): void
    {
        if ($fromUser->getId() === $toUser->getId()) {
            throw new \RuntimeException('You cannot recommend yourself.');
        }

        $text = trim($text);
        if (empty($text)) {
            throw new \RuntimeException('Recommendation text cannot be empty.');
        }

        $rec = new Recommendation();
        $rec->setFromUser($fromUser);
        $rec->setToUser($toUser);
        $rec->setTexte($text);
        $this->em->persist($rec);
        $this->em->flush();
    }

    public function uploadAvatar(User $user, UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->avatarUploadDir, $newFilename);

        $avatarUrl = '/uploads/avatars/' . $newFilename;
        $user->setAvatarUrl($avatarUrl);
        $this->em->flush();

        return $avatarUrl;
    }
}
