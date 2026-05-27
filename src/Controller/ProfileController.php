<?php
namespace App\Controller;

use App\Entity\User;
use App\Service\ProfileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileService $profileService,
        private EntityManagerInterface $em,
    ) {}

    // View any profile
    #[Route('/profile/{id}', name: 'app_profile_view', requirements: ['id' => '\d+'])]
    public function view(int $id): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $user = $this->profileService->getFullProfile($id);
        $isOwner = ($currentUser->getId() === $id);

        // Fetch recommendations where toUser = this user
        $recommendations = $this->em->getRepository(\App\Entity\Recommendation::class)
            ->findBy(['toUser' => $user]);

        return $this->render('profile/view.html.twig', [
            'user'            => $user,
            'isOwner'         => $isOwner,
            'recommendations' => $recommendations,
        ]);
    }

    // My profile — view + edit modal
    #[Route('/my-profile', name: 'app_my_profile')]
    public function myProfile(): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $user = $this->profileService->getFullProfile($currentUser->getId());

        $filieres = $this->em->getRepository(\App\Entity\Filiere::class)->findBy([], ['name' => 'ASC']);
        $parcours  = $this->em->getRepository(\App\Entity\Parcours::class)->findBy([], ['name' => 'ASC']);

        $recommendations = $this->em->getRepository(\App\Entity\Recommendation::class)
            ->findBy(['toUser' => $user]);

        return $this->render('profile/edit.html.twig', [
            'user'            => $user,
            'filieres'        => $filieres,
            'parcours'        => $parcours,
            'recommendations' => $recommendations,
        ]);
    }

    // Save profile (POST from modal form)
    #[Route('/my-profile/save', name: 'app_profile_save', methods: ['POST'])]
    public function save(Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        try {
            $this->profileService->saveProfile($currentUser, $request->request->all());
            $this->addFlash('success', 'Profile saved successfully!');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app_my_profile');
    }

    // Avatar upload
    #[Route('/my-profile/avatar', name: 'app_profile_avatar', methods: ['POST'])]
    public function uploadAvatar(Request $request): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $file = $request->files->get('avatar');

        if (!$file) {
            return $this->json(['ok' => false, 'message' => 'No file uploaded.'], 400);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return $this->json(['ok' => false, 'message' => 'Only image files are allowed.'], 400);
        }

        try {
            $avatarUrl = $this->profileService->uploadAvatar($currentUser, $file);
            return $this->json(['ok' => true, 'avatarUrl' => $avatarUrl]);
        } catch (\Exception $e) {
            return $this->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Add recommendation
    #[Route('/profile/{id}/recommend', name: 'app_profile_recommend', methods: ['POST'])]
    public function recommend(int $id, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $toUser = $this->profileService->getFullProfile($id);

        try {
            $this->profileService->addRecommendation(
                $currentUser,
                $toUser,
                $request->request->get('texte', '')
            );
            $this->addFlash('success', 'Recommendation sent!');
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app_profile_view', ['id' => $id]);
    }
}
