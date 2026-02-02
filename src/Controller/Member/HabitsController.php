<?php
namespace App\Controller\Member;

use App\Repository\HabitRepository;
use App\Repository\HabitLogRepository;
use Mns\Buggy\Core\AbstractController;

class HabitsController extends AbstractController
{
    private HabitRepository $habitRepository;
    private HabitLogRepository $habitLogRepository;

    public function __construct()
    {
        $this->habitRepository = new HabitRepository();
        $this->habitLogRepository = new HabitLogRepository();
    }

    /**
     * Liste les habitudes de l'utilisateur
     */
    public function index()
    {

        $userId = $_SESSION['user']['id'];
        $habits = $this->habitRepository->findByUser($userId);

        return $this->render('member/habits/index.html.php', [
            'habits' => $habits,
        ]);
    }

    /**
     * Crée une nouvelle habitude
     */
    public function new()
    {
        $errors = [];

        if (!empty($_POST['habit'])) {
            // Validation CSRF
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $errors['csrf'] = 'Token CSRF invalide';
                return $this->render('member/habits/new.html.php', [
                    'errors' => $errors
                ]);
            }

            $habit = $_POST['habit'];

            if (empty($habit['name'])) {
                $errors['name'] = 'Le nom de l’habitude est obligatoire';
            }

            if (count($errors) === 0) {
                $this->habitRepository->insert([
                    'user_id' => $_SESSION['user']['id'],
                    'name' => $habit['name'],
                    'description' => $habit['description'] ?? null
                ]);

                header('Location: /habit');
                exit;
            }
        }

        return $this->render('member/habits/new.html.php', [
            'errors' => $errors
        ]);
    }

    /**
     * Marque ou décoche une habitude pour aujourd'hui
     */
    public function toggle()
    {
        // Validation CSRF
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('Location: /dashboard');
            exit;
        }

        if (!empty($_POST['habit_id'])) {
            $habitId = (int)$_POST['habit_id'];
            $this->habitLogRepository->toggleToday($habitId);
        }

        header('Location: /dashboard');
        exit;
    }
}
